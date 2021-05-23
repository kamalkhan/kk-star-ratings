<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\core;

use function Bhittani\StarRating\functions\calculate;
use function Bhittani\StarRating\functions\option;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function head(): void
{
    if (option('grs') && is_singular()) {
        $id = get_post_field('ID');
        $title = esc_html(get_post_field('post_title'));
        [$count, $score] = calculate($id, 'default');

        if ($count && $score) {
            $sd = '<script type="application/ld+json">'.trim(option('sd')).'</script>';
            $sd = str_replace('{title}', $title, $sd);
            $sd = str_replace('{best}', 5, $sd);
            $sd = str_replace('{count}', $count, $sd);
            $sd = str_replace('{score}', $score, $sd);

            echo apply_filters(kksr('filters.sd'), $sd);
        }
    }
}
