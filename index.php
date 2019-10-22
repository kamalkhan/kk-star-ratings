<?php

/**
 * Plugin Name:     kk Star Ratings
 * Plugin Slug:     kk-star-ratings
 * Plugin Nick:     kksr
 * Plugin URI:      https://github.com/kamalkhan/kk-star-ratings
 * Description:     Allow blog visitors to involve and interact more effectively with your website by rating posts.
 * Author:          Kamal Khan
 * Author URI:      http://bhittani.com
 * Text Domain:     kk-star-ratings
 * Domain Path:     /languages
 * Version:         4.0.0-alpha
 * License:         GPLv2 or later
 */

if (! defined('ABSPATH')) {
    http_response_code(404);
    die();
}

$steroid = require_once __DIR__.'/steroid/steroid.php';

$steroid(__FILE__, [
    'options' => [
        'enable' => true,
        'stars' => 5,
    ],

    'post-meta' => [
        'count' => 0,
        'counter' => 0,
        'best' => null,
    ],
]);
