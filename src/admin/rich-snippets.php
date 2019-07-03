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
        'field' => 'checkbox',
        'id' => prefix('grs'),
        'title' => __('Status', 'kk-star-ratings'),
        'label' => __('Active', 'kk-star-ratings'),
        'name' => prefix('grs'),
        'value' => true,
        'checked' => (bool) getOption('grs'),
        'help' => __('Activate/deactivate rich snippets.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'id' => prefix('sd_context'),
        'title' => __('Context', 'kk-star-ratings'),
        'name' => prefix('sd_context'),
        'value' => getOption('sd_context'),
        'help' => __('Structured data context.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'id' => prefix('sd_type'),
        'title' => __('Type', 'kk-star-ratings'),
        'name' => prefix('sd_type'),
        'value' => getOption('sd_type'),
        'help' => __('Structured data type.', 'kk-star-ratings'),
    ],
];
