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

function to_shortcode(string $tag, array $payload = [], string $contents = ''): string
{
    $fragments = [];
    $fragments[] = "[{$tag}";

    $attrs = array_map(function ($key, $value) {
        return "{$key}=\"{$value}\"";
    }, array_keys($payload), array_values($payload));

    if ($attrs) {
        $fragments[] = ' ';
    }

    $fragments[] = implode(' ', $attrs);
    $fragments[] = ']';

    if ($contents) {
        $fragments[] = $contents;
        $fragments[] = "[/{$tag}]";
    }

    return implode('', $fragments);
}
