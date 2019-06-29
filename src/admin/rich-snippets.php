<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * This source file is subject to the GPL v2 license that
 * is bundled with this source code in the file LICENSE.
 */

return [
    [
        'field' => 'checkbox',
        'id' => 'kksr_grs',
        'title' => __('Status', 'kk-star-ratings'),
        'label' => __('Active', 'kk-star-ratings'),
        'name' => 'kksr_grs',
        'value' => true,
        'checked' => (bool) get_option('kksr_grs'),
        'help' => __('Activate/deactivate rich snippets.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'id' => 'kksr_sd_context',
        'title' => __('Context', 'kk-star-ratings'),
        'name' => 'kksr_sd_context',
        'value' => get_option('kksr_sd_context'),
        'help' => __('Structured data context.', 'kk-star-ratings'),
    ],

    [
        'field' => 'text',
        'id' => 'kksr_sd_type',
        'title' => __('Type', 'kk-star-ratings'),
        'name' => 'kksr_sd_type',
        'value' => get_option('kksr_sd_type'),
        'help' => __('Structured data type.', 'kk-star-ratings'),
    ],
];
