<?php

namespace Bhittani\StarRating;

class MarkupTest extends TestCase
{
    /** @test */
    function it_shows_the_markup_in_posts()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        update_post_meta($post->ID, '_kksr_count', 3);
        update_post_meta($post->ID, '_kksr_ratings', 10);

        $this->onPost($post);

        $this->assertMarkup(['id' => $post->ID, 'total' => 10, 'count' => 3], $post);
    }

    /** @test */
    function it_does_not_show_the_markup_in_posts_that_are_explicitly_disabled()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_post_meta($post->ID, '_kksr_status', 'disable');

        $this->assertContents($post);
    }

    /** @test */
    function it_does_not_show_the_markup_in_posts_if_globally_disabled()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_enable', 0);

        $this->assertContents($post);
    }

    /** @test */
    function it_does_not_show_the_markup_in_archive_posts_if_archives_is_an_excluded_location()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onArchivePost($post);

        update_option('kksr_exclude_locations', ['archives']);

        $this->assertContents($post);
    }

    /** @test */
    function it_does_not_show_the_markup_in_home_posts_if_home_is_an_excluded_location()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onHomePost($post);

        update_option('kksr_exclude_locations', ['home']);

        $this->assertContents($post);
    }

    /** @test */
    function it_does_not_show_the_markup_in_custom_posts_if_custom_post_is_an_excluded_location()
    {
        $post = static::factory()->post->create_and_get([
            'post_content' => 'content',
        ], ['post_type' => 'custom']);

        $this->onPost($post);

        update_option('kksr_exclude_locations', ['custom']);

        $this->assertContents($post);
    }

    function assertContents($post, $expectation = null, $assertion = null)
    {
        global $page, $pages;
        $page = 1;
        $pages = [$post->post_content];

        if (is_null($expectation)) {
            $expectation = $expectation ?: ('<p>'.get_the_content().'</p>'.PHP_EOL);
        }

        if (is_null($assertion)) {
            ob_start();
            the_content();
            $assertion = ob_get_clean();
        }

        $this->assertEquals($expectation, $assertion);

        return $this;
    }

    function assertMarkup(array $payload = [], $post, $content = null, $assertion = null)
    {
        global $page, $pages;
        $page = 1;
        $pages = [$post->post_content];

        $payload = array_merge([
            'size' => 24,
            'count' => 0,
            'total' => 0,
            'stars' => 5,
            'isRtl' => false,
        ], $payload);

        $payload['percent'] = isset($payload['percent'])
            ? $payload['percent'] : calculatePercentage($payload['total'], $payload['count']);

        $payload['score'] = isset($payload['score'])
            ? $payload['score'] : calculateScore($payload['total'], $payload['count'], $payload['stars']);

        $payload['width'] = isset($payload['width'])
            ? $payload['width'] : $payload['score'] * $payload['size'] + ((int) $payload['score'] * 4);

        extract($payload);

        ob_start();
        include KKSR_PATH_VIEWS.'star.php';
        $starMarkup = ob_get_clean();

        $starsMarkup = '';

        for ($i = 1; $i <= $stars; ++$i) {
            $starsMarkup .= $starMarkup;
        }

        ob_start();
        include KKSR_PATH_VIEWS.'markup.php';
        $markup = ob_get_clean();

        if (is_null($assertion)) {
            ob_start();
            the_content();
            $assertion = ob_get_clean();
        }

        $content = $content ?: ('<p>'.get_the_content().'</p>'.PHP_EOL);

        $expectation = $content.$markup;

        $this->assertEquals($expectation, $assertion);

        return $this;
    }
}