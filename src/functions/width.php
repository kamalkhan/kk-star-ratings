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

/** Calculate the width, providing a gap */
function width(int $score, int $size, int $gap = 0): float
{
    return $score * $size + $score * $gap;
}
