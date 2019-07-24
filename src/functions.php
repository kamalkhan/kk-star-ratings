<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * This source file is subject to the GPL v2 license that
 * is bundled with this source code in the file LICENSE.
 */

namespace Bhittani\StarRating;

function options()
{
    return [
        'ver' => KKSR_VERSION,
        // General
        'enable' => true,
        'position' => 'top-left',
        'manual_control' => [],
        'exclude_locations' => [],
        'exclude_categories' => [],
        'strategies' => ['guests', 'unique'],
        // Rich Snippets
        'grs' => true,
        'sd_type' => 'CreativeWork',
        'sd_context' => 'https://schema.org/',
        // Appearance
        'stars' => 5,
        'size' => 22,
        'fill_color_star' => '#ffffff',
        'stroke_color_star' => '#555555',
        'fill_color_active_star' => '#fb9005',
        'stroke_color_active_star' => '#2c1901',
        'fill_color_hover_star' => '#fffb00',
        'stroke_color_hover_star' => '#201f00',
    ];
}

function stripPrefix($key)
{
    return strpos($key, KKSR_PREFIX) === 0 ? substr($key, 5) : $key;
}

function prefix($key)
{
    return KKSR_PREFIX.stripPrefix($key);
}

function getDefaultOption($key, $fallback = null)
{
    $options = options();

    $value = array_key_exists($key, $options) ? $options[$key] : $fallback;

    $value = apply_filters(prefix('default_option:'.$key), $value);

    return apply_filters(prefix('default_option'), $value, $key);
}

function getDefaultOptions($key = null, $fallback = null)
{
    return is_null($key)
        ? apply_filters(prefix('default_options'), options())
        : getDefaultOption($key, $fallback);
}

function getOption($key, $default = null)
{
    if (($value = get_option(prefix($key))) === false) {
        $value = is_null($default) ? getDefaultOption($key) : $default;
    }

    $value = apply_filters(prefix('option:'.$key), $value);

    return apply_filters(prefix('option'), $value, $key);
}

function getOptions($key = null, $default = null)
{
    if (! is_null($key)) {
        return getOption($key, $default);
    }

    $options = [];

    foreach (array_keys(getDefaultOptions()) as $key) {
        $options[$key] = getOption($key);
    }

    return apply_filters(prefix('options'), $options);
}

function saveOption($key, $value)
{
    update_option(prefix($key), $value);

    return $value;
}

function saveOptions(array $options)
{
    foreach ($options as $key => $value) {
        saveOption($key, $value);
    }

    return $options;
}

function upgradeOptions(array $merge = [])
{
    saveOptions(array_merge_recursive([
        // General
        'strategies' => getOption('strategies', array_filter([
            'guests',
            getOption('unique', true) ? 'unique' : null,
            getOption('disable_in_archives', true) ? null : 'archives',
        ])),
        'exclude_locations' => getOption('exclude_locations', array_filter([
            getOption('show_in_home', true) ? null : 'home',
            getOption('show_in_posts', true) ? null : 'post',
            getOption('show_in_pages', true) ? null : 'page',
            getOption('show_in_archives', true) ? null : 'archives',
        ])),
        'exclude_categories' => is_array($exludedCategories = getOption('exclude_categories', []))
            ? $exludedCategories : array_map('trim', explode(',', $exludedCategories)),
        // Rich Snippets
        // ...
    ], $merge));
}

