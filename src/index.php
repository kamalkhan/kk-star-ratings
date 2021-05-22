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

use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

require_once __DIR__.'/hooks.php';

add_action('plugins_loaded', kk_star_ratings('core.kernel'));

add_action('wp_enqueue_scripts', kksr('core.assets'));
add_action('wp_ajax_'.kksr('slug'), kksr('core.controller'));
add_action('wp_ajax_nopriv_'.kksr('slug'), kksr('core.controller'));

// // add_shortcode('kkratings', kksr('core.shortcode'));
// // add_shortcode('kkstarratings', kksr('core.shortcode'));
add_shortcode('kk-star-ratings', kksr('core.shortcode'));
