<?php

namespace Bhittani\StarRating;

use WP_UnitTestCase;

class TestCase extends WP_UnitTestCase
{
    static function wpTearDownAfterClass()
    {
        foreach (array_keys(getOptions()) as $key) {
            delete_option('kksr_'.$key);
        }

        remove_all_actions('wp_footer');
        wp_scripts()->dequeue(KKSR_SLUG);
        wp_scripts()->remove(KKSR_SLUG);
        wp_styles()->dequeue(KKSR_SLUG);
        wp_styles()->remove(KKSR_SLUG);
        delete_option('page_on_front');
        delete_option('show_on_front');
    }

    function tearDown()
    {
        static::wpTearDownAfterClass();

        parent::tearDown();
    }

    function atHome()
    {
        global $wp_query;
        $wp_query->is_home = true;

        return $this;
    }

    function onFrontPage()
    {
        global $wp_query;
        $wp_query->is_page = true;
        $post = static::factory()->post->create_and_get();
        $wp_query->queried_object = $post;
        update_option('show_on_front', 'page');
        update_option('page_on_front', $post->ID);

        return $this;
    }

    function inArchives()
    {
        global $wp_query;
        $wp_query->is_archive = true;

        return $this;
    }

    function onPost($postOrType = null, $type = 'post')
    {
        global $wp_query, $post;
        $p = is_string($postOrType) ? null : $postOrType;
        $type = is_string($postOrType) ? $postOrType : $type;
        $definitions = is_string($postOrType)
            ? ['post_type' => $postOrType] : ($type == 'post' ? null : ['post_type' => $type]);
        $wp_query->is_singular = true;
        $post = $p ?: static::factory()->post->create_and_get(null, $definitions);
        $wp_query->queried_object = $post;
        if ($type == 'post') {
            $wp_query->is_single = true;
        }
        if ($type == 'page') {
            $wp_query->is_page = true;
        }

        return $post;
    }

    function onPage($page = null)
    {
        return $this->onPost($page, 'page');
    }

    function onCustomPostType($type = 'custom')
    {
        return $this->onPost($type);
    }

    function onArchivePost($postOrType = null, $type = 'post')
    {
        $this->inArchives();

        $post = $this->onPost($postOrType, $type);

        global $wp_query;
        $wp_query->is_page = false;
        $wp_query->is_single = false;
        $wp_query->is_singular = false;

        return $post;
    }

    function onHomePost($postOrType = null, $type = 'post')
    {
        $this->atHome();

        $post = $this->onPost($postOrType, $type);

        global $wp_query;
        $wp_query->is_page = false;
        $wp_query->is_single = false;
        $wp_query->is_singular = false;

        return $post;
    }
}
