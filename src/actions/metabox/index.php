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

use function Bhittani\StarRating\functions\view;
use function kk_star_ratings as kksr;
use WP_Post;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function index(?string $type, WP_Post $post = null): void
{
    ob_start();
    do_action(kksr('actions.metabox/content'), $type, $post);
    $content = ob_get_clean();

    echo view('metabox/index.php', [
        'content' => $content,
    ]);
}
