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

add_filter('the_content', KKSR_NAMESPACE.'markup'); function markup($content, $force = false, $p = null)
{
    global $post;
    $p = $p ?: $post;
    $p = is_object($p) ? $p : get_post($p);

    if (! $force && ! (isValidRequest($p) && isValidPost($p))) {
        return $content;
    }

    if (! $force && (
        has_shortcode($content, KKSR_SHORTCODE)
            || has_shortcode($content, 'kkratings')
    )) {
        return $content;
    }

    if (! is_null($content) && in_array(get_post_type($p), getOption('manual_control'))) {
        return $content;
    }

    $id = $p->ID;
    $isRtl = is_rtl();
    $size = (int) getOption('size');
    $stars = (int) getOption('stars');
    list($placement, $alignment) = extractPosition();
    $total = get_post_meta($id, '_kksr_ratings', true);
    $count = (int) get_post_meta($id, '_kksr_casts', true);
    $score = calculateScore($total, $count, $stars);
    $percent = calculatePercentage($total, $count);
    $width = calculateWidth($score, $size);
    $disabled = ! canVote($p);

    ob_start();
    include KKSR_PATH_VIEWS.'markup.php';
    $markup = ob_get_clean();

    return $placement === 'bottom' ? ($content.$markup) : ($markup.$content);
}

add_filter('kksr_score', KKSR_NAMESPACE.'scoreFilter'); function scoreFilter($score)
{
    return number_format($score, 1);
}

add_filter('kksr_count', KKSR_NAMESPACE.'countFilter', 10); function countFilter($count)
{
    // return str_pad($count, 2, 0, is_rtl() ? STR_PAD_RIGHT : STR_PAD_LEFT);

    return str_pad($count, 2, 0, STR_PAD_LEFT);
}
