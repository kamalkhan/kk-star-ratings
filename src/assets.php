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

add_action('wp_enqueue_scripts', __NAMESPACE__.'\styles');
function styles($hook)
{
    if (! get_option(prefix('enable'))) {
        return;
    }

    wp_enqueue_style(
        config('slug'),
        config('url').'public/css/kk-star-ratings.css',
        [],
        config('version')
    );

    // wp_add_inline_style(config('slug'), '');
}

add_action('wp_enqueue_scripts', __NAMESPACE__.'\scripts');
function scripts($hook)
{
    if (! get_option(prefix('enable'))) {
        return;
    }

    wp_enqueue_script(
        config('slug'),
        config('url').'public/js/kk-star-ratings.js',
        ['jquery'],
        config('version'),
        true
    );

    wp_localize_script(
        config('slug'),
        str_replace('-', '_', config('slug')),
        [
            'action' => config('slug'),
            'endpoint' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce(config('slug').'-ajax'),
        ]
    );

    // wp_add_inline_script(config('slug'), '');
}
