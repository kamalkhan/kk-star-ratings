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

use SplStack;
use RuntimeException;

if (! defined('ABSPATH')) {
    http_response_code(404);
    die();
}

function view($templates, array $payload = [])
{
    foreach ((array) $templates as $template) {
        $template = str_replace('.', '/', $template);

        if (strpos($template, '/php') === strlen($template) - 4) {
            $template = substr($template, 0, -4);
        }

        $filename = $template.'.php';

        $filepath = config('views').ltrim($filename, '\/');

        if (is_file($filepath)) {
            $name = str_replace('/', '.', $template);

            $content = get_view($filepath, $payload);

            $content = apply_plugin_filters('view', $content, $name);

            return apply_plugin_filters('view:'.$name, $content);
        }
    }

    throw new RuntimeException('None of the templates exist');
}

function get_view($__file__, array $__payload__ = [])
{
    static $__cascade__;

    if (! is_file($__file__)) {
        throw new RuntimeException("View {$__file__} does not exist");
    }

    $__cascade__ = $__cascade__ ?: new SplStack();

    $__cascade__->push(array_merge(
        $__cascade__->isEmpty() ? [] : $__cascade__->top(),
        $__payload__
    ));

    extract($__cascade__->top());

    ob_start();

    include $__file__;

    $__cascade__->pop();

    return ob_get_clean();
}
