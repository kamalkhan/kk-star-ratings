<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * This source file is subject to the GPL v2 license that
 * is bundled with this source code in the file LICENSE.
 */

if (! function_exists('kk_star_ratings')) {
    function kk_star_ratings($post = null, $force = null)
    {
        $force = is_null($force) ? ($post ? true : false) : $force;

        return \Bhittani\StarRating\markup(null, $force, $post);
    }
}

if (! function_exists('kk_star_ratings_get')) {
    function kk_star_ratings_get($limit = 5, $taxonomyId = null, $offset = 0)
    {
        global $wpdb;
        $postsTable = $wpdb->posts;
        $postMetaTable = $wpdb->prefix.'postmeta';
        $stars = \Bhittani\StarRating\getOption('stars');
        $base = $stars / 5;

        $querySelect = "
            SELECT
                posts.ID,
                ROUND(postmeta_ratings.meta_value / postmeta_count.meta_value * %f, 1) score
            FROM {$postsTable} posts
        ";

        $queryJoins = "
            JOIN {$postMetaTable} postmeta_ratings
                ON posts.ID = postmeta_ratings.post_id
            JOIN {$postMetaTable} postmeta_count
                ON posts.ID = postmeta_count.post_id
        ";

        $queryConditions = "
            WHERE
                posts.post_status = 'publish'
                AND CAST(postmeta_count.meta_value AS UNSIGNED) != 0
                AND postmeta_count.meta_key = '_kksr_count'
                AND postmeta_ratings.meta_key = '_kksr_ratings'
        ";

        $queryOrder = '
            ORDER BY
                score DESC,
                CAST(postmeta_count.meta_value AS UNSIGNED) DESC
        ';

        $queryLimit = 'LIMIT %d, %d';

        $queryArgs = [$base, $offset, $limit];

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

            $queryArgs = [$base, $taxonomyId, $offset, $limit];
        }

        $query = $querySelect
            .PHP_EOL.$queryJoins
            .PHP_EOL.$queryConditions
            .PHP_EOL.$queryOrder
            .PHP_EOL.$queryLimit;

        $preparedQuery = call_user_func_array([$wpdb, 'prepare'], array_merge([$query], $queryArgs));

        return $wpdb->get_results($preparedQuery);
    }
}
