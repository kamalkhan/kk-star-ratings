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
    function kk_star_ratings($post = null, $force = null)
    {
        return \Bhittani\StarRating\get($post, $force);
    }
}

if (! function_exists('kk_star_ratings_get')) {
    function kk_star_ratings_get($limit = 5, $taxonomyId = null, $offset = 0)
    {
        return \Bhittani\StarRating\collect($limit, $taxonomyId, $offset);
    }
}
