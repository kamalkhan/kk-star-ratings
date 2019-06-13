<?php

namespace Bhittani\StarRating;

class EnqueueTest extends TestCase
{
    /** @test*/
    function it_enqueues_assets_on_the_home_page()
    {
        global $wp_query;
        $wp_query->is_home = true;
        $this->assertTrue(is_home());

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_on_the_home_page_if_home_is_an_excluded_location()
    {
        global $wp_query;
        $wp_query->is_home = true;
        $this->assertTrue(is_home());

        update_option('kksr_exclude_locations', ['home']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_on_the_front_page()
    {
        // Mimick front page.
        global $wp_query;
        $postId = static::factory()->post->create();
        update_option('page_on_front', $postId);
        update_option('show_on_front', 'page');
        $wp_query->is_page = true;
        $wp_query->queried_object = (object) ['ID' => $postId];
        $this->assertFalse($wp_query->is_home());
        $this->assertTrue($wp_query->is_front_page());

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_on_the_front_page_if_home_is_an_excluded_location()
    {
        // Mimick front page.
        global $wp_query;
        $postId = static::factory()->post->create();
        update_option('page_on_front', $postId);
        update_option('show_on_front', 'page');
        $wp_query->is_page = true;
        $wp_query->queried_object = (object) ['ID' => $postId];
        $this->assertFalse($wp_query->is_home());
        $this->assertTrue($wp_query->is_front_page());

        update_option('kksr_exclude_locations', ['home']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_archives()
    {
        global $wp_query;
        $wp_query->is_archive = true;
        $this->assertTrue(is_archive());

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_archives_if_archives_is_an_excluded_location()
    {
        global $wp_query;
        $wp_query->is_archive = true;
        $this->assertTrue(is_archive());

        update_option('kksr_exclude_locations', ['archives']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_posts()
    {
        global $wp_query, $post;
        $wp_query->is_single = true;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get();
        $wp_query->queried_object = $post;
        $this->assertTrue(is_single());
        $this->assertTrue(is_singular('post'));
        $this->assertEquals('post', get_post_type());

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_posts_if_post_is_an_excluded_location()
    {
        global $wp_query, $post;
        $wp_query->is_single = true;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get();
        $wp_query->queried_object = $post;
        $this->assertTrue(is_single());
        $this->assertTrue(is_singular('post'));
        $this->assertEquals('post', get_post_type());

        update_option('kksr_exclude_locations', ['post']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_pages()
    {
        global $wp_query, $post;
        $wp_query->is_page = true;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get(null, ['post_type' => 'page']);
        $wp_query->queried_object = $post;
        $this->assertTrue(is_page());
        $this->assertTrue(is_singular('page'));
        $this->assertEquals('page', get_post_type());

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_pages_if_page_is_an_excluded_location()
    {
        global $wp_query, $post;
        $wp_query->is_page = true;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get(null, ['post_type' => 'page']);
        $wp_query->queried_object = $post;
        $this->assertTrue(is_page());
        $this->assertTrue(is_singular('page'));
        $this->assertEquals('page', get_post_type());

        update_option('kksr_exclude_locations', ['page']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_custom_post_types()
    {
        global $wp_query, $post;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get(null, ['post_type' => 'custom']);
        $wp_query->queried_object = $post;
        $this->assertTrue(is_singular('custom'));
        $this->assertEquals('custom', get_post_type());

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_custom_post_types_if_the_custom_post_type_is_an_excluded_location()
    {
        global $wp_query, $post;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get(null, ['post_type' => 'custom']);
        $wp_query->queried_object = $post;
        $this->assertTrue(is_singular('custom'));
        $this->assertEquals('custom', get_post_type());

        update_option('kksr_exclude_locations', ['custom']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_custom_post_types_if_the_custom_post_type_is_exclusively_enabled()
    {
        global $wp_query, $post;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get(null, ['post_type' => 'custom']);
        $wp_query->queried_object = $post;
        $this->assertTrue(is_singular('custom'));
        $this->assertEquals('custom', get_post_type());

        update_post_meta($post->ID, '_kksr_status', 'enable');
        update_option('kksr_exclude_locations', ['custom']);

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_custom_post_types_if_the_custom_post_type_is_exclusively_disabled()
    {
        global $wp_query, $post;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get(null, ['post_type' => 'custom']);
        $wp_query->queried_object = $post;
        $this->assertTrue(is_singular('custom'));
        $this->assertEquals('custom', get_post_type());

        update_post_meta($post->ID, '_kksr_status', 'disable');

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_custom_post_types_if_it_belongs_to_an_excluded_category()
    {
        global $wp_query, $post;
        $wp_query->is_singular = true;
        $post = static::factory()->post->create_and_get();
        $wp_query->queried_object = $post;
        $this->assertTrue(is_singular());

        wp_set_post_categories($post->ID);

        update_option('kksr_exclude_categories', [1]);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_leak_assets()
    {
        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }
}
