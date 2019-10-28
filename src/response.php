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

function response(array $payload = [], $validate = true)
{
    $payload = array_merge([
        'id' => null,
        'slug' => null,
        'score' => null,
        'count' => null,
        'align' => null,
        'valign' => null,
        'force' => true,
        'disabled' => false,
        'size' => get_option(prefix('size')),
        'best' => get_option(prefix('stars')),
        'greet' => get_option(prefix('greet')),
    ], array_filter($payload, function ($value) {
        return ! is_null($value);
    }));

    if (! get_option(prefix('enable'))) {
        return '';
    }

    if (! $payload['id'] && ! $payload['slug']) {
        $payload['id'] = get_post_field('ID');
    }

    $force = $payload['force'] ?: (! $validate);

    if (! $force
        && ! validate(true, $payload['id'], $payload['slug'])
    ) {
        return;
    }

    if (! $payload['id']) {
        $payload['disabled'] = true;
    }

    if ($payload['score']) {
        $payload['disabled'] = true;
    } elseif ($payload['id']) {
        $payload['score'] = apply_plugin_filters('score', $payload['score'], $payload['best'], $payload['id'], $payload['slug']);
    }

    if ($payload['count']) {
        $payload['disabled'] = true;
    } elseif ($payload['id']) {
        $payload['count'] = apply_plugin_filters('count', $payload['count'], $payload['id'], $payload['slug']);
    }

    if (! $payload['disabled']) {
        $payload['disabled'] = ! apply_plugin_filters('can_vote', ! $payload['disabled'], $payload['id'], $payload['slug']);
    }

    if (! $payload['id'] || $payload['disabled']) {
        $payload['greet'] = '';
    }

    if ($payload['id'] && ! $payload['disabled']) {
        $payload['greet'] = apply_plugin_filters('greet', $payload['greet'], $payload['id'], $payload['slug']);
    }

    $payload['best'] = max((int) $payload['best'], 1);
    $payload['count'] = max((int) $payload['count'], 0);
    $payload['score'] = min(max($payload['score'], 0), $payload['best']);

    $percentage = $payload['score'] / $payload['best'] * 100;
    $percentage = round($percentage, 2, PHP_ROUND_HALF_DOWN);
    $payload['percentage'] = min(max($percentage, 0), 100);

    $payload['gap'] = max((int) get_option(prefix('gap')), 0);
    $payload['width'] = $payload['score'] * $payload['size'] + $payload['gap'] * (int) $payload['score'];

    return view('markup', $payload);
}
