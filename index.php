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
    http_response_code(404);
    die();
}

define('KKSR_FILE', __FILE__);
define('KKSR_PLUGIN', plugin_basename(KKSR_FILE));
define('KKSR_VERSION', '3.0.0');
define('KKSR_PREFIX', 'kksr_');
define('KKSR_SLUG', 'kk-star-ratings');
define('KKSR_LABEL', 'kk Star Ratings');
define('KKSR_SHORTCODE', 'kkstarratings');
define('KKSR_NAMESPACE', 'Bhittani\StarRating\\');
define('KKSR_PATH', plugin_dir_path(KKSR_FILE));
define('KKSR_PATH_SRC', KKSR_PATH . 'src/');
define('KKSR_PATH_VIEWS', KKSR_PATH . 'views/');
define('KKSR_PATH_PUBLIC', KKSR_PATH . 'public/');
define('KKSR_URI', plugin_dir_url(KKSR_FILE) . 'public/');
define('KKSR_OPTIONS', [
    // General
    'enable' => true,
    'ver' => KKSR_VERSION,
    'position' => 'top-left',
    'exclude_locations' => [],
    'exclude_categories' => [],
    'strategies' => ['guests', 'unique'],
    // Rich Snippets
    'grs' => true,
    'sd_type' => 'CreativeWork',
    'sd_context' => 'https://schema.org/',
    // Appearance
    'stars' => 5,
    'size' => 24,
    'fill_color_star' => '#ffffff',
    'stroke_color_star' => '#333333',
    'fill_color_active_star' => '#dddddd',
    'stroke_color_active_star' => '#333333',
    'fill_color_hover_star' => '#f2fa6f',
    'stroke_color_hover_star' => '#333333',
]);

require_once KKSR_PATH_SRC . 'functions.php';
require_once KKSR_PATH_SRC . 'activate.php';
require_once KKSR_PATH_SRC . 'enqueue.php';
require_once KKSR_PATH_SRC . 'markup.php';
require_once KKSR_PATH_SRC . 'admin.php';
require_once KKSR_PATH_SRC . 'ajax.php';
require_once KKSR_PATH_SRC . 'structure.php';
require_once KKSR_PATH_SRC . 'shortcode.php';
require_once KKSR_PATH_SRC . 'legacy.php';
