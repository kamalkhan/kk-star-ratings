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

add_action('add_meta_boxes', __NAMESPACE__.'\metabox', 10, 2);
function metabox($type, $post)
{
    $icon = $legend = '';

    if ($post) {
        $count = count_filter(null, $post->ID, null);
        $score = score_filter(null, get_option(prefix('stars')), $post->ID, null);

        $icon = '<span class="dashicons dashicons-star-empty" style="margin-right: .25rem; font-size: 18px;"></span>';

        $legend = '';

        if ($score) {
            $legend = "
                <span style=\"float:right;color:#666;\">
                    {$score}
                    <span style=\"font-weight:normal;color:#ddd;\">/</span>
                    <span style=\"font-weight:normal;color:#aaa;\">{$count}</span>
                </span>
            ";
        }
    }

    $customPostTypes = get_post_types(['publicly_queryable' => true, '_builtin' => false], 'names');
    $postTypes = array_merge(['post', 'page'], $customPostTypes);

    add_meta_box(
        config('slug'),
        $icon.config('name').$legend,
        __NAMESPACE__.'\metabox_callback',
        $postTypes,
        'side'
    );
}

function metabox_callback($post)
{
    wp_nonce_field(basename(__FILE__), config('slug').'-metabox');

    $content = apply_plugin_filters('metabox', '', $post);

    echo view('metabox.index', compact('content'));
}

add_action('save_post', __NAMESPACE__.'\save_metabox');
function save_metabox($id)
{
    if ((! isset($_POST[config('slug').'-metabox']))
        || (! wp_verify_nonce($_POST[config('slug').'-metabox'], basename(__FILE__)))
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || (! current_user_can('edit_post', $id))
        // || (is_multisite() && ms_is_switched())
        // || (! (isset( $_POST['post_type'] ) && 'page' === $_POST['post_type']))
    ) {
        return;
    }

    do_plugin_action('save_metabox', $id);
}

add_plugin_filter('metabox', __NAMESPACE__.'\metabox_content', 9, 2);
function metabox_content($content, $post)
{
    $resetFieldName = meta_prefix('reset');
    $statusFieldName = meta_prefix('status');
    $status = get_post_meta($post->ID, $statusFieldName, true);

    return $content.view('metabox.content', compact('status', 'statusFieldName', 'resetFieldName'));
}

add_plugin_action('save_metabox', __NAMESPACE__.'\save_default_metabox', 9);
function save_default_metabox($id)
{
    if (isset($_POST[meta_prefix('status')])) {
        update_post_meta($id, meta_prefix('status'), $_POST[meta_prefix('status')]);
    }

    if (isset($_POST[meta_prefix('reset')])
        && checked($_POST[meta_prefix('reset')], '1', false)
    ) {
        delete_post_meta($id, meta_prefix('ref'));
        delete_post_meta($id, meta_prefix('avg'));
        delete_post_meta($id, meta_prefix('casts'));
        delete_post_meta($id, meta_prefix('ratings'));
    }
}
