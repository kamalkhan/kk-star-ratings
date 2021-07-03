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

/** Find items with * support */
function find(array $items, string $key, $default = null)
{
    $isRegex = function (string $s) {
        $l = strlen($s);

        return strpos($s, '/') === 0 && strpos($s, '/', $l - 2) === ($l - 1);
    };

    foreach ($items as $k => $v) {
        if ($isRegex($k)) {
            if (preg_match($k, $key)) {
                return $v;
            }

            continue;
        }

        $rq = preg_quote($k, '/');
        $rs = preg_replace('/(?<!\\\)\\\\\*/', '.+?', $rq);

        if (preg_match('/'.$rs.'/', str_replace('*', '\*', $key))) {
            return $v;
        }
    }

    return $default;
}
