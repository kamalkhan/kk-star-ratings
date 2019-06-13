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

add_action('wp_enqueue_scripts', KKSR_NAMESPACE.'styles'); function styles()
{
    if (isRequired()) {
        wp_enqueue_style(
            KKSR_SLUG,
            KKSR_URI.'css/kk-star-ratings.css',
            [],
            KKSR_VERSION
        );
    }
}

add_action('wp_enqueue_scripts', KKSR_NAMESPACE.'scripts'); function scripts()
{
    if (isRequired()) {
        wp_enqueue_script(
            KKSR_SLUG,
            KKSR_URI.'js/kk-star-ratings.js',
            ['jquery'],
            KKSR_VERSION,
            true
        );
    }
}
