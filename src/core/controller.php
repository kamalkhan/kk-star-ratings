<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core;

use function Bhittani\StarRating\functions\cast;
use function Bhittani\StarRating\functions\to_shortcode;
use Exception;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function controller()
{
    try {
        if (! check_ajax_referer(__FUNCTION__, 'nonce', false)) {
            throw new Exception(__('This action is forbidden.', 'kk-star-ratings'), 401);
        }

        if (! isset($_POST['rating'])) {
            throw new Exception(__('A rating is required to cast a vote.', 'kk-star-ratings'));
        }

        $payload = array_map('sanitize_text_field', $_POST['payload'] ?? []);

        $slug = $payload['slug'] ?? '';
        $id = intval($payload['id'] ?? 0);
        $rating = intval($_POST['rating'] ?? 0);
        $best = intval($payload['best'] ?? 5);

        if ($rating < 1 || $rating > $best) {
            throw new Exception(sprintf(__('The rating value must be between %1$d and %2$d.', 'kk-star-ratings'), 1, $best));
        }

        $outOf5 = cast($rating, 5, $best);

        do_action(kksr('actions.save'), $outOf5, $id, $slug, $payload);

        unset($payload['score'], $payload['count']);

        // $html = shortcode($payload, '', kksr('slug'));
        $html = do_shortcode(to_shortcode(kksr('slug'), $payload));

        wp_die($html, 201);
    } catch (Exception $e) {
        header('Content-Type: application/json; charset=utf-8');

        wp_die(json_encode(['error' => $e->getMessage()]), $e->getCode() ?: 406);
    }
}
