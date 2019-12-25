<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating;

if (! defined('ABSPATH')) {
    http_response_code(404);
    die();
}

register_activation_hook(config('file'), __NAMESPACE__.'\activation');
function activation()
{
    $version = config('version');
    $previous = get_option(prefix('ver'));

    if (! $previous) {
        do_plugin_action('install', $version);
    } elseif (version_compare($previous, '3.0.0', '>')) {
        do_plugin_action('activate', $version, $previous);
    } else {
        do_plugin_action('upgrade', $version, $previous);
    }

    update_option(prefix('ver'), $version);
}

add_plugin_action('install', __NAMESPACE__.'\save_options', 9);
function save_options($version)
{
    foreach (config('options') as $key => $value) {
        update_option(prefix($key), $value);
    }
}

add_plugin_action('activate', __NAMESPACE__.'\sync_options', 9, 2);
function sync_options($version, $previous)
{
    foreach (config('options') as $k => $v) {
        $value = get_option(prefix($k));

        if (! $value && ! is_bool($v)) {
            $value = $v;
        }

        update_option(prefix($k), $value);
    }
}

add_plugin_action('upgrade', __NAMESPACE__.'\upgrade_options', 9, 2);
function upgrade_options($version, $previous)
{
    $options = [
        'strategies' => get_option(prefix('strategies'), array_filter([
            'guests',
            get_option(prefix('unique')) ? 'unique' : null,
            get_option(prefix('disable_in_archives'), true) ? null : 'archives',
        ])),
        'exclude_locations' => get_option(prefix('exclude_locations'), array_filter([
            get_option(prefix('show_in_home'), true) ? null : 'home',
            get_option(prefix('show_in_posts'), true) ? null : 'post',
            get_option(prefix('show_in_pages'), true) ? null : 'page',
            get_option(prefix('show_in_archives'), true) ? null : 'archives',
        ])),
        'exclude_categories' => is_array($exludedCategories = get_option(prefix('exclude_categories'), []))
            ? $exludedCategories : array_map('trim', explode(',', $exludedCategories)),
    ];

    foreach ($options as $key => $value) {
        update_option(prefix($key), $value);
    }
}

add_plugin_action('upgrade', __NAMESPACE__.'\upgrade_posts', 9, 2);
function upgrade_posts($version, $previous)
{
    global $wpdb;

    // Truncate IP addresses.
    $wpdb->delete($wpdb->postmeta, ['meta_key' => meta_prefix('ips')]);

    // Normalize post ratings.

    $rows = $wpdb->get_results("
        SELECT posts.ID, postmeta_avg.meta_value as avg, postmeta_casts.meta_value as casts
        FROM {$wpdb->posts} posts
        JOIN {$wpdb->postmeta} postmeta_avg ON posts.ID = postmeta_avg.post_id
        JOIN {$wpdb->postmeta} postmeta_casts ON posts.ID = postmeta_casts.post_id
        WHERE postmeta_avg.meta_key = '_kksr_avg' AND postmeta_casts.meta_key = '_kksr_casts'
    ");

    $stars = get_option(prefix('stars'));
    $stars = max((int) $stars, 1);

    foreach ($rows as $row) {
        $count = max((int) $row->casts, 0);
        $score = min(max($row->avg, 0), $stars);
        $ratings = $score * $count / $stars * 5;

        update_post_meta(
            $row->ID,
            meta_prefix('ratings'),
            round($ratings, 0, PHP_ROUND_HALF_DOWN)
        );
    }
}
