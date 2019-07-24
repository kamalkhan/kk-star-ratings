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

$enabled = (bool) getOption('enable');
$position = getOption('position');
$manuallyControlled = getOption('manual_control');
$excludedLocations = getOption('exclude_locations');
$strategies = getOption('strategies');
$excludedCategories = getOption('exclude_categories', []);
$excludedCategories = is_array($excludedCategories) ? $excludedCategories : [];

$categories = get_terms([
    'taxonomy' => 'category',
    'hide_empty' => false,
    'parent' => 0,
]);

$categoriesOptions = [];
foreach ($categories as $category) {
    $categoriesOptions[] = [
        'label' => $category->name,
        'value' => $category->term_id,
        'selected' => in_array($category->term_id, (array) $excludedCategories),
    ];
}

$postTypes = [];

$customPostTypes = get_post_types(['publicly_queryable' => true, '_builtin' => false], 'objects');

foreach ($customPostTypes as $postType) {
    $postTypes[] = [
        'value' => $postType->name,
        'label' => $postType->labels->name,
    ];
}

$postTypes = array_merge([
    ['value' => 'post', 'label' => __('Posts', 'kk-star-ratings')],
    ['value' => 'page', 'label' => __('Pages', 'kk-star-ratings')],
], $postTypes);

return [
    [
        'field' => 'checkbox',
        'id' => prefix('enable'),
        'title' => __('Status', 'kk-star-ratings'),
        'label' => __('Active', 'kk-star-ratings'),
        'name' => prefix('enable'),
        'value' => true,
        'checked' => $enabled,
        'help' => __('Globally activate/deactivate the star ratings.', 'kk-star-ratings'),
    ],

    // Strategies

    [
        'id' => prefix('strategies'),
        'title' => __('Strategies', 'kk-star-ratings'),
        'name' => prefix('strategies'),
        'help' => __('Select the voting strategies.', 'kk-star-ratings'),
        'filter' => function ($values) {
            return (array) $values;
        },
        'fields' => [
            [
                'field' => 'checkbox',
                'label' => __('Allow voting in archives', 'kk-star-ratings'),
                'name' => prefix('strategies[]'),
                'value' => 'archives',
                'checked' => in_array('archives', $strategies),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Allow guests to vote', 'kk-star-ratings'),
                'name' => prefix('strategies[]'),
                'value' => 'guests',
                'checked' => in_array('guests', $strategies),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Unique votes (based on IP Address)', 'kk-star-ratings'),
                'name' => prefix('strategies[]'),
                'value' => 'unique',
                'checked' => in_array('unique', $strategies),
            ],
        ],
    ],

    // Manual Control

    [
        'id' => prefix('manual_control'),
        'title' => __('Manual Control', 'kk-star-ratings'),
        'name' => prefix('manual_control'),
        'help' => sprintf(__('Select the post types that should not auto embed the<br>markup and will be manually controlled by the theme.<br>E.g. Using %s in your template.', 'kk-star-ratings'), '<code>echo kk_star_ratings();</code>'),
        'filter' => function ($values) {
            return (array) $values;
        },
        'fields' => array_map(function ($field) use ($manuallyControlled) {
            $field['field'] = 'checkbox';
            $field['name'] = prefix('manual_control[]');
            $field['checked'] = in_array($field['value'], $manuallyControlled);

            return $field;
        }, $postTypes),
    ],

    // Locations

    [
        'id' => prefix('exclude_locations'),
        'title' => __('Disable Locations', 'kk-star-ratings'),
        'name' => prefix('exclude_locations'),
        'help' => __('Select the locations where the star ratings should be excluded.', 'kk-star-ratings'),
        'filter' => function ($values) {
            return (array) $values;
        },
        'fields' => array_map(function ($field) use ($excludedLocations) {
            $field['field'] = 'checkbox';
            $field['name'] = prefix('exclude_locations[]');
            $field['checked'] = in_array($field['value'], $excludedLocations);

            return $field;
        }, array_merge([
                [
                    'label' => __('Home page', 'kk-star-ratings'),
                    'value' => 'home',
                ],
                [
                    'label' => __('Archives', 'kk-star-ratings'),
                    'value' => 'archives',
                ],
            ], $postTypes)
        ),
    ],

    // Categories

    [
        'field' => 'select',
        'id' => prefix('exclude_categories'),
        'title' => __('Disable Categories', 'kk-star-ratings'),
        'name' => prefix('exclude_categories'),
        'multiple' => true,
        'filter' => function ($values) {
            return (array) $values;
        },
        'options' => $categoriesOptions,
        'help' => __('Exclude star ratings from posts belonging to the selected categories.<br>Use <strong>cmd/ctrl + click</strong> to select/deselect multiple categories.', 'kk-star-ratings'),
    ],

    // Position

    [
        'id' => prefix('position'),
        'title' => __('Default Position', 'kk-star-ratings'),
        'name' => prefix('position'),
        'help' => __('Choose a default position.', 'kk-star-ratings'),
        'fields' => [
            [
                'field' => 'radio',
                'label' => __('Top Left', 'kk-star-ratings'),
                'name' => prefix('position'),
                'value' => 'top-left',
                'checked' => $position == 'top-left',
            ],
            [
                'field' => 'radio',
                'label' => __('Top Center', 'kk-star-ratings'),
                'name' => prefix('position'),
                'value' => 'top-center',
                'checked' => $position == 'top-center',
            ],
            [
                'field' => 'radio',
                'label' => __('Top Right', 'kk-star-ratings'),
                'name' => prefix('position'),
                'value' => 'top-right',
                'checked' => $position == 'top-right',
            ],
            [
                'field' => 'radio',
                'label' => __('Bottom Left', 'kk-star-ratings'),
                'name' => prefix('position'),
                'value' => 'bottom-left',
                'checked' => $position == 'bottom-left',
            ],
            [
                'field' => 'radio',
                'label' => __('Bottom Center', 'kk-star-ratings'),
                'name' => prefix('position'),
                'value' => 'bottom-center',
                'checked' => $position == 'bottom-center',
            ],
            [
                'field' => 'radio',
                'label' => __('Bottom Right', 'kk-star-ratings'),
                'name' => prefix('position'),
                'value' => 'bottom-right',
                'checked' => $position == 'bottom-right',
            ],
        ],
    ],
];
