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
 * Version:         5.0
 * License:         GPLv2 or later
 */

use function Bhittani\StarRating\functions\autoload;
use function Bhittani\StarRating\functions\dot;

if (!defined('ABSPATH')) {
    http_response_code(404);
    exit();
}

if (file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    require_once $composer;
}

define('KK_STAR_RATINGS', __FILE__);

require_once __DIR__.'/src/functions/autoload.php';

function kk_star_ratings($keyOrItems = null, $default = null)
{
    static $config;

    if ($config) {
        if (is_array($keyOrItems)) {
            $config = array_merge($config, $keyOrItems);
        } elseif (! is_null($keyOrItems)) {
            return dot($config, $keyOrItems, $default);
        }
        return $config;
    }

    $file = __FILE__;
    $path = __DIR__.'/';
    $src = $path.'src/';
    $ns = 'Bhittani\StarRating\\';

    $config = [
        // Metadata
        'file' => $file,
        'url' => plugin_dir_url($file),
        'path' => plugin_dir_path($file),
        'signature' => plugin_basename($file),
    ] + get_file_data($file, [
        // Manifest
        'version' => 'Version',
        'name' => 'Plugin Name',
        'slug' => 'Plugin Slug',
        'nick' => 'Plugin Nick',
    ]) + [
        // Source
        'core' => autoload($ns.'core', $src.'core'),
        'actions' => autoload($ns.'actions', $src.'actions'),
        'filters' => autoload($ns.'filters', $src.'filters'),
        'functions' => autoload($ns.'functions', $src.'functions'),
    ] + [
        // Options
        'views' => $path.'views/',
        'options' => [
            // Appearance
            'gap' => 5,
            'greet' => 'Rate this {post}',
            'legend' => '{score}/{best} - ({count} {votes})',
            'size' => 24,
            'stars' => 5,
            // Rich snippets
            'grs' => true,
            'sd' => '
{
    "@context": "https://schema.org/",
    "@type": "CreativeWorkSeries",
    "name": "{title}",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{score}",
        "bestRating": "{best}",
        "ratingCount": "{count}"
    }
}
            ',
        ],
    ];

    return kk_star_ratings($keyOrItems, $default);
}

require_once __DIR__.'/src/index.php';
