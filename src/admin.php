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

if (! defined('ABSPATH')) {
    http_response_code(404);
    die();
}

use RuntimeException;

function get_admin_tabs()
{
    $tabs = apply_plugin_filters('admin_tabs', []);
    $keys = array_keys($tabs);
    $active = (isset($_GET['tab']) && $_GET['tab']) ? $_GET['tab'] : reset($keys);
    $active = apply_plugin_filters('active_admin_tab', $active);

    return [$tabs, $active];
}

add_action('admin_menu', __NAMESPACE__.'\admin');
function admin()
{
    add_menu_page(
        config('name'),
        config('name'),
        'manage_options',
        config('slug'),
        __NAMESPACE__.'\admin_callback',
        'dashicons-star-filled'
    );
}

function admin_callback()
{
    list($tabs, $active) = get_admin_tabs();

    $content = apply_plugin_filters('admin_content', '', $active);

    if ($active) {
        $content = apply_plugin_filters('admin_content.'.$active, $content);
    }

    echo view('admin.index', [
        'label' => config('name'),
        'version' => config('version'),
        'tabs' => $tabs,
        'active' => $active,
        'content' => $content,
    ]);
}

add_plugin_filter('admin_tabs', __NAMESPACE__.'\admin_tabs', 9);
function admin_tabs($tabs)
{
    return $tabs + [
        'general' => 'General',
        'appearance' => 'Appearance',
        'rich-snippets' => 'Rich Snippets',
    ];
}

add_plugin_filter('admin_content', __NAMESPACE__.'\admin_content', 9, 2);
function admin_content($content, $active)
{
    if (! $active) {
        return $content;
    }

    $slug = config('slug');

    return view(["admin.tabs.{$active}", 'admin.content'], compact('active', 'slug'));
}

add_action('admin_init', __NAMESPACE__.'\settings_callback');
function settings_callback()
{
    list($tabs, $active) = get_admin_tabs();

    if (! $active) {
        return;
    }

    $slug = config('slug');

    add_settings_section('default', null, null, $slug);

    $fields = apply_plugin_filters('setting_fields', [], $active);
    $fields = apply_plugin_filters('setting_fields.'.$active, $fields);

    foreach ($fields as $field) {
        register_setting(
            $slug,
            $field['name'],
            [
                'sanitize_callback' => isset($field['filter']) ? $field['filter'] : null,
            ]
        );

        add_settings_field(
            $field['name'],
            $field['title'],
            __NAMESPACE__.'\setting_field_callback',
            $slug,
            'default',
            $field
        );
    }
}

function setting_field_callback($field)
{
    if (isset($field['fields'])) {
        $input = apply_plugin_filters('setting_field', '', $field);

        foreach ($field['fields'] as $field) {
            setting_field_callback($field);
            echo '<br><br>';
        }

        echo $input;
    } else {
        $input = apply_plugin_filters('setting_field', '', $field);

        if (isset($field['type']) && $field['type']) {
            echo apply_plugin_filters('setting_field.'.$field['type'], $input, $field);
        } else {
            echo $input;
        }
    }
}

add_plugin_filter('setting_fields', __NAMESPACE__.'\setting_fields', 9, 2);
function setting_fields($fields, $active)
{
    if (is_file($file = __DIR__.'/admin/'.$active.'.php')) {
        return array_merge($fields, (array) require $file);
    }

    return $fields;
}

add_plugin_filter('setting_field', __NAMESPACE__.'\setting_field', 9, 2);
function setting_field($input, $payload)
{
    if ($input || ! isset($payload['type']) || ! $payload['type']) {
        return $input;
    }

    try {
        return view('admin.fields.'.$payload['type'], $payload);
    } catch (RuntimeException $e) {
        return $input;
    }
}

add_plugin_filter('setting_field', __NAMESPACE__.'\setting_field_help', 11, 2);
function setting_field_help($input, $payload)
{
    if (! isset($payload['help']) || ! $payload['help']) {
        return $input;
    }

    return $input.'<p class="description">'.$payload['help'].'</p>';
}
