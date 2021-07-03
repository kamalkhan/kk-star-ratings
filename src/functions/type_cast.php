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

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function type_cast($value, string $type)
{
    switch ($type) {
        case 'array': return (array) $value;
        case 'boolean': return (bool) $value;
        case 'double': return (float) $value;
        case 'float': return (float) $value;
        case 'integer': return (int) $value;
        case 'string': return (string) $value;
    }

    return $value;
}
