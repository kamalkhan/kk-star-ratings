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

use InvalidArgumentException;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function view(string $__path, array $__payload = [], string $__base = null): string
{
    $__kksr = 'kk_star_ratings';
    $__base = rtrim($__base ?: $__kksr('views'), '\/').'/';
    $__view = function (string $path, array $payload = [], string $base = null) use ($__payload, $__base) {
        return view($path, array_merge($__payload, $payload), $base ?: $__base);
    };

    $resolve = function (string $base, string $path) use ($__kksr): string {
        if (is_file($path)) {
            return $path;
        }

        $path = trim($path, '\/');
        $template = $base.'/'.$path;
        $directory = $__kksr('slug');
        $parentTheme = get_template_directory().'/'.$directory.'/'.$path;
        $childTheme = get_stylesheet_directory().'/'.$directory.'/'.$path;

        if (is_file($childTheme)) {
            return $childTheme;
        }

        if (is_file($parentTheme)) {
            return $parentTheme;
        }

        if (is_file($template)) {
            return $template;
        }

        throw new InvalidArgumentException("The template '{$path}' could not be located at '{$template}'.");
    };

    $__template = $resolve($__base, $__path);

    unset($resolve);

    extract($__payload);

    ob_start();

    require $__template;

    return ob_get_clean();
}
