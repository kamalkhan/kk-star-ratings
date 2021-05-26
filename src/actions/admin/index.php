<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions\admin;

use function Bhittani\StarRating\functions\view;
use InvalidArgumentException;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function index(): void
{
    $tabs = apply_filters(kksr('filters.admin/tabs'), []);
    $active = apply_filters(kksr('filters.admin/active_tab'), reset($tabs));

    $errors = [];
    $payload = [];

    if (isset($_POST['submit'])) {
        $payload = array_map('sanitize_text_field', $_POST);
        unset($payload['submit']);

        try {
            // TODO: nonce check!
            do_action(kksr('actions.admin/save'), $payload, $active);
        } catch (InvalidArgumentException $e) {
            if (is_string($name = $e->getCode())) {
                $errors[$name] = array_merge($errors[$name] ?? [], [$e->getMessage()]);
            } else {
                $errors[0] = array_merge($errors[0] ?? [], [$e->getMessage()]);
            }
        }
    }

    $content = __('No content.', 'kk-star-ratings');

    if ($filename = preg_replace('/[^a-z0-9]+/', '', strtolower($active))) {
        // $old = function (string $key = null) use ($payload) {
        //     return is_null($key) ? $payload : ($payload[$key] ?? null);
        // };

        ob_start();
        do_action(kksr('actions.admin/tabs/'.$filename), $errors ? $payload : null, $active);
        $content = ob_get_clean();
    }

    $errorMessages = [];

    if ($errors) {
        $errorMessages[] = __('There were some errors while saving the options.', 'kk-star-ratings');
    }

    $errorMessages = array_merge($errorMessages, $errors[0] ?? []);

    echo view('admin/index.php', [
        'active' => $active,
        'author' => kksr('author'),
        'author_url' => kksr('author_url'),
        'content' => $content,
        'errors' => $errorMessages,
        'label' => kksr('name'),
        'slug' => kksr('slug'),
        'tabs' => $tabs,
        'version' => kksr('version'),
    ]);
}
