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

add_action('wp_ajax_'.config('slug'), __NAMESPACE__.'\ajax');
add_action('wp_ajax_nopriv_'.config('slug'), __NAMESPACE__.'\ajax');
function ajax()
{
    if (! check_ajax_referer(config('slug').'-ajax', 'nonce', false)) {
        header('Content-Type: application/json; charset=utf-8', true, 403);

        return wp_die(json_encode([
            'error' => __('This action is forbidden.', 'kk-star-ratings'),
        ]));
    }

    if (! isset($_POST['id'])) {
        header('Content-Type: application/json; charset=utf-8', true, 406);

        return wp_die(json_encode([
            'error' => __('An id is required to vote.', 'kk-star-ratings'),
        ]));
    }

    $id = $_POST['id'];
    $slug = $_POST['slug'];

    if (! apply_plugin_filters('can_vote', true, $id, $slug)) {
        header('Content-Type: application/json; charset=utf-8', true, 401);

        return wp_die(json_encode([
            'error' => __('You are not allowed to vote.', 'kk-star-ratings'),
        ]));
    }

    if (! isset($_POST['score'])) {
        header('Content-Type: application/json; charset=utf-8', true, 406);

        return wp_die(json_encode([
            'error' => __('A rating is required to vote.', 'kk-star-ratings'),
        ]));
    }

    $best = $_POST['best'] ?: get_option(prefix('stars'));
    $best = max((int) $best, 1);
    $score = $_POST['score'];
    $score = min(max((int) $score, 1), $best);

    do_plugin_action('vote', $score, $best, $id, $slug);

    wp_die(response(compact('id', 'slug', 'best'), false), 201);
}
