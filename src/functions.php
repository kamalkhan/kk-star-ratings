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
    $options = KKSR_OPTIONS;

    $value = array_key_exists($key, $options) ? $options[$key] : $fallback;

    $value = apply_filters(prefix('default_option:'.$key), $value);

    return apply_filters(prefix('default_option'), $value, $key);
}

function getDefaultOptions($key = null, $fallback = null)
{
    return is_null($key)
        ? apply_filters(prefix('default_options'), KKSR_OPTIONS)
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

    foreach (array_keys(KKSR_OPTIONS) as $key) {
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
    $postMetaTable = $wpdb->prefix.'postmeta';

    // Normalize ratings.

    $stars = getOption('stars');

    $rows = $wpdb->get_results("
        SELECT a.ID, b.meta_value as ratings
        FROM {$wpdb->posts} a, {$postMetaTable} b
        WHERE a.ID=b.post_id AND b.meta_key='_kksr_ratings'
    ");

    foreach ($rows as $row) {
        update_post_meta(
            $row->ID,
            '_'.prefix('ratings'),
            toNormalizedRatings($row->ratings, $stars)
        );
    }

    // Casts => Count.

    $rows = $wpdb->get_results("
        SELECT a.ID, b.meta_value as casts
        FROM {$wpdb->posts} a, {$postMetaTable} b
        WHERE a.ID=b.post_id AND b.meta_key='_kksr_casts'
    ");

    foreach ($rows as $row) {
        update_post_meta($row->ID, '_'.prefix('count'), $row->casts);
    }

    $wpdb->delete($postMetaTable, ['meta_key' => '_kksr_casts']);

    // Truncate IP addresses.

    $wpdb->delete($postMetaTable, ['meta_key' => '_kksr_ips']);
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

function isValidPost($p = null)
{
    global $post;
    $p = $p ?: $post;

    $filterTag = prefix('is_valid_post');

    if (! getOption('enable')) {
        // Not globally enabled.
        return apply_filters($filterTag, false, $p);
    }

    if ($status = get_post_meta($p->ID, '_'.prefix('status'), true)) {
        // Exclusive status.
        return apply_filters($filterTag, $status == 'enable', $p);
    }

    $categories = array_map(function ($category) {
        return $category->term_id;
    }, get_the_category($p->ID));

    $categoriesDiff = array_diff($categories, getOption('exclude_categories'));

    $bool = ($type = get_post_type($p))
        // post does not belong to an excluded category.
        && count($categories) == count($categoriesDiff)
        // post type is not an excluded location.
        && ! in_array($type, getOption('exclude_locations'));

    return apply_filters($filterTag, $bool, $p);
}

function isValidRequest()
{
    $filterTag = prefix('is_valid_request');

    if (! getOption('enable')) {
        // Not globally enabled.
        return apply_filters($filterTag, false);
    }

    $bool =
        // home or front page AND home is not an excluded location.
        (! in_array('home', getOption('exclude_locations')) && (is_front_page() || is_home()))
        // archives AND archives is not an excluded location.
        || (! in_array('archives', getOption('exclude_locations')) && is_archive())
        // singular AND (exclusively enabled OR (post does not belong to an excluded category AND post type is not an excluded location)).
        || (is_singular() && isValidPost());

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

    $count = (int) get_post_meta($id, '_'.prefix('count'), true);
    $count += 1;

    update_post_meta($id, '_'.prefix('ratings'), $ratings);
    update_post_meta($id, '_'.prefix('count'), $count);

    do_action(prefix('vote'), $id, $rating);

    return [$ratings, $count];
}

// Admin

function getAdminTabs()
{
    return apply_filters(prefix('admin_tabs'), [
        'general' => __('General', 'kk-star-ratings'),
        'rich-snippets' => __('Rich Snippets', 'kk-star-ratings'),
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
