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
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function validate(?bool $valid, int $id, string $slug, array $payload): bool
{
    if (! is_null($valid)) {
        return $valid;
    }

    if ($payload['readonly'] ?? false) {
        throw new Exception(__('The ratings are readonly.', 'kk-star-ratings'));
    }

    $strategies = (array) option('strategies');

    if (is_archive()
        && ! in_array('archives', $strategies)
    ) {
        throw new Exception(__('You can not cast a vote in archives.', 'kk-star-ratings'));
    }

    if (! (is_user_logged_in()
        || in_array('guests', $strategies)
    )) {
        throw new Exception(__('You need to be authenticated to cast a vote.', 'kk-star-ratings'), 401);
    }

    $fingerprint = apply_filters(kksr('filters.fingerprint'), null, $id, $slug);

    if (in_array('unique', $strategies)
        && ! apply_filters(kksr('filters.unique'), null, $fingerprint, $id, $slug)
    ) {
        throw new Exception(__('You have already casted your vote.', 'kk-star-ratings'), 403);
    }

    return true;
}
