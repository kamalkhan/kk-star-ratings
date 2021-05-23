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

use function Bhittani\StarRating\functions\calculate;
use function Bhittani\StarRating\functions\width;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function payload(array $payload): array
{
    [$count, $score] = calculate($payload['id'], $payload['slug']);

    if (! (is_numeric($payload['count']) || $payload['count'])) {
        $payload['count'] = $count;
    }

    if (! (is_numeric($payload['score']) || $payload['score'])) {
        $payload['score'] = $score;
    }

    $payload['width'] = width($payload['score'], $payload['size'], $payload['gap']);

    return $payload;
}
