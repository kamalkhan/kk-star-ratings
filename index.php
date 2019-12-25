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
 * Version:         4.1.3
 * License:         GPLv2 or later
 */

namespace Bhittani\StarRating;

if (! defined('ABSPATH')) {
    http_response_code(404);
    die();
}

define('KK_STAR_RATINGS', __FILE__);

if (file_exists($freemius = __DIR__.'/freemius.php')) {
    require_once $freemius;
}

require_once __DIR__.'/src/config.php';

config([
    'views' => __DIR__.'/views/',
    'shortcode' => 'kkstarratings',
    'options' => [
        // General
        'enable' => true,
        'strategies' => ['guests'],
        'manual_control' => [],
        'exclude_locations' => ['home', 'archives'],
        'exclude_categories' => [],
        'position' => 'top-left',
        // Appearance
        'gap' => 4,
        'stars' => 5,
        'size' => 24,
        'greet' => 'Rate this [type]',
        // Rich snippets
        'grs' => true,
        'sd' => <<<HTML
{
    "@context": "https://schema.org/",
    "@type": "CreativeWorkSeries",
    "name": "[title]",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "[score]",
        "bestRating": "[best]",
        "ratingCount": "[count]"
    }
}
HTML
    ],
]);

require_once __DIR__.'/src/global.php';
require_once __DIR__.'/src/hook.php';
require_once __DIR__.'/src/ajax.php';
require_once __DIR__.'/src/view.php';
require_once __DIR__.'/src/post.php';
require_once __DIR__.'/src/response.php';
require_once __DIR__.'/src/legacy.php';

if (is_admin()) {
    require_once __DIR__.'/src/activate.php';
    require_once __DIR__.'/src/admin.php';
    require_once __DIR__.'/src/metabox.php';
} else {
    require_once __DIR__.'/src/validate.php';
    require_once __DIR__.'/src/shortcode.php';
    require_once __DIR__.'/src/assets.php';
}

add_action('plugins_loaded', function () {
    do_action(prefix('init'));
});