function upgradeRatings()
{
    global $wpdb;

    // Normalize ratings.

    $stars = getOption('stars');

    $rows = $wpdb->get_results("
        SELECT posts.ID, postmeta_avg.meta_value as avg, postmeta_casts.meta_value as casts
        FROM {$wpdb->posts} posts
        JOIN {$wpdb->postmeta} postmeta_avg ON posts.ID = postmeta_avg.post_id
        JOIN {$wpdb->postmeta} postmeta_casts ON posts.ID = postmeta_casts.post_id
        WHERE postmeta_avg.meta_key = '_kksr_avg' AND postmeta_casts.meta_key = '_kksr_casts'
    ");

    foreach ($rows as $row) {
        update_post_meta(
            $row->ID,
            '_'.prefix('ratings'),
            scoreToRatings($row->avg, $row->casts, $stars)
        );
    }

    // Truncate IP addresses.

    $wpdb->delete($wpdb->postmeta, ['meta_key' => '_kksr_ips']);
}

function canVote($p = null)
{
    global $post;
    $p = $p ?: $post;

    $filterTag = prefix('can_vote');
    $strategies = getOption('strategies');

    // Archives and voting in archives is not allowed.
    if (is_archive() && ! in_array('archives', $strategies)) {
        return apply_filters($filterTag, false, $p);
    }

    // Not authenticated and guests are not allowed to vote.
    if (! is_user_logged_in() && ! in_array('guests', $strategies)) {
        return apply_filters($filterTag, false, $p);
    }

    // Unique ips are enforced.
    if (in_array('unique', $strategies)) {
        $ips = get_post_meta($p->ID, '_'.prefix('ips'));

        // Not a unique IP address.
        if (in_array(md5($_SERVER['REMOTE_ADDR']), $ips)) {
            return apply_filters($filterTag, false, $p);
        }
    }

    return apply_filters($filterTag, true, $p);
}

// function force($bool = true)
// {
//     static $isForced;

//     if (! is_null($bool)) {
//         $isForced = (bool) $bool;
//     }

//     return (bool) $isForced;
// }

// function isForced()
// {
//     return force(null);
// }

function isValidPost($p = null)
{
    $bail = $p === false;

    global $post;
    $p = $p ?: $post;
    $p = is_object($p) ? $p : get_post($p);

    $filterTag = prefix('is_valid_post');

    if (! getOption('enable')) {
        // Not globally enabled.
        return apply_filters($filterTag, false, $p);
    }

    // if (isForced()) {
    //     // Manually forced.
    //     return apply_filters($filterTag, true, $p);
    // }

    if ($bail && (
        has_shortcode($p->post_content, KKSR_SHORTCODE)
            || has_shortcode($p->post_content, 'kkratings')
    )) {
        return apply_filters($filterTag, false, $p);
    }

    if ($status = get_post_meta($p->ID, '_'.prefix('status'), true)) {
        // Exclusive status.
        return apply_filters($filterTag, $status == 'enable', $p);
    }

    $categories = array_map(function ($category) {
        return $category->term_id;
    }, get_the_category($p->ID));

    $excludedCategories = getOption('exclude_categories', []);
    $excludedCategories = is_array($excludedCategories) ? $excludedCategories : [];

    $categoriesDiff = array_diff($categories, $excludedCategories);

    $bool = ($type = get_post_type($p))
        // post does not belong to an excluded category.
        && count($categories) == count($categoriesDiff)
        // post type is not an excluded location.
        && ! in_array($type, getOption('exclude_locations'));

    return apply_filters($filterTag, $bool, $p);
}

function isValidRequest($p = null)
{
    $filterTag = prefix('is_valid_request');

    if (! getOption('enable')) {
        // Not globally enabled.
        return apply_filters($filterTag, false);
    }

    // if (isForced()) {
    //     // Manually forced.
    //     return apply_filters($filterTag, true);
    // }

    $bool =
        // home or front page AND home is not an excluded location.
        (! in_array('home', getOption('exclude_locations')) && (is_front_page() || is_home()))
        // archives AND archives is not an excluded location.
        || (! in_array('archives', getOption('exclude_locations')) && is_archive())
        // singular AND (exclusively enabled OR (post does not belong to an excluded category AND post type is not an excluded location)).
        || (is_singular() && isValidPost($p));

    return apply_filters($filterTag, $bool);
}

// Calculations

function toNormalizedRatings($ratings, $from = 5, $to = 5)
{
    $to = (int) $to;
    $from = (int) $from;
    $ratings = (float) $ratings;

    return $ratings / $from * $to; // $ratings / ($from / $to);
}

function calculateScore($total, $count, $from = 5, $to = 5)
{
    $to = (int) $to;
    $from = (int) $from;
    $count = (float) $count;
    $total = (float) $total;

    return $count ? round(($total / $count) * ($from / $to), 1, PHP_ROUND_HALF_DOWN) : 0;
}

// We will neglect $from but here for consistency!
function calculatePercentage($total, $count, $from = 5, $to = 5)
{
    $to = (int) $to;
    $from = (int) $from;
    $count = (float) $count;
    $total = (float) $total;

    return $count ? round($total / $count / $to * 100, 2, PHP_ROUND_HALF_DOWN) : 0;
}

function calculateWidth($score, $size = null, $pad = 4)
{
    $score = (float) $score;
    $size = (int) ($size ?: getOption('size'));

    return $score * $size + $score * $pad;
}

function scoreToRatings($score, $count, $from = 5, $to = 5)
{
    $to = (int) $to;
    $from = (int) $from;
    $count = (int) $count;
    $score = (float) $score;

    if ($from <= 0 || $to <= 0) {
        return 0;
    }

    if ($score < 0) {
        $score = 1;
    }

    if ($score > $from) {
        $score = $from;
    }

    return (float) round($score * $count / ($from / $to), 0, PHP_ROUND_HALF_DOWN);
}

function extractPosition($position = null)
{
    $position = $position ?: getOption('position');

    $placement = 'top';
    $alignment = 'left';

    if (strpos($position, 'top-') === 0) {
        $placement = 'top';
        $alignment = substr($position, 4);
    } elseif (strpos($position, 'bottom-') === 0) {
        $placement = 'bottom';
        $alignment = substr($position, 7);
    }

    return [$placement, $alignment];
}

function vote($idOrPost, $rating)
{
    $stars = (int) getOption('stars');
    $rating = apply_filters(prefix('rating'), (float) $rating);
    $id = is_object($idOrPost) ? $idOrPost->ID : $idOrPost;

    if ($rating < 0 || $rating > $stars) {
        throw new \Exception(sprintf(
            __('You can only rate between 0 and %s.', 'kk-star-ratings'),
            $stars
        ));
    }

    $ratings = (float) get_post_meta($id, '_'.prefix('ratings'), true);
    $ratings += toNormalizedRatings($rating, $stars);

    $count = (int) get_post_meta($id, '_'.prefix('casts'), true);
    $count += 1;

    update_post_meta($id, '_'.prefix('ratings'), $ratings);
    update_post_meta($id, '_'.prefix('casts'), $count);
    // For legacy reasons.
    update_post_meta($id, '_'.prefix('avg'), calculateScore($ratings, $count, $stars));

    do_action(prefix('vote'), $id, $rating);

    return [$ratings, $count];
}

function queue($post = null)
{
    // static $queued;

    // if ($queued) {
    //     return;
    // }

    styles(true);
    scripts(true);
    stylesheet(true);

    $sd = function () use ($post) {
        echo structuredData(true, $post);
    };

    if (! has_action('wp_footer', $sd)) {
        add_action('wp_footer', $sd);
    }

    // $queued = true;
}

function get($post = null, $force = null)
{
    $force = is_null($force) ? ($post ? true : false) : $force;

    if ($force) {
        queue($post);
    }

    return markup(null, $force, $post);
}

function quick($atts, $shortcode = '')
{
    extract(shortcode_atts(['id' => null, 'force' => null], $atts, $shortcode));

    $force = is_null($force)
        ? (in_array('force', (array) $atts) ? true : null)
        : (in_array($force, ['null', 'false']) ? false : (bool) $force);

    return get($id ?: false, $force);
}

function collect($limit = 5, $taxonomyId = null, $offset = 0)
{
    global $wpdb;
    $postsTable = $wpdb->posts;
    $postMetaTable = $wpdb->prefix.'postmeta';
    $base = getOption('stars') / 5;

    $querySelect = "
        SELECT
            posts.ID,
            ROUND(postmeta_ratings.meta_value / postmeta_count.meta_value * %f, 1) score
        FROM {$postsTable} posts
    ";

    $queryJoins = "
        JOIN {$postMetaTable} postmeta_ratings
            ON posts.ID = postmeta_ratings.post_id
        JOIN {$postMetaTable} postmeta_count
            ON posts.ID = postmeta_count.post_id
    ";

    $queryConditions = "
        WHERE
            posts.post_status = 'publish'
            AND CAST(postmeta_count.meta_value AS UNSIGNED) != 0
            AND postmeta_count.meta_key = '_kksr_casts'
            AND postmeta_ratings.meta_key = '_kksr_ratings'
    ";

    $queryOrder = '
        ORDER BY
            score DESC,
            CAST(postmeta_count.meta_value AS UNSIGNED) DESC
    ';

    $queryLimit = 'LIMIT %d, %d';

    $queryArgs = [$base, $offset, $limit];

    if ($taxonomyId) {
        $termTaxonomyTable = $wpdb->prefix.'term_taxonomy';
        $termRelationshipsTable = $wpdb->prefix.'term_relationships';

        $queryJoins .= "
            JOIN {$termRelationshipsTable} term_relations
                ON posts.ID = term_relations.object_id
            JOIN {$termTaxonomyTable} term_taxonomies
                ON term_relations.term_taxonomy_id = term_taxonomies.term_taxonomy_id
        ";

        $queryConditions .= '
            AND term_taxonomies.term_id=%d
        ';

        $queryArgs = [$base, $taxonomyId, $offset, $limit];
    }

    $query = $querySelect
        .PHP_EOL.$queryJoins
        .PHP_EOL.$queryConditions
        .PHP_EOL.$queryOrder
        .PHP_EOL.$queryLimit;

    $preparedQuery = call_user_func_array([$wpdb, 'prepare'], array_merge([$query], $queryArgs));

    return $wpdb->get_results($preparedQuery);
}

// Admin

function getAdminTabs()
{
    return apply_filters(prefix('admin_tabs'), [
        'general' => __('General', 'kk-star-ratings'),
        'rich-snippets' => __('Rich Snippets', 'kk-star-ratings'),
        'appearance' => __('Appearance', 'kk-star-ratings'),
    ]);
}

function getDefaultAdminTab()
{
    return apply_filters(prefix('default_admin_tab'), 'general');
}

function getActiveAdminTab()
{
    $filterTag = prefix('active_admin_tab');

    $defaultTab = getDefaultAdminTab();

    if (! isset($_GET['tab'])) {
        return apply_filters($filterTag, $defaultTab);
    }

    $tab = $_GET['tab'];

    if (empty($tab)) {
        return apply_filters($filterTag, $defaultTab);
    }

    $tabs = getAdminTabs();

    if (isset($tabs[$tab])) {
        return apply_filters($filterTag, $tab);
    }

    return apply_filters($filterTag, null);
}

function isActiveAdminTab($tab)
{
    return apply_filters(prefix('is_active_admin_tab'), $tab == getActiveAdminTab());
}
