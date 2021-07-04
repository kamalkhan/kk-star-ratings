<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions\metabox;

use function Bhittani\StarRating\functions\get_hof;
use function Bhittani\StarRating\functions\post_meta;
use function Bhittani\StarRating\functions\view;
use function kk_star_ratings as kksr;
use WP_Post;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function content(?string $type, WP_Post $post = null): void
{
    $factory = function (string $key, $default = null) use ($post) {
        return post_meta($post ? $post->ID : 0, $key, $default);
    };

    $get = get_hof(null, $factory, '_'.kksr('nick').'_', array_map('gettype', kksr('post_meta')));

    echo view('metabox/content.php', compact('get', 'type', 'post'));
}
