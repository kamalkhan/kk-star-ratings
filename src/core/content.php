<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core;

use function Bhittani\StarRating\functions\option;
use function Bhittani\StarRating\functions\to_shortcode;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function content(string $content): string
{
    foreach ([
        kksr('slug'),
        // Legacy...
        'kkratings', // < v3
        'kkstarratings', // v3, v4
    ] as $tag) {
        if (has_shortcode($content, $tag)) {
            return $content;
        }
    }

    $align = 'left';
    $explicit = false;
    $valign = 'top';

    $position = option('position');

    if (strpos($position, 'top-') === 0) {
        $valign = 'top';
        $align = substr($position, 4);
    }

    if (strpos($position, 'bottom-') === 0) {
        $valign = 'bottom';
        $align = substr($position, 7);
    }

    $starRatings = to_shortcode(kksr('slug'), compact('align', 'explicit', 'valign'));

    if ($valign == 'top') {
        return $starRatings.$content;
    }

    return $content.$starRatings;
}
