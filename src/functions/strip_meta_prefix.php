<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\functions;

use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @param string|array $keyOrArray */
function strip_meta_prefix($keyOrArray, string $prefix = null)
{
    return strip_prefix($keyOrArray, is_null($prefix) ? ('_'.kksr('nick').'_') : $prefix);
}
