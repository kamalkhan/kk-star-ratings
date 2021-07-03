<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bhittani\StarRating\actions;

use function Bhittani\StarRating\functions\post_meta;
use function kk_star_ratings as kksr;

if (! defined('KK_STAR_RATINGS')) {
    http_response_code(404);
    exit();
}

function save(float $outOf5, int $id, string $slug, array $payload): void
{
    $count = (int) apply_filters(kksr('filters.count'), null, $id, $slug);
    $ratings = (float) apply_filters(kksr('filters.ratings'), null, $id, $slug);

    // For safe keeping, ensure we have not already casted this vote.
    if ($count == ((int) $payload['count'] ?? 0)
        && $ratings == ((float) $payload['ratings'] ?? 0)
    ) {
        $newCount = $count + 1;
        $newRatings = $ratings + $outOf5;

        $fingerprint = apply_filters(kksr('filters.fingerprint'), null, $id, $slug);

        post_meta($id, [
            "count_{$slug}" => $newCount,
            "ratings_{$slug}" => $newRatings,
            "fingerprint_{$slug}[]" => $fingerprint,
        ]);

        // Legacy support...
        $legacySlug = $slug == 'default' ? '' : "_{$slug}";

        post_meta($id, [
            "casts{$legacySlug}" => $newCount, // < v5
            "ratings{$legacySlug}" => $newRatings, // < v5
            "ref{$legacySlug}[]" => $fingerprint, // v3, v4
            "avg{$legacySlug}" => $newRatings / $newCount, // < v3
        ]);
    }
}
