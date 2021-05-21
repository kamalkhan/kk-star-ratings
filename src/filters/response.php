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

use function Bhittani\StarRating\functions\view;
use function Bhittani\StarRating\functions\width;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function response(string $html, array $payload): string
{
    if ($html) {
        return $html;
    }

    // Temporary...
    // $payload['score'] = $payload['score'] ?: 3.5;
    // $payload['count'] = $payload['count'] ?: 7;

    $payload['width'] = width($payload['score'], $payload['size'], $payload['gap']);

    return view('response/index.php', $payload);
}
