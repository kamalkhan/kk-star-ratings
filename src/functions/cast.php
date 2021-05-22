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

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** Cast an integer to a base */
function cast(float $value, int $to = 5, int $from = 5): float
{
    // 4 * 5  / 5  = 4 * 1 = 4
    // 4 * 10 / 5  = 4 * 2 = 8
    // 8 * 5  / 10 = 8 / 2 = 4
    // 4 * 8  / 6  = 4 * 4 / 3 = 5.33

    return $value * $to / $from;
}
