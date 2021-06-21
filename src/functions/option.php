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

/**
 * Get or update options.
 *
 * @param array|string $keyOrOptions
 * @param mixed|null $default
 */
function option($keyOrOptions, $default = null, array $fallback = null)
{
    if (is_null($fallback)) {
        $fallback = (array) kksr('options');
    }

    if (! is_array($keyOrOptions)) {
        [$prefix, $key] = explode_prefix($keyOrOptions);
        $fallbackValue = $fallback[$key] ?? null;
        $value = get_option($prefix.$key, $default ?? $fallbackValue);

        return type_cast($value, gettype($fallbackValue));
    }

    foreach ($keyOrOptions as $key => &$value) {
        [$prefix, $key] = explode_prefix($key);
        $fallbackValue = $fallback[$key] ?? null;
        $type = gettype($fallbackValue);
        $value = type_cast($value, $type == 'boolean' ? 'integer' : $type);
        update_option($prefix.$key, $value);
    }

    return $keyOrOptions;
}
