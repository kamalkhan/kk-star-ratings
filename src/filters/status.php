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

use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function status(?string $status, int $id, string $slug): string
{
    if (! is_null($status)) {
        return $status;
    }

    return get_post_meta($id, '_'.kksr('nick').'_status_'.$slug, true);
}
