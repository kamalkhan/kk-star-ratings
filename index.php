<?php

/**
 * Plugin Name:     kk Star Ratings
 * Plugin URI:      https://github.com/kamalkhan/kk-star-ratings
 * Description:     Allow blog visitors to involve and interact more effectively with your website by rating posts.
 * Author:          Kamal Khan
 * Author URI:      http://bhittani.com
 * Text Domain:     kk-star-ratings
 * Domain Path:     /languages
 * Version:         3.0.0
 *
 * @package         Bhittani\StarRating
 */

if (! defined('ABSPATH')) {
    header('HTTP/1.0 Not Found', true, 404);
    die();
}

define('KKSR_FILE', __FILE__);
define('KKSR_VERSION', '3.0.0');
define('KKSR_SLUG', 'kk-star-ratings');
define('KKSR_LABEL', 'kk Star Ratings');
define('KKSR_NAMESPACE', 'Bhittani\StarRating\\');
define('KKSR_PATH', plugin_dir_path(__FILE__));
define('KKSR_SRC_PATH', KKSR_PATH . 'src/');
define('KKSR_PUBLIC_PATH', KKSR_PATH . 'public/');
define('KKSR_URI', plugin_dir_url(__FILE__) . 'public/');
