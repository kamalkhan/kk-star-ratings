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

use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

/** @param string|array $attrs */
function shortcode($attrs, string $contents, string $tag): string
{
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

    $defaults = array_fill_keys([
        'id', 'slug', 'score', 'count',
        'best', 'size', 'align', 'valign',
        'disabled', 'greet', 'force', 'legend',
    ], null);

    $payload = shortcode_atts($defaults, $attrs, $tag);

    return apply_filters(kksr('filters.response'), '', $payload + ['legend' => $contents]);
}
