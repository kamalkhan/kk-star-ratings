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

/** Access items using dot notation */
function dot(array $items, string $key, $default = null)
{
    $parts = explode('.', $key, 2);
    $head = array_shift($parts);
    $tail = array_shift($parts);

    if (! $tail) {
        return $items[$head] ?? $default;
    }

    return dot((array) $items[$head] ?? [], $tail, $default);
}
