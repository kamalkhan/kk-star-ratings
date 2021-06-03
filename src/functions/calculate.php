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

use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function calculate(int $id, string $slug, int $best = 5): array
{
    $count = (int) apply_filters(kksr('filters.count'), null, $id, $slug);
    $ratings = (float) apply_filters(kksr('filters.ratings'), null, $id, $slug);
    $score = $count ? ($ratings / $count) : 0;
    $score = (float) min(max(0, cast($score, $best)), $best);
    $score = apply_filters(kksr('filters.score'), $score);

    return [$count, $score];
}
