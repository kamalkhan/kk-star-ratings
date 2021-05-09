<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\functions;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

if (! defined('ABSPATH')) {
    http_response_code(404);
    exit();
}

function autoload(string $namespace, string $path, array $excludes = [], int $depth = -1): array
{
    $path = rtrim($path, '\/');
    $cutoffLength = strlen($path) + 1;
    $namespace = rtrim($namespace, '\\');

    $recursiveIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    $recursiveIterator->setMaxDepth($depth);
    $iterator = new RegexIterator($recursiveIterator, '/\.php$/');

    return array_reduce(iterator_to_array($iterator), function ($arr, $splFileInfo) use ($namespace, $excludes, $cutoffLength) {
        $filepath = (string) $splFileInfo;
        $filename = substr($filepath, $cutoffLength);

        if (in_array($filename, $excludes)) {
            return $arr;
        }

        $name = substr($filename, 0, -4);
        $function = $namespace.'\\'.preg_replace('/[\/\\\]/', '\\', $name);

        if (! function_exists($function)) {
            require_once $filepath;
        }

        return $arr = [$name => $function] + $arr;
    }, []);
}
