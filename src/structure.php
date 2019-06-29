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

add_action('wp_head', KKSR_NAMESPACE.'structuredData'); function structuredData()
{
    if (! get_option('kksr_grs', 0)) {
        return;
    }

    if (! (isValidRequest() && is_singular())) {
        return;
    }

    global $post;

    $id = $post->ID;
    $count = (int) get_post_meta($id, '_kksr_count', true);

    if (! $count) {
        return;
    }

    $stars = (int) get_option('kksr_stars', 5);
    $total = get_post_meta($id, '_kksr_ratings', true);
    $score = calculateScore($total, $count, $stars);
    $type = get_option('kksr_sd_type', 'CreativeWork');
    $context = get_option('kksr_sd_context', 'https://schema.org/');
    $name = get_the_title($id);

    include KKSR_PATH_VIEWS.'structured-data.php';
}
