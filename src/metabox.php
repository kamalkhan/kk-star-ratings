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

add_action('add_meta_boxes', KKSR_NAMESPACE.'metabox', 10, 2); function metabox($type, $post)
{
    $customPostTypes = get_post_types(['publicly_queryable' => true, '_builtin' => false], 'names');
    $postTypes = array_merge(['post', 'page'], $customPostTypes);

    $count = get_post_meta($post->ID, '_'.prefix('casts'), true);
    $ratings = get_post_meta($post->ID, '_'.prefix('ratings'), true);
    $score = calculateScore($ratings, $count, getOption('stars'));

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

    add_meta_box(KKSR_SLUG, $icon.KKSR_LABEL.$legend, KKSR_NAMESPACE.'echoMetabox', $postTypes, 'side');
}

function echoMetabox($post)
{
    wp_nonce_field(basename(__FILE__), KKSR_SLUG.'-metabox-nonce');

    $resetFieldName = '__'.prefix('reset');
    $statusFieldName = '_'.prefix('status');
    $status = get_post_meta($post->ID, $statusFieldName, true);

    ob_start();
    include KKSR_PATH_VIEWS.'metabox/index.php';
    echo ob_get_clean();
}

add_action('save_post', KKSR_NAMESPACE.'saveMetabox'); function saveMetabox($id)
{
    if ((! isset($_POST[KKSR_SLUG.'-metabox-nonce']))
        || (! wp_verify_nonce($_POST[KKSR_SLUG.'-metabox-nonce'], basename(__FILE__)))
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || (! current_user_can('edit_post', $id))
        // || (is_multisite() && ms_is_switched())
        // || (! (isset( $_POST['post_type'] ) && 'page' === $_POST['post_type']))
    ) {
        return;
    }

    update_post_meta($id, '_'.prefix('status'), $_POST['_'.prefix('status')]);

    if (checked($_POST['__'.prefix('reset')], '1')) {
        delete_post_meta($id, '_kksr_avg');
        delete_post_meta($id, '_'.prefix('casts'));
        delete_post_meta($id, '_'.prefix('ratings'));
    }

    do_action('kksr_save_metabox');
}
