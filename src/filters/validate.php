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
use Exception;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function validate(bool $valid, int $id, string $slug, array $payload): bool
{
    if ($payload['readonly'] ?? false) {
        throw new Exception(__('The ratings are readonly.', 'kk-star-ratings'));
    }

    $strategies = (array) option('strategies');

    if (($payload['is_archive'] ?? false)
        && ! in_array('archives', $strategies)
    ) {
        throw new Exception(__('Rating in archives is not allowed.', 'kk-star-ratings'));
    }

    if (! (is_user_logged_in()
        || in_array('guests', $strategies)
    )) {
        throw new Exception(__('Only authenticated users can submit a rating.', 'kk-star-ratings', 401));
    }

    return $valid;
}
