<?php

namespace Bhittani\StarRating;

class ActivateTest extends TestCase
{
    function getDefaultOptions(array $options = [])
    {
        return array_merge_recursive([
            'kksr_ver' => KKSR_VERSION,
            'kksr_stars' => 5,
            'kksr_enable' => true,
            'kksr_strategies' => ['guests', 'unique'],
            'kksr_position' => 'top-left',
            'kksr_exclude_locations' => [],
            'kksr_exclude_categories' => [],
        ], $options);
    }

    /** @test */
    function it_stores_the_version_string()
    {
        $this->assertFalse(get_option('kksr_ver'));

        activate();

        $this->assertEquals(KKSR_VERSION, get_option('kksr_ver'));
    }

    /** @test */
    function it_updates_the_previous_version_string()
    {
        update_option('kksr_ver', '2.5');

        $this->assertEquals('2.5', get_option('kksr_ver'));

        activate();

        $this->assertEquals(KKSR_VERSION, get_option('kksr_ver'));
    }

    /** @test */
    function it_stores_the_options_if_the_plugin_was_never_installed()
    {
        $options = $this->getDefaultOptions();

        foreach (array_keys($options) as $key) {
            $this->assertFalse(get_option($key));
        }

        activate();

        foreach ($options as $key => $value) {
            $this->assertEquals($value, get_option($key), sprintf(
                "Option '%s' does not contain the expected value.",
                $key
            ));
        }
    }

    /** @test */
    function it_merges_the_options_if_the_plugin_version_was_older_than_three()
    {
        $options = $this->getDefaultOptions();

        foreach (array_keys($options) as $key) {
            $this->assertFalse(get_option($key));
        }

        update_option('kksr_ver', '2.6.5');
        update_option('kksr_position', 'top-right');

        activate();

        $options['kksr_position'] = 'top-right';

        foreach ($options as $key => $value) {
            $this->assertEquals($value, get_option($key), sprintf(
                "Option '%s' does not contain the expected value.",
                $key
            ));
        }
    }

    /** @test */
    function it_does_not_store_the_options_if_the_plugin_version_was_three_or_newer()
    {
        activate();

        update_option('kksr_position', 'top-right');

        activate();

        $this->assertEquals('top-right', get_option('kksr_position'));
    }

    /** @test */
    function it_normalizes_all_the_5_star_post_ratings_if_the_plugin_version_was_older_than_three()
    {
        $postId0 = static::factory()->post->create();
        $postId1 = static::factory()->post->create();
        $postId2 = static::factory()->post->create();
        $postId3 = static::factory()->post->create();
        $postId4 = static::factory()->post->create();

        update_option('kksr_ver', '2.6.5');

        update_post_meta($postId0, '_kksr_avg', null);
        update_post_meta($postId0, '_kksr_casts', null);

        update_post_meta($postId1, '_kksr_avg', 4);
        update_post_meta($postId1, '_kksr_casts', 2);

        update_post_meta($postId2, '_kksr_avg', 3.3);
        update_post_meta($postId2, '_kksr_casts', 3);

        update_post_meta($postId3, '_kksr_avg', 5.1);
        update_post_meta($postId3, '_kksr_casts', 150);

        update_post_meta($postId4, '_kksr_avg', -5);
        update_post_meta($postId4, '_kksr_casts', 2);

        activate();

        $this->assertEquals('', $count = get_post_meta($postId0, '_kksr_casts', true));
        $this->assertEquals(0, $ratings = get_post_meta($postId0, '_kksr_ratings', true));
        $this->assertEquals(0, calculateScore($ratings, $count));

        $this->assertEquals(2, $count = get_post_meta($postId1, '_kksr_casts', true));
        $this->assertEquals(8, $ratings = get_post_meta($postId1, '_kksr_ratings', true));
        $this->assertEquals(4, calculateScore($ratings, $count));

        $this->assertEquals(3, $count = get_post_meta($postId2, '_kksr_casts', true));
        $this->assertEquals(10, $ratings = get_post_meta($postId2, '_kksr_ratings', true));
        $this->assertEquals(3.3, calculateScore($ratings, $count));

        $this->assertEquals(150, $count = get_post_meta($postId3, '_kksr_casts', true));
        $this->assertEquals(750, $ratings = get_post_meta($postId3, '_kksr_ratings', true));
        $this->assertEquals(5.0, calculateScore($ratings, $count));

        $this->assertEquals(2, $count = get_post_meta($postId4, '_kksr_casts', true));
        $this->assertEquals(2, $ratings = get_post_meta($postId4, '_kksr_ratings', true));
        $this->assertEquals(1.0, calculateScore($ratings, $count));
    }

    /** @test */
    function it_normalizes_all_the_X_star_post_ratings_if_the_plugin_version_was_older_than_three()
    {
        $postId1 = static::factory()->post->create();
        $postId2 = static::factory()->post->create();
        $postId3 = static::factory()->post->create();
        $postId4 = static::factory()->post->create();

        update_option('kksr_stars', 10);
        update_option('kksr_ver', '2.6.5');

        update_post_meta($postId1, '_kksr_avg', 8);
        update_post_meta($postId1, '_kksr_casts', 2);

        update_post_meta($postId2, '_kksr_avg', 6.7);
        update_post_meta($postId2, '_kksr_casts', 3);

        update_post_meta($postId3, '_kksr_avg', 10.1);
        update_post_meta($postId3, '_kksr_casts', 150);

        update_post_meta($postId4, '_kksr_avg', -5);
        update_post_meta($postId4, '_kksr_casts', 2);

        activate();

        $this->assertEquals(2, $count = get_post_meta($postId1, '_kksr_casts', true));
        $this->assertEquals(8, $ratings = get_post_meta($postId1, '_kksr_ratings', true));
        $this->assertEquals(8, calculateScore($ratings, $count, 10));

        $this->assertEquals(3, $count = get_post_meta($postId2, '_kksr_casts', true));
        $this->assertEquals(10, $ratings = get_post_meta($postId2, '_kksr_ratings', true));
        $this->assertEquals(6.7, calculateScore($ratings, $count, 10));

        $this->assertEquals(150, $count = get_post_meta($postId3, '_kksr_casts', true));
        $this->assertEquals(750, $ratings = get_post_meta($postId3, '_kksr_ratings', true));
        $this->assertEquals(10.0, calculateScore($ratings, $count, 10));

        $this->assertEquals(2, $count = get_post_meta($postId4, '_kksr_casts', true));
        $this->assertEquals(1, $ratings = get_post_meta($postId4, '_kksr_ratings', true));
        $this->assertEquals(1.0, calculateScore($ratings, $count, 10));
    }
}
