<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\functions;

use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function response(array $payload): string
{
    $payload += array_fill_keys([
        'align', 'count', 'id', 'readonly',
        'score', 'slug', 'valign',
    ], '') + [
        'best' => option('stars'),
        'gap' => option('gap'),
        'greet' => option('greet'),
        'legend' => option('legend'),
        'size' => option('size'),
    ];

    $payload['best'] = (int) $payload['best'];
    $payload['gap'] = (int) $payload['gap'];
    $payload['id'] = (int) $payload['id'];
    $payload['readonly'] = (bool) $payload['readonly'];
    $payload['size'] = (int) $payload['size'];

    $payload = apply_filters(kksr('filters.payload'), $payload);

    $payload['greet'] = str_replace('{type}', get_post_type($payload['id']) ?: 'post', $payload['greet']);
    $payload['_legend'] = $payload['legend'];
    $payload['legend'] = str_replace('{best}', $payload['best'], $payload['legend']);
    $payload['legend'] = str_replace('{count}', $payload['count'], $payload['legend']);
    $payload['legend'] = str_replace('{score}', $payload['score'], $payload['legend']);
    $payload['legend'] = str_replace('{votes}', _n('vote', 'votes', $payload['count'], 'kk-star-ratings'), $payload['legend']);

    ob_start();

    do_action(kksr('actions.markup'), $payload);

    return ob_get_clean();
}
