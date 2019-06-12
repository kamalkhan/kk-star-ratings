<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * This source file is subject to the GPL v2 license that
 * is bundled with this source code in the file LICENSE.
 */

namespace Bhittani\StarRating;

add_filter('the_content', KKSR_NAMESPACE.'markup'); function markup($content)
{
    $isRtl = false;
    $id = 5;
    $stars = 5;
    $size = 24;
    $stars = 5;
    $total = 10;
    $count = 4;
    $score = calculateScore($total, $count, $stars);
    $percent = calculatePercentage($total, $count);
    $pad = 4;
    $width = $score * $size + ((int) $score * $pad);

    ob_start();
    include KKSR_PATH_VIEWS.'star.php';
    $starMarkup = ob_get_clean();

    $starsMarkup = '';

    for ($i = 1; $i <= $stars; ++$i) {
        $starsMarkup .= $starMarkup;
    }

    ob_start();
    include KKSR_PATH_VIEWS.'markup.php';
    $markup = ob_get_clean();

    return $content.$markup;
}
