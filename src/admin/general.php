<?php

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
];
