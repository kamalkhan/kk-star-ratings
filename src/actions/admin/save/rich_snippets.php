<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions\admin\save;

use function Bhittani\StarRating\functions\option;
use function Bhittani\StarRating\functions\sanitize;
use function Bhittani\StarRating\functions\strip_prefix;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function rich_snippets(array $payload, string $tab): void
{
    $payload = strip_prefix($payload) + array_fill_keys([
        'grs',
        'sd',
    ], null);

    option(sanitize($payload, [
        'sd' => function ($value) {
            return wp_unslash(sanitize_textarea_field($value));
        },
    ]));
}
