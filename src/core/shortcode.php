<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core;

use function Bhittani\StarRating\functions\option;
use function Bhittani\StarRating\functions\view;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @param string|array $attrs */
function shortcode($attrs, string $contents, string $tag): string
{
    $defaults = array_fill_keys([
        'align', 'count', 'force', 'id',
        'readonly', 'score', 'slug', 'valign',
    ], '') + [
        'best' => option('stars'),
        'gap' => option('gap'),
        'greet' => option('greet'),
        'legend' => option('legend'),
        'size' => option('size'),
    ];

    ksort($defaults);

    $attrs = (array) $attrs;

    foreach ($attrs as $key => &$value) {
        if (is_numeric($key)) {
            $attrs[$value] = true;
            unset($attrs[$key]);
        }
        if ($value === 'false') {
            $value = false;
        }
        if ($value === 'true') {
            $value = true;
        }
        if ($value === 'null') {
            $value = null;
        }
    }

    $payload = shortcode_atts($defaults, $attrs, $tag);

    $payload['best'] = (int) $payload['best'];
    $payload['force'] = (bool) $payload['force'];
    $payload['gap'] = (int) $payload['gap'];
    $payload['id'] = (int) $payload['id'];
    $payload['legend'] = $payload['legend'] ?: $contents;
    $payload['readonly'] = (bool) $payload['readonly'];
    $payload['size'] = (int) $payload['size'];

    $payload = apply_filters(kksr('filters.payload'), $payload);

    return view('response/index.php', $payload);
}
