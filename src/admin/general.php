<?php

$locations = get_option('kksr_locations', []);
$strategies = get_option('kksr_strategies', []);

return [
    [
        'field' => 'checkbox',
        'id' => 'kksr_enable',
        'title' => __('Status', KKSR_SLUG),
        'label' => __('Active', KKSR_SLUG),
        'name' => 'kksr_enable',
        'value' => true,
        'checked' => (bool) get_option('kksr_enable'),
        'help' => __('Globally enable/disable the plugin.', KKSR_SLUG),
    ],

    // Locations

    [
        'id' => 'kksr_locations',
        'title' => __('Locations', KKSR_SLUG),
        'name' => 'kksr_locations',
        'help' => __('Where do you want to show the star ratings.', KKSR_SLUG),
        'fields' => [
            [
                'field' => 'checkbox',
                'label' => __('Home page', KKSR_SLUG),
                'name' => 'kksr_locations[home]',
                'value' => true,
                'checked' => isset($locations['home']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Archives', KKSR_SLUG),
                'name' => 'kksr_locations[archives]',
                'value' => true,
                'checked' => isset($locations['archives']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Posts', KKSR_SLUG),
                'name' => 'kksr_locations[posts]',
                'value' => true,
                'checked' => isset($locations['posts']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Pages', KKSR_SLUG),
                'name' => 'kksr_locations[pages]',
                'value' => true,
                'checked' => isset($locations['pages']),
            ]
        ],
    ],

    // Strategies

    [
        'id' => 'kksr_strategies',
        'title' => __('Strategies', KKSR_SLUG),
        'name' => 'kksr_strategies',
        'help' => __('Pick your desired voting strategies.', KKSR_SLUG),
        'fields' => [
            [
                'field' => 'checkbox',
                'label' => __('Allow voting in archives', KKSR_SLUG),
                'name' => 'kksr_strategies[archives]',
                'value' => true,
                'checked' => isset($strategies['archives']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Allow guests to vote', KKSR_SLUG),
                'name' => 'kksr_strategies[guests]',
                'value' => true,
                'checked' => isset($strategies['guests']),
            ],
            [
                'field' => 'checkbox',
                'label' => __('Unique votings based on IP Address', KKSR_SLUG),
                'name' => 'kksr_strategies[ip]',
                'value' => true,
                'checked' => isset($strategies['ip']),
            ],
        ],
    ],

];
