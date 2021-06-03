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

/** Access options */
function option(string $key, $default = null, array $fallback = null)
{
    if (is_null($fallback)) {
        $fallback = (array) kksr('options');
    }

    $prefix = kksr('nick').'_';

    if (strpos($key, $prefix) === 0) {
        $key = substr($key, strlen($prefix));
    }

    $fallbackValue = $fallback[$key] ?? null;

    $value = get_option($prefix.$key, $default ?? $fallbackValue);

    return type_cast($value, gettype($fallbackValue));
}
