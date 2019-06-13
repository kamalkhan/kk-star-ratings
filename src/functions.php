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

function getOptions(array $merge = [])
{
    return array_merge_recursive([
        'kksr_ver' => get_option('kksr_ver', KKSR_VERSION),
        'kksr_stars' => (int) get_option('kksr_stars', 5),
        'kksr_enable' => (bool) get_option('kksr_enable', true),
        'kksr_strategies' => (array) get_option('kksr_strategies', []),
        'kksr_position' => get_option('kksr_position', 'top-left'),
        'kksr_exclude_locations' => (array) get_option('kksr_exclude_locations', []),
        'kksr_exclude_categories' => (array) get_option('kksr_exclude_categories', []),
    ], $merge);
}

function saveOptions(array $options)
{
    foreach ($options as $key => $value) {
        update_option($key, $value);
    }

    return $options;
}

function upgradeOptions(array $merge = [])
{
    saveOptions(array_merge_recursive([
        'kksr_strategies' => get_option('kksr_strategies', array_filter([
            get_option('kksr_unique', true) ? 'unique' : null,
            get_option('kksr_disable_in_archives', true) ? null : 'archives',
        ])),
        'kksr_exclude_locations' => get_option('kksr_exclude_locations', array_filter([
            get_option('kksr_show_in_home', true) ? null : 'home',
            get_option('kksr_show_in_posts', true) ? null : 'post',
            get_option('kksr_show_in_pages', true) ? null : 'page',
            get_option('kksr_show_in_archives', true) ? null : 'archives',
        ])),
        'kksr_exclude_categories' => is_array($exludedCategories = get_option('kksr_exclude_categories', []))
            ? $exludedCategories : array_map('trim', explode(',', $exludedCategories)),
    ], $merge));
}

function upgradeRatings()
{
    global $wpdb;
    $postMetaTable = $wpdb->prefix.'postmeta';

    $rows = $wpdb->get_results("
        SELECT a.ID, b.meta_value as ratings
        FROM {$wpdb->posts} a, {$postMetaTable} b
        WHERE a.ID=b.post_id AND b.meta_key='_kksr_ratings'
    ");

    $stars = get_option('kksr_stars', 5);

    foreach ($rows as $row) {
        update_post_meta(
            $row->ID,
            '_kksr_ratings',
            toNormalizedRatings($row->ratings, $stars)
        );
    }
}

function isValidPost($p = null)
{
    global $post;
    $p = $p ?: $post;

    if ($status = get_post_meta($p->ID, '_kksr_status', true)) {
        // Exclusive status.
        return $status == 'enable';
    }

    $categories = array_map(function ($category) {
        return $category->term_id;
    }, get_the_category($p->ID));

    $categoriesDiff = array_diff($categories, get_option('kksr_exclude_categories', []));

    return ($type = get_post_type($p))
        // post does not belong to an excluded category.
        && count($categories) == count($categoriesDiff)
        // post type is not an excluded location.
        && ! in_array($type, get_option('kksr_exclude_locations', []));
}

function isValidRequest()
{
    return (bool) (
        // home or front page AND home is not an excluded location.
        (! in_array('home', get_option('kksr_exclude_locations', [])) && (is_front_page() || is_home()))
        // archives AND archives is not an excluded location.
        || (! in_array('archives', get_option('kksr_exclude_locations', [])) && is_archive())
        // singular AND (exclusively enabled OR (post does not belong to an excluded category AND post type is not an excluded location)).
        || (is_singular() && isValidPost())
    );
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

// Admin

function getAdminTabs()
{
    return [
        'general' => __('General', 'kk-star-ratings'),
        'rich-snippets' => __('Rich Snippets', 'kk-star-ratings'),
        'appearance' => __('Appearance', 'kk-star-ratings'),
        'developers' => __('Developers', 'kk-star-ratings'),
        'support' => __('Support', 'kk-star-ratings'),
    ];
}

function getDefaultAdminTab()
{
    return 'general';
}

function getActiveAdminTab()
{
    $defaultTab = getDefaultAdminTab();

    if (! isset($_GET['tab'])) {
        return $defaultTab;
    }

    $tab = $_GET['tab'];

    if (empty($tab)) {
        return $defaultTab;
    }

    $tabs = getAdminTabs();

    if (isset($tabs[$tab])) {
        return $tab;
    }
}

function isActiveAdminTab($tab)
{
    return $tab == getActiveAdminTab();
}
