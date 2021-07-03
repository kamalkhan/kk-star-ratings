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

function status(?string $status, int $id, string $slug): string
{
    if (! is_null($status)) {
        return $status;
    }

    return post_meta($id, "status_{$slug}");
}
