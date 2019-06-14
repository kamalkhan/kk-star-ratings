<?php

namespace Bhittani\StarRating;

class EnqueueTest extends TestCase
{
    /** @test*/
    function it_enqueues_assets_on_the_home_page()
    {
        $this->atHome();

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_on_the_home_page_if_home_is_an_excluded_location()
    {
        $this->atHome();

        update_option('kksr_exclude_locations', ['home']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_on_the_front_page()
    {
        $this->onFrontPage();

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_on_the_front_page_if_home_is_an_excluded_location()
    {
        $this->onFrontPage();

        update_option('kksr_exclude_locations', ['home']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_archives()
    {
        $this->inArchives();

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_archives_if_archives_is_an_excluded_location()
    {
        $this->inArchives();

        update_option('kksr_exclude_locations', ['archives']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_posts()
    {
        $this->onPost();

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_posts_if_post_is_an_excluded_location()
    {
        $this->onPost();

        update_option('kksr_exclude_locations', ['post']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_pages()
    {
        $this->onPage();

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_pages_if_page_is_an_excluded_location()
    {
        $this->onPage();

        update_option('kksr_exclude_locations', ['page']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_custom_post_types()
    {
        $this->onCustomPostType();

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_custom_post_types_if_the_custom_post_type_is_an_excluded_location()
    {
        $this->onCustomPostType('custom');

        update_option('kksr_exclude_locations', ['custom']);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_enqueues_assets_in_custom_post_types_if_the_custom_post_type_is_exclusively_enabled()
    {
        $post = $this->onCustomPostType('custom');

        update_post_meta($post->ID, '_kksr_status', 'enable');
        update_option('kksr_exclude_locations', ['custom']);

        do_action('wp_enqueue_scripts');

        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_custom_post_types_if_the_custom_post_type_is_exclusively_disabled()
    {
        $post = $this->onCustomPostType();

        update_post_meta($post->ID, '_kksr_status', 'disable');

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_in_custom_post_types_if_it_belongs_to_an_excluded_category()
    {
        $post = $this->onPost();

        wp_set_post_categories($post->ID);

        update_option('kksr_exclude_categories', [1]);

        do_action('wp_enqueue_scripts');

        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    /** @test*/
    function it_does_not_enqueue_assets_if_globally_disabled()
    {
        $this->atHome();

        update_option('kksr_enable', 0);

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
