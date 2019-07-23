<?php

namespace Bhittani\StarRating;

class ShortcodeTest extends TestCase
{
    /** @test */
    function it_turns_into_markup()
    {
        $this->assertTrue(shortcode_exists('kkstarratings'));

        $post = $this->createPost();

        $this->onPost($post);

        $this->assertShortcodeMarkup($post, do_shortcode($post->post_content));
    }

    /** @test */
    function it_is_forced_when_a_post_id_is_provided()
    {
        update_option('kksr_exclude_locations', ['post']);

        $post = $this->createPost();

        $this->onPost($post);

        $this->assertShortcodeMarkup($post, do_shortcode('[kkstarratings id="'.$post->ID.'"]'));
        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test */
    function it_can_be_manually_forced()
    {
        update_option('kksr_exclude_locations', ['post']);

        $post = $this->createPost('[kkstarratings force]');

        $this->onPost($post);

        $this->assertShortcodeMarkup($post, do_shortcode($post->post_content));
        $this->assertTrue(wp_style_is(KKSR_SLUG));
        $this->assertTrue(wp_script_is(KKSR_SLUG));
    }

    /** @test */
    function it_does_not_leak()
    {
        update_option('kksr_exclude_locations', ['post']);

        $post = $this->createPost();

        $this->onPost($post);

        $this->assertEmpty(do_shortcode($post->post_content));
        $this->assertFalse(wp_style_is(KKSR_SLUG));
        $this->assertFalse(wp_script_is(KKSR_SLUG));
    }

    function createPost($content = '[kkstarratings]', $ratings = 8, $count = 2)
    {
        $post = static::factory()->post->create_and_get(null, [
            'post_status' => 'publish',
            'post_content' => $content,
        ]);

        update_post_meta($post->ID, '_kksr_casts', $count);

        update_post_meta($post->ID, '_kksr_ratings', $ratings);

        return $post;
    }

    function assertShortcodeMarkup($post, $markup, $ratings = 8, $count = 2)
    {
        return MarkupTest::assertMarkup($post, compact('count', 'ratings'), '', $markup);
    }
}
