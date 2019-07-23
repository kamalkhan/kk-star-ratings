<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * This source file is subject to the GPL v2 license that
 * is bundled with this source code in the file LICENSE.
 */

if (! function_exists('kk_star_ratings')) {
    function kk_star_ratings($postOrForce = null, $force = null)
    {
        $force = is_null($force) ? (is_bool($postOrForce) ? $postOrForce : null) : $force;

        return \Bhittani\StarRating\get(is_bool($postOrForce) ? null : $postOrForce, $force);
    }
}

if (! function_exists('kk_star_ratings_get')) {
    function kk_star_ratings_get($limit = 5, $taxonomyId = null, $offset = 0)
    {
        return \Bhittani\StarRating\collect($limit, $taxonomyId, $offset);
    }
}

add_shortcode('kkratings', KKSR_NAMESPACE.'legacyShortcode'); function legacyShortcode($atts)
{
    return quick($atts, 'kkratings');
}
