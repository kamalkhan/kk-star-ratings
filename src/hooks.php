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

use ReflectionFunction;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

$hook = function ($type, $tag, $fn) {
    ('add_'.$type)($tag, $fn, 9, (new ReflectionFunction($fn))->getNumberOfParameters());
};

foreach (kk_star_ratings('actions') as $fn) {
    $hook('action', $fn, $fn);
}

foreach (kk_star_ratings('filters') as $fn) {
    $hook('filter', $fn, $fn);
}
