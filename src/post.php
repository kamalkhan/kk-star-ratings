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
    exit();
}

add_filter('the_content', __NAMESPACE__.'\content_filter', 10);
function content_filter($content)
{
    $shortcode = config('shortcode');

    if (has_shortcode($content, $shortcode)
        // Legacy support
        || has_shortcode($content, 'kkratings')
    ) {
        return $content;
    }

    // if (! validate()) {
    //     return $content;
    // }

    if (in_array(get_post_type(), (array) get_option(prefix('manual_control'), []))) {
        return $content;
    }

    $align = 'left';
    $valign = 'top';

    $position = get_option(prefix('position'));

    if (strpos($position, 'top-') === 0) {
        $valign = 'top';
        $align = substr($position, 4);
    } elseif (strpos($position, 'bottom-') === 0) {
        $valign = 'bottom';
        $align = substr($position, 7);
    }

    $shortcode = "[{$shortcode} force=\"false\" valign=\"{$valign}\" align=\"{$align}\"]";

    return $valign == 'top' ? ($shortcode.$content) : ($content.$shortcode);
}

add_action('wp_head', __NAMESPACE__.'\structured_data');
function structured_data()
{
    if (! get_option(prefix('enable'))) {
        return;
    }

    if (get_option(prefix('grs')) && (is_singular())) {
        $id = get_post_field('ID');
        $title = htmlentities(get_post_field('post_title'));
        $best = max((int) get_option(prefix('stars')), 1);
        $count = apply_plugin_filters('count', null, $id, null);
        $score = apply_plugin_filters('score', null, $best, $id, null);

        if ($score) {
            echo '<script type="application/ld+json">';
            $sd = get_option(prefix('sd'));
            $sd = str_replace('[title]', $title, $sd);
            $sd = str_replace('[best]', $best, $sd);
            $sd = str_replace('[count]', $count, $sd);
            $sd = str_replace('[score]', $score, $sd);
            echo $sd;
            echo '</script>';
        }
    }
}
