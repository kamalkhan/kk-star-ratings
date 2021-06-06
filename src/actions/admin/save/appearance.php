<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions\admin\save;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function appearance(array $payload, string $tab): void
{
    $defaults = array_fill_keys([
        'kksr_gap',
        'kksr_greet',
        'kksr_position',
        'kksr_size',
        'kksr_stars',
    ], null);

    $payload = shortcode_atts($defaults, $payload);

    // option($payload);
}
