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

function validate($default = true, $id = null, $slug = null)
{
    return (bool) apply_plugin_filters('validate', $default, $id, $slug);
}

add_plugin_filter('validate', __NAMESPACE__.'\validate_request', 9, 3);
function validate_request($bool, $id, $slug)
{
    $excludedLocations = (array) get_option(prefix('exclude_locations'), []);

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

    return $bool;
}

add_plugin_filter('can_vote', __NAMESPACE__.'\can_vote', 9, 3);
function can_vote($bool, $id, $slug)
{
    if (! is_user_logged_in()
        && ! in_array('guests', (array) get_option(prefix('strategies'), []))) {
        return false;
    }

    return $bool;
}
