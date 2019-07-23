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

add_shortcode(KKSR_SHORTCODE, KKSR_NAMESPACE.'shortcode'); function shortcode($atts)
{
    return quick($atts, KKSR_SHORTCODE);
}

// add_filter('shortcode_atts_kkratings', KKSR_NAMESPACE.'filterShortcode');
// add_filter('shortcode_atts_'.KKSR_SHORTCODE, KKSR_NAMESPACE.'filterShortcode');
// function filterShortcode($atts)
// {
//     // if ($atts['id']) {
//     //     queue();
//     // }
//     die(var_dump($atts));

//     return $atts;
// }
