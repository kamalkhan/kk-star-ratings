<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions\admin\tabs;

use function Bhittani\StarRating\functions\get_hof;
use function Bhittani\StarRating\functions\view;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function rich_snippets(?array $old, string $tab): void
{
    $get = get_hof($old, kksr('functions.option'), kksr('nick').'_');

    echo view('admin/tabs/rich-snippets.php', compact('old', 'tab', 'get'));
}
