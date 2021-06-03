<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions;

use function Bhittani\StarRating\functions\option;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function sd(array $payload): void
{
    $sd = '<script type="application/ld+json">'.trim(option('sd')).'</script>';
    $sd = str_replace('{best}', $payload['best'], $sd);
    $sd = str_replace('{count}', $payload['count'], $sd);
    $sd = str_replace('{score}', $payload['score'], $sd);
    $sd = str_replace('{title}', $payload['title'], $sd);

    echo $sd;
}
