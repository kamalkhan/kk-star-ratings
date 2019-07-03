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

add_action('admin_menu', KKSR_NAMESPACE.'admin'); function admin()
{
    add_menu_page(
        KKSR_LABEL,
        KKSR_LABEL,
        'manage_options',
        KKSR_SLUG,
        KKSR_NAMESPACE.'adminCallback',
        'dashicons-star-filled'
    );
} function adminCallback()
{
    $label = KKSR_LABEL;
    $version = KKSR_VERSION;

    ob_start();
    include KKSR_PATH_VIEWS.'admin/index.php';
    $html = ob_get_clean();

    echo apply_filters(prefix('settings'), $html);
}

add_action(prefix('setting_tabs'), KKSR_NAMESPACE.'adminTabs'); function adminTabs()
{
    $tabs = getAdminTabs();
    $active = getActiveAdminTab();

    ob_start();
    include KKSR_PATH_VIEWS.'admin/tabs.php';
    echo ob_get_clean();
}

add_action(prefix('setting_contents'), KKSR_NAMESPACE.'adminContents'); function adminContents()
{
    if (! ($active = getActiveAdminTab())) {
        return;
    }

    ob_start();

    if (file_exists($file = KKSR_PATH_VIEWS.'admin/tabs/'.$active.'.php')) {
        include $file;
    } else {
        include KKSR_PATH_VIEWS.'admin/contents.php';
    }

    echo ob_get_clean();
}

add_action('admin_init', KKSR_NAMESPACE.'adminFields'); function adminFields()
{
    if (! ($active = getActiveAdminTab())) {
        return;
    }

    add_settings_section('default', null, null, KKSR_SLUG);

    $fields = [];

    if (file_exists($file = KKSR_PATH_SRC.'admin/'.$active.'.php')) {
        $fields = array_merge($fields, (array) require $file);
    }

    $fields = apply_filters(prefix('setting_fields'), $fields, $active);
    $fields = apply_filters(prefix('setting_fields:'.$active), $fields);

    foreach ($fields as $field) {
        $field = apply_filters(prefix('setting_field'), $field);

        if (isset($field['field'])) {
            $field = apply_filters(prefix('setting_field:'.$field['field']), $field);
        } elseif (isset($field['fields'])) {
            foreach ($field['fields'] as &$childField) {
                $childField = apply_filters(prefix('setting_field:'.$childField['field']), $childField);
            }
        }

        $field = apply_filters(prefix('setting_input:'.$field['name']), $field);

        register_setting(
            KKSR_SLUG,
            $field['name'],
            isset($field['filter']) ? $field['filter'] : null
        );

        add_settings_field(
            $field['id'],
            $field['title'],
            KKSR_NAMESPACE.'fieldCallback',
            KKSR_SLUG,
            'default',
            $field
        );
    }
} function fieldCallback($args)
{
    extract($args);

    ob_start();

    if (isset($fields)) {
        $br = '<br><br>';

        for ($i = 0; $i < count($fields); ++$i) {
            echo $i != 0 ? $br : '';
            fieldCallback($fields[$i]);
        }
        if (isset($help)) {
            echo $br;
        }
    } elseif (isset($args['field'])
        && file_exists($file = KKSR_PATH_VIEWS.'admin/fields/'.$args['field'].'.php')
    ) {
        include $file;
    }

    if (isset($help)) {
        echo '<p class="description">'.$help.'</p>';
    }

    $html = ob_get_clean();

    $html = apply_filters(prefix('setting_field_html'), $html, $args);

    if (isset($args['field'])) {
        $html = apply_filters(prefix('setting_field_html:'.$args['field']), $html, $args);
    }

    if (isset($args['name'])) {
        $html = apply_filters(prefix('setting_input_html:'.$args['name']), $html, $args);
    }

    echo $html;
}
