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

add_plugin_filter('count', __NAMESPACE__.'\count_filter', 9, 3);
function count_filter($count, $id, $slug)
{
    if ($slug) {
        return $count;
    }

    $count = (int) get_post_meta($id, meta_prefix('casts'), true);

    return max($count, 0);
}

add_plugin_filter('score', __NAMESPACE__.'\score_filter', 9, 4);
function score_filter($score, $best, $id, $slug)
{
    if ($slug) {
        return $score;
    }

    $count = count_filter(null, $id, null);
    $counter = (float) get_post_meta($id, meta_prefix('ratings'), true);

    if (! $count) {
        return 0;
    }

    $score = $counter / $count / 5 * $best;
    $score = round($score, 1, PHP_ROUND_HALF_DOWN);

    return min(max($score, 0), $best);
}

add_plugin_filter('greet', __NAMESPACE__.'\greet_filter', 9, 3);
function greet_filter($greet, $id, $slug)
{
    if ($slug) {
        return $greet;
    }

    $type = get_post_type($id);

    if (! $type) {
        return $greet;
    }

    return str_replace('[type]', $type, $greet);
}

add_plugin_filter('validate', __NAMESPACE__.'\validate_post', 9, 3);
function validate_post($bool, $id, $slug)
{
    if ($slug || ! $id) {
        return $bool;
    }

    // $id = get_post_field('ID');

    // if (! $id) {
    //     return $bool;
    // }

    $status = get_post_meta($id, meta_prefix('status'), true);

    if ($status == 'enable') {
        return true;
    }

    if ($status == 'disable') {
        return false;
    }

    $categories = array_map(function ($category) {
        return $category->term_id;
    }, get_the_category($id));

    $excludedCategories = (array) get_option(prefix('exclude_categories'), []);

    if (count($categories) !== count(array_diff($categories, $excludedCategories))) {
        return false;
    }

    if (in_array(get_post_type($id), (array) get_option(prefix('exclude_locations')))) {
        return false;
    }

    return $bool;
}

add_plugin_filter('can_vote', __NAMESPACE__.'\can_vote_post', 9, 3);
function can_vote_post($bool, $id, $slug)
{
    if ($slug) {
        return $bool;
    }

    $strategies = (array) get_option(prefix('strategies'), []);

    if (is_archive() && ! in_array('archives', $strategies)) {
        return false;
    }

    if (in_array('unique', $strategies)
        && in_array(md5($_SERVER['REMOTE_ADDR']), get_post_meta($id, meta_prefix('ref')))
    ) {
        return false;
    }

    return $bool;
}

add_plugin_action('vote', __NAMESPACE__.'\vote_post', 9, 4);
function vote_post($score, $best, $id, $slug)
{
    if ($slug) {
        return;
    }

    $count = count_filter(null, $id, null);
    $counter = (float) get_post_meta($id, meta_prefix('ratings'), true);

    ++$count;
    $counter += $score / $best * 5;

    update_post_meta($id, meta_prefix('casts'), $count);
    update_post_meta($id, meta_prefix('ratings'), $counter);
    // Legacy support.
    update_post_meta($id, meta_prefix('avg'), $counter / $count);

    $ip = md5($_SERVER['REMOTE_ADDR']);

    add_post_meta($id, meta_prefix('ref'), $ip);
}

add_action('wp_head', __NAMESPACE__.'\structured_data');
function structured_data()
{
    if (! get_option(prefix('enable'))) {
        return;
    }

    if (get_option(prefix('grs'))
        && (is_singular() || is_page())
    ) {
        $id = get_post_field('ID');
        $title = htmlentities(get_post_field('post_title'));
        $best = max((int) get_option(prefix('stars')), 1);
        $count = count_filter(null, $id, null);
        $score = score_filter(null, $best, $id, null);

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
