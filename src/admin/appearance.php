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

return [
    [
        'field' => 'text',
        'type' => 'number',
        'id' => prefix('size'),
        'title' => __('Size', 'kk-star-ratings'),
        'name' => prefix('size'),
        'value' => getOption('size'),
        'help' => __('Size of a single star in pixels.', 'kk-star-ratings'),
    ],
];
