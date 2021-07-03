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

function unique(?bool $bool, string $fingerprint, int $id, string $slug): bool
{
    if (! is_null($bool)) {
        return $bool;
    }

    return ! in_array($fingerprint, post_meta($id, "fingerprint_{$slug}[]"));
}
