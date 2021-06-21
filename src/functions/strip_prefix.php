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

/** @param string|array */
function strip_prefix($keyOrItems, string $prefix = null)
{
    if (is_array($keyOrItems)) {
        return array_combine(
            array_map(function ($key) use ($prefix) {
                return strip_prefix($key, $prefix);
            }, array_keys($keyOrItems)),
            array_values($keyOrItems)
        );
    }

    if (is_null($prefix)) {
        $prefix = kksr('nick').'_';
    }

    $key = $keyOrItems;

    if (strpos($key, $prefix) !== 0) {
        return $key;
    }

    return substr($key, strlen($prefix));
}
