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

add_action('wp_enqueue_scripts', KKSR_NAMESPACE.'styles'); function styles($force = false)
{
    if ($force || isValidRequest()) {
        wp_enqueue_style(
            KKSR_SLUG,
            KKSR_URI.'css/kk-star-ratings.css',
            [],
            KKSR_VERSION
        );
    }
}

add_action('wp_enqueue_scripts', KKSR_NAMESPACE.'scripts'); function scripts($force = false)
{
    if ($force || isValidRequest()) {
        wp_enqueue_script(
            KKSR_SLUG,
            KKSR_URI.'js/kk-star-ratings.js',
            ['jquery'],
            KKSR_VERSION,
            true
        );

        wp_localize_script(
            KKSR_SLUG,
            str_replace('-', '_', KKSR_SLUG),
            [
                'nonce' => wp_create_nonce(KKSR_SLUG),
                'endpoint' => admin_url('admin-ajax.php'),
            ]
        );
    }
}

add_action('wp_enqueue_scripts', KKSR_NAMESPACE.'stylesheet'); function stylesheet($force = false)
{
    if (! ($force || isValidRequest())) {
        return;
    }

    $size = getOption('size');

    $colors = [
        'default' => [
            'fill' => getOption('fill_color_star'),
            'stroke' => getOption('stroke_color_star'),
        ],
        'active' => [
            'fill' => getOption('fill_color_active_star'),
            'stroke' => getOption('stroke_color_active_star'),
        ],
        'hover' => [
            'fill' => getOption('fill_color_hover_star'),
            'stroke' => getOption('stroke_color_hover_star'),
        ],
    ];

    ob_start();
    include KKSR_PATH_PUBLIC.'css/kk-star-ratings.css.php';
    $stylesheet = ob_get_clean();

    wp_add_inline_style(KKSR_SLUG, apply_filters(prefix('stylesheet'), $stylesheet));
}
