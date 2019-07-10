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
        'id' => prefix('stars'),
        'title' => __('Stars', 'kk-star-ratings'),
        'name' => prefix('stars'),
        'value' => getOption('stars'),
        'help' => __('Total number of stars.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'type' => 'number',
        'id' => prefix('size'),
        'title' => __('Size', 'kk-star-ratings'),
        'name' => prefix('size'),
        'value' => getOption('size'),
        'help' => __('Size of a single star.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'type' => 'color',
        'id' => prefix('fill_color_star'),
        'title' => __('Fill color', 'kk-star-ratings'),
        'name' => prefix('fill_color_star'),
        'value' => getOption('fill_color_star'),
        'help' => __('Fill color of stars.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'type' => 'color',
        'id' => prefix('stroke_color_star'),
        'title' => __('Stroke color', 'kk-star-ratings'),
        'name' => prefix('stroke_color_star'),
        'value' => getOption('stroke_color_star'),
        'help' => __('Stroke color of stars.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'type' => 'color',
        'id' => prefix('fill_color_active_star'),
        'title' => __('Active fill color', 'kk-star-ratings'),
        'name' => prefix('fill_color_active_star'),
        'value' => getOption('fill_color_active_star'),
        'help' => __('Fill color of active stars.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'type' => 'color',
        'id' => prefix('stroke_color_active_star'),
        'title' => __('Active stroke color', 'kk-star-ratings'),
        'name' => prefix('stroke_color_active_star'),
        'value' => getOption('stroke_color_active_star'),
        'help' => __('Stroke color of active stars.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'type' => 'color',
        'id' => prefix('fill_color_hover_star'),
        'title' => __('Hover fill color', 'kk-star-ratings'),
        'name' => prefix('fill_color_hover_star'),
        'value' => getOption('fill_color_hover_star'),
        'help' => __('Fill color of hover stars.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'type' => 'color',
        'id' => prefix('stroke_color_hover_star'),
        'title' => __('Hover stroke color', 'kk-star-ratings'),
        'name' => prefix('stroke_color_hover_star'),
        'value' => getOption('stroke_color_hover_star'),
        'help' => __('Stroke color of hover stars.', 'kk-star-ratings'),
    ],
];
