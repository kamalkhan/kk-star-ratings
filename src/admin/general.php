<?php

$position = get_option('kksr_position', 'top-left');
$locations = get_option('kksr_locations', []);
$strategies = get_option('kksr_strategies', []);

return [
    [
        'field' => 'checkbox',
        'id' => 'kksr_enable',
        'title' => __('Status', 'kk-star-ratings'),
        'label' => __('Active', 'kk-star-ratings'),
        'name' => 'kksr_enable',
        'value' => true,
        'checked' => (bool) get_option('kksr_enable'),
        'help' => __('Globally enable/disable the plugin.', 'kk-star-ratings'),
    ],

    // Locations

    [
        'id' => 'kksr_locations',
        'title' => __('Locations', 'kk-star-ratings'),
        'name' => 'kksr_locations',
        'help' => __('Where do you want to show the star ratings.', 'kk-star-ratings'),
        'fields' => [
            [
                'field' => 'checkbox',
                'label' => __('Home page', 'kk-star-ratings'),
                'name' => 'kksr_locations[home]',
                'value' => true,
                'checked' => isset($locations['home']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Archives', 'kk-star-ratings'),
                'name' => 'kksr_locations[archives]',
                'value' => true,
                'checked' => isset($locations['archives']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Posts', 'kk-star-ratings'),
                'name' => 'kksr_locations[posts]',
                'value' => true,
                'checked' => isset($locations['posts']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Pages', 'kk-star-ratings'),
                'name' => 'kksr_locations[pages]',
                'value' => true,
                'checked' => isset($locations['pages']),
            ]
        ],
    ],

    // Strategies

    [
        'id' => 'kksr_strategies',
        'title' => __('Strategies', 'kk-star-ratings'),
        'name' => 'kksr_strategies',
        'help' => __('Pick your desired voting strategies.', 'kk-star-ratings'),
        'fields' => [
            [
                'field' => 'checkbox',
                'label' => __('Allow voting in archives', 'kk-star-ratings'),
                'name' => 'kksr_strategies[archives]',
                'value' => true,
                'checked' => isset($strategies['archives']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Allow guests to vote', 'kk-star-ratings'),
                'name' => 'kksr_strategies[guests]',
                'value' => true,
                'checked' => isset($strategies['guests']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Unique votings based on IP Address', 'kk-star-ratings'),
                'name' => 'kksr_strategies[ip]',
                'value' => true,
                'checked' => isset($strategies['ip']),
            ],
        ],
    ],

    // Position

    [
        'id' => 'kksr_position',
        'title' => __('Default Position', 'kk-star-ratings'),
        'name' => 'kksr_position',
        'help' => __('Choose a default position.', 'kk-star-ratings'),
        'fields' => [
            [
                'field' => 'radio',
                'label' => __('Top Left', 'kk-star-ratings'),
                'name' => 'kksr_position',
                'value' => 'top-left',
                'checked' => $position == 'top-left',
            ],
            [
                'field' => 'radio',
                'label' => __('Top Center', 'kk-star-ratings'),
                'name' => 'kksr_position',
                'value' => 'top-center',
                'checked' => $position == 'top-center',
            ],
            [
                'field' => 'radio',
                'label' => __('Top Right', 'kk-star-ratings'),
                'name' => 'kksr_position',
                'value' => 'top-right',
                'checked' => $position == 'top-right',
            ],
            [
                'field' => 'radio',
                'label' => __('Bottom Left', 'kk-star-ratings'),
                'name' => 'kksr_position',
                'value' => 'bottom-left',
                'checked' => $position == 'bottom-left',
            ],
            [
                'field' => 'radio',
                'label' => __('Bottom Center', 'kk-star-ratings'),
                'name' => 'kksr_position',
                'value' => 'bottom-center',
                'checked' => $position == 'bottom-center',
            ],
            [
                'field' => 'radio',
                'label' => __('Bottom Right', 'kk-star-ratings'),
                'name' => 'kksr_position',
                'value' => 'bottom-right',
                'checked' => $position == 'bottom-right',
            ],
        ],
    ],

];
