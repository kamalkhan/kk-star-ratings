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
    extract(shortcode_atts(['id' => null], $atts, KKSR_SHORTCODE));

    return markup(null, true, $id);
}
