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
    $processed = false;
    $nonce = __FUNCTION__;
    $filename = preg_replace(['/ +/', '/[^a-z0-9_]+/'], ['_', ''], strtolower($active));

    if (isset($_POST['submit'])) {
        $processed = true;
        $payload = $_POST;
        unset($payload['_wpnonce'], $payload['_wp_http_referer'], $payload['submit']);

        try {
            if (wp_verify_nonce($_POST['_wpnonce'] ?? null, $nonce) === false) {
                throw new InvalidArgumentException(__('You can only save the options via the admin.', 'kk-star-ratings'));
            }

            do_action(kksr('actions.admin/save'), $payload, $active);

            if ($filename) {
                do_action(kksr('actions.admin/save/'.$filename), $payload, $active);
            }
        } catch (InvalidArgumentException $e) {
            if (is_string($name = $e->getCode())) {
                $errors[$name] = array_merge($errors[$name] ?? [], [$e->getMessage()]);
            } else {
                $errors[0] = array_merge($errors[0] ?? [], [$e->getMessage()]);
            }
        }
    }

    ob_start();
    do_action(kksr('actions.admin/content'), $errors ? $payload : null, $active);
    $content = ob_get_clean();

    if ($filename) {
        ob_start();
        do_action(kksr('actions.admin/tabs/'.$filename), $errors ? $payload : null, $active);
        $content .= ob_get_clean();
    }

    $globalErrors = [];

    if ($errors) {
        $processed = false;
        $globalErrors[] = __('There were some errors while saving the options.', 'kk-star-ratings');
    }

    $globalErrors = array_merge($globalErrors, $errors[0] ?? []);

    echo view('admin/index.php', [
        'active' => $active,
        'author' => kksr('author'),
        'authorUrl' => kksr('author_url'),
        'content' => $content,
        'errors' => $errors,
        'globalErrors' => $globalErrors,
        'label' => kksr('name'),
        'nonce' => $nonce,
        'processed' => $processed,
        'slug' => kksr('slug'),
        'tabs' => $tabs,
        'version' => kksr('version'),
    ]);
}
