<?php

/**
 * Plugin Name:     kk Star Ratings
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

define('KKSR_FILE', __FILE__);
define('KKSR_PLUGIN', plugin_basename(KKSR_FILE));
define('KKSR_VERSION', '4.0.0-alpha');
define('KKSR_PREFIX', 'kksr_');
define('KKSR_SLUG', 'kk-star-ratings');
define('KKSR_LABEL', 'kk Star Ratings');
define('KKSR_SHORTCODE', 'kkstarratings');
define('KKSR_NAMESPACE', 'Bhittani\StarRating\\');
define('KKSR_PATH', plugin_dir_path(KKSR_FILE));
define('KKSR_PATH_SRC', KKSR_PATH . 'src/');
define('KKSR_PATH_VIEWS', KKSR_PATH . 'views/');
define('KKSR_PATH_PUBLIC', KKSR_PATH . 'public/');
define('KKSR_ASSET', plugin_dir_url(KKSR_FILE) . 'public/');

//
