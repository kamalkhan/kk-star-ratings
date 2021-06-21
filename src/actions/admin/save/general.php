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

use function Bhittani\StarRating\functions\option;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function general(array $payload, string $tab): void
{
    $defaults = array_fill_keys([
        'kksr_enable',
        'kksr_exclude_categories',
        'kksr_exclude_locations',
        'kksr_strategies',
    ], null);

    $payload = shortcode_atts($defaults, $payload);

    option($payload);
}
