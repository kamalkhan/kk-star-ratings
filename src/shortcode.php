<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating;

if (! defined('ABSPATH')) {
    http_response_code(404);
    die();
}

add_shortcode(config('shortcode'), __NAMESPACE__.'\shortcode');
// Legacy support.
add_shortcode('kkratings', __NAMESPACE__.'\shortcode');
function shortcode($attrs, $content, $tag)
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

    $attrs = shortcode_atts(array_fill_keys([
        'id', 'slug', 'score', 'count', 'best',
        'size', 'align', 'valign', 'disabled',
        'greet', 'force',
    ], null), $attrs, $tag);

    return response($attrs);
}
