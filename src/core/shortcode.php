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
use function Bhittani\StarRating\functions\response;
use function Bhittani\StarRating\functions\view;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @param string|array $attrs */
function shortcode($attrs, string $contents, string $tag): string
{
    if (! option('enable')) {
        return '';
    }

    $defaults = array_fill_keys([
        'align', 'best', 'count', 'force', 'gap', 'greet', 'id',
        'legend', 'readonly', 'score', 'size', 'slug', 'valign',
    ], '');

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

    $payload = shortcode_atts($defaults, $attrs + ['legend' => $contents], $tag);

    return response(array_filter($payload));
}
