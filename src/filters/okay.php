<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\filters;

use function Bhittani\StarRating\functions\option;
use function count;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function okay(bool $okay, int $id, string $slug, bool $explicit = true): bool
{
    if (! option('enable')) {
        return false;
    }

    $excludedLocations = (array) option('exclude_locations');

    if ((is_front_page() || is_home())
        && in_array('home', $excludedLocations)
    ) {
        return false;
    }

    if (is_archive()
        && in_array('archives', $excludedLocations)
    ) {
        return false;
    }

    $type = get_post_type($id);

    if (in_array($type, (array) $excludedLocations)) {
        return false;
    }

    if (! $explicit && in_array($type, (array) option('manual_control'))) {
        return false;
    }

    $categories = array_map(function ($category) {
        return $category->term_id;
    }, get_the_category($id));

    $excludedCategories = (array) option('exclude_categories');

    if (count($categories) != count(array_diff($categories, $excludedCategories))) {
        return false;
    }

    $status = apply_filters(kksr('filters.status'), null, $id, $slug);

    if ($status === 'disable') {
        return false;
    }

    if ($status === 'enable') {
        return true;
    }

    return $okay;
}
