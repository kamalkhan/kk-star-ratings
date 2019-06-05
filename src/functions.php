<?php

namespace Bhittani\StarRating;

function toNormalizedRatings($ratings, $from = 5, $to = 5)
{
    return $ratings / ($from / $to);
}

function calculateScore($total, $count, $from = 5, $to = 5)
{
    $count = (float) $count;
    $total = (float) $total;

    return $count ? round(($total / $count) * ($from / $to), 1, PHP_ROUND_HALF_DOWN) : 0;
}

// We will neglect $from but here for consistency!
function calculatePercentage($total, $count, $from = 5, $to = 5)
{
    $count = (float) $count;
    $total = (float) $total;

    return $count ? round($total / $count / $to * 100, 2, PHP_ROUND_HALF_DOWN) : 0;
}
