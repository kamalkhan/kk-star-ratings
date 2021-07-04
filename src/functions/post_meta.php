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
 * Get or update post meta.
 *
 * @param int|string $id
 * @param array|string $keyOrOptions
 * @param mixed|null $default
 */
function post_meta($id, $keyOrOptions, $default = null, array $fallback = null)
{
    if (is_null($fallback)) {
        $fallback = (array) kksr('post_meta');
    }

    $explodeSingle = function ($key) {
        if (strpos($key, '[]') === (strlen($key) - 2)) {
            return [substr($key, 0, -2), false];
        }

        return [$key, true];
    };

    if (! is_array($keyOrOptions)) {
        [$prefix, $key] = explode_meta_prefix($keyOrOptions);
        $fallbackValue = find($fallback, $key);
        [$key, $isSingle] = $explodeSingle($key);
        if (is_null($default)) {
            $default = $fallbackValue;
        }
        $value = $default;
        if (get_post_meta($id, $prefix.$key)) {
            $value = get_post_meta($id, $prefix.$key, $isSingle);
        }
        if (! $isSingle) {
            return (array) ($value ?: null);
        }

        return type_cast($value, gettype($fallbackValue));
    }

    foreach ($keyOrOptions as $key => $value) {
        [$prefix, $key] = explode_meta_prefix($key);
        $fallbackValue = find($fallback, $key);
        [$key, $isSingle] = $explodeSingle($key);
        $type = gettype($fallbackValue);
        $value = type_cast($value, $type == 'boolean' ? 'integer' : $type);
        if ($isSingle) {
            update_post_meta($id, $prefix.$key, $value);
        } else {
            add_post_meta($id, $prefix.$key, $value);
        }
    }
}
