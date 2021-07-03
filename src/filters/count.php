<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\filters;

use function Bhittani\StarRating\functions\post_meta;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function count(?int $count, int $id, string $slug): int
{
    if (! is_null($count)) {
        return $count;
    }

    return (int) post_meta($id, "count_{$slug}");
}
