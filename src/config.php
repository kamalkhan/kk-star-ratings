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

function config($keyOrValues = null, $default = null)
{
    static $config = [];

    if (! $config) {
        $file = KK_STAR_RATINGS;

        $url = plugin_dir_url($file);
        $path = plugin_dir_path($file);
        $signature = plugin_basename($file);

        $meta = get_file_data($file, [
            'name' => 'Plugin Name',
            'nick' => 'Plugin Nick',
            'slug' => 'Plugin Slug',
            'version' => 'Version',
        ]);

        $config = compact('file', 'signature', 'url', 'path') + $meta;
    }

    if (is_array($keyOrValues)) {
        return $config = $keyOrValues + $config;
    }

    if (is_null($keyOrValues)) {
        return $config;
    }

    return isset($config[$keyOrValues]) ? $config[$keyOrValues] : $default;
}
