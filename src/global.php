<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating;

if (! defined('ABSPATH')) {
    http_response_code(404);
    die();
}

function prefix($str)
{
    $prefix = config('nick').'_';

    if (strpos($str, $prefix) === 0) {
        return $str;
    }

    return $prefix.$str;
}

function meta_prefix($str)
{
    $prefix = '_'.config('nick').'_';

    if (strpos($str, $prefix) === 0) {
        return $str;
    }

    return $prefix.$str;
}
