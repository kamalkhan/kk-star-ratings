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

/** @param callable|array|null $sanitizers */
function sanitize($values, $sanitizers = null)
{
    $defaultSanitizer = 'sanitize_text_field';

    if (! $sanitizers) {
        $sanitizers = 'sanitize_text_field';
    }

    if (! is_array($values)) {
        $sanitizer = $sanitizers;

        if (is_array($sanitizer)) {
            $sanitizer = $defaultSanitizer;
        }

        return $sanitizer($values);
    }

    $sanitized = [];

    foreach ($values as $key => $value) {
        $sanitizer = $sanitizers;

        if (is_array($sanitizers)) {
            $sanitizer = $sanitizers[$key] ?? $sanitizer;
        }

        $sanitized[sanitize_text_field($key)] = sanitize($value, $sanitizer);
    }

    return $sanitized;
}
