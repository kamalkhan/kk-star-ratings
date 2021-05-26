<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\filters\admin;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function active_tab(string $active): string
{
    if (! ($_GET['tab'] ?? false)) {
        return $active;
    }

    return sanitize_text_field($_GET['tab']);
}
