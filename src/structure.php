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

add_action('wp_head', KKSR_NAMESPACE.'structuredData'); function structuredData($force = false, $p = null)
{
    if (! getOption('grs')) {
        return;
    }

    global $post;
    $p = $p ?: $post;
    $p = is_object($p) ? $p : get_post($p);

    if (! (($force || isValidRequest($p)) && is_singular())) {
        return;
    }

    $id = $p->ID;
    $count = (int) get_post_meta($id, '_kksr_casts', true);

    if (! $count) {
        return;
    }

    $stars = (int) getOption('stars');
    $total = get_post_meta($id, '_kksr_ratings', true);
    $score = calculateScore($total, $count, $stars);
    $type = getOption('sd_type');
    $context = getOption('sd_context');
    $name = get_the_title($id);

    ob_start();
    include KKSR_PATH_VIEWS.'structured-data.php';
    $html = ob_get_clean();

    echo apply_filters(prefix('structured_data'), $html, $p);
}
