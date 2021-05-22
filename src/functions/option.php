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
function option(string $key, $default = null)
{
    $prefix = kksr('nick').'_';

    if (strpos($key, $prefix) === 0) {
        $key = substr($key, strlen($prefix));
    }

    if (is_null($default)) {
        $default = ((array) kksr('options'))[$key] ?? null;
    }

    return get_option($prefix.$key, $default);
}
