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

add_action('wp_ajax_'.KKSR_SLUG, KKSR_NAMESPACE.'ajax');
add_action('wp_ajax_nopriv_'.KKSR_SLUG, KKSR_NAMESPACE.'ajax'); function ajax()
{
    header('Content-Type: application/json; charset=utf-8', true);

    if (! check_ajax_referer(KKSR_SLUG, 'nonce', false)) {
        status_header(403);

        return wp_die(json_encode(['error' => __('This action is forbidden.', 'kk-star-ratings')]));
    }

    // Are guests allowed?
    if (! is_user_logged_in() && ! in_array('guests', getOption('strategies'))) {
        status_header(401);

        return wp_die(json_encode(['error' => __('Unauthorized.', 'kk-star-ratings')]));
    }

    if (! isset($_POST['id'])) {
        status_header(406);

        return wp_die(json_encode(['error' => __('An id is required to vote.', 'kk-star-ratings')]));
    }

    $id = $_POST['id'];

    $ip = md5($_SERVER['REMOTE_ADDR']);
    $ips = get_post_meta($id, '_kksr_ips');

    // Is the IP address unique?
    if (in_array('unique', getOption('strategies'))
        && in_array($ip, $ips)
    ) {
        status_header(403);

        return wp_die(json_encode(['error' => __('Not allowed to vote.', 'kk-star-ratings')]));
    }

    if (! isset($_POST['rating'])) {
        status_header(406);

        return wp_die(json_encode(['error' => __('A rating is required to vote.', 'kk-star-ratings')]));
    }

    $rating = $_POST['rating'];

    try {
        list($ratings, $count) = vote($id, $rating);
    } catch (\Exception $e) {
        status_header(406);

        return wp_die(json_encode(['error' => $e->getMessage()]));
    }

    if (! in_array($ip, $ips)) {
        update_post_meta($id, '_kksr_ips', $ip);
    }

    status_header(201);

    $disable = in_array('unique', getOption('strategies'));
    $count = apply_filters('kksr_count', $count);
    $score = apply_filters('kksr_score', calculateScore($ratings, $count, getOption('stars')));
    $percentage = apply_filters('kksr_percentage', calculatePercentage($ratings, $count));
    $width = apply_filters('kksr_width', calculateWidth($score));

    wp_die(json_encode(compact('percentage', 'score', 'count', 'width', 'disable')));
}
