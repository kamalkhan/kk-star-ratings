<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

if (! defined('ABSPATH')) {
    http_response_code(404);
    exit();
}

if (! function_exists('kk_star_ratings')) {
    function kk_star_ratings($idOrPost = null)
    {
        $id = null;

        if ($idOrPost) {
            $id = is_object($idOrPost) ? $idOrPost->ID : $idOrPost;
        }

        return Bhittani\StarRating\response(compact('id'), false);
    }
}

if (! function_exists('kk_star_ratings_get')) {
    function kk_star_ratings_get($limit = 5, $taxonomyId = null, $offset = 0)
    {
        global $wpdb;
        $postsTable = $wpdb->posts;
        $postMetaTable = $wpdb->prefix.'postmeta';

        $queryJoins = "
            JOIN {$postMetaTable} postmeta_ratings
                ON posts.ID = postmeta_ratings.post_id
            JOIN {$postMetaTable} postmeta_casts
                ON posts.ID = postmeta_casts.post_id
        ";

        $querySelect = "
            SELECT
                posts.ID,
                postmeta_ratings.meta_value AS ratings,
                postmeta_casts.meta_value AS casts,
                ROUND(CAST(postmeta_ratings.meta_value AS FLOAT) / CAST(postmeta_casts.meta_value AS DOUBLE), 1) AS score
            FROM {$postsTable} posts
        ";

        $queryConditions = "
            WHERE
                posts.post_status = 'publish'
                AND CAST(postmeta_casts.meta_value AS UNSIGNED) != 0
                AND postmeta_casts.meta_key = '_kksr_casts'
                AND postmeta_ratings.meta_key = '_kksr_ratings'
        ";

        $queryOrder = '
            ORDER BY
                score DESC,
                CAST(postmeta_casts.meta_value AS UNSIGNED) DESC
        ';

        $queryLimit = 'LIMIT %d, %d';

        $queryArgs = [$offset, $limit];

        if ($taxonomyId) {
            $termTaxonomyTable = $wpdb->prefix.'term_taxonomy';
            $termRelationshipsTable = $wpdb->prefix.'term_relationships';

            $queryJoins .= "
                JOIN {$termRelationshipsTable} term_relations
                    ON posts.ID = term_relations.object_id
                JOIN {$termTaxonomyTable} term_taxonomies
                    ON term_relations.term_taxonomy_id = term_taxonomies.term_taxonomy_id
            ";

            $queryConditions .= '
                AND term_taxonomies.term_id=%d
            ';

            $queryArgs = [$taxonomyId, $offset, $limit];
        }

        $query = $querySelect
            .PHP_EOL.$queryJoins
            .PHP_EOL.$queryConditions
            .PHP_EOL.$queryOrder
            .PHP_EOL.$queryLimit;

        $preparedQuery = $wpdb->prepare($query, ...$queryArgs);

        return $wpdb->get_results($preparedQuery);
    }
}
