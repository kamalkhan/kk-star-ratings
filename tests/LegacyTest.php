<?php

namespace Bhittani\StarRating;

class LegacyTest extends TestCase
{
    /** @test */
    function func_kk_star_ratings_returns_the_current_post_markup()
    {
        $post = $this->createPost();

        $this->onPost($post);

        $this->assertPostMarkup($post, kk_star_ratings());
    }

    /** @test */
    function func_kk_star_ratings_accepts_a_custom_post()
    {
        $post = $this->createPost();

        $this->assertPostMarkup($post, kk_star_ratings($post));
    }

    /** @test */
    function func_kk_star_ratings_accepts_a_custom_post_id()
    {
        $post = $this->createPost();

        $this->assertPostMarkup($post, kk_star_ratings($post->ID));
    }

    /** @test */
    function func_kk_star_ratings_get_returns_the_top_scored_posts()
    {
        global $wpdb;
        $wpdb->query('DELETE FROM '.$wpdb->posts);
        $wpdb->query('DELETE FROM '.$wpdb->prefix . 'postmeta');

        $post0 = $this->createPost(null, null);
        $post1 = $this->createPost(3, 1);
        $post2 = $this->createPost(10, 2);
        $post3 = $this->createPost(8, 2);
        $post4 = $this->createPost(15, 3);
        $post5 = $this->createPost(3, 1);

        $posts = kk_star_ratings_get(4);

        $this->assertNotNull($posts);
        $this->assertCount(4, $posts);

        $this->assertEquals($post4->ID, $posts[0]->ID);
        $this->assertEquals('5.0', $posts[0]->score);

        $this->assertEquals($post2->ID, $posts[1]->ID);
        $this->assertEquals('5.0', $posts[1]->score);

        $this->assertEquals($post3->ID, $posts[2]->ID);
        $this->assertEquals('4.0', $posts[2]->score);

        $this->assertEquals($post1->ID, $posts[3]->ID);
        $this->assertEquals('3.0', $posts[3]->score);
    }

    /** @test */
    function func_kk_star_ratings_get_accepts_a_taxonomy_id()
    {
        global $wpdb;
        $wpdb->query('DELETE FROM '.$wpdb->posts);
        $wpdb->query('DELETE FROM '.$wpdb->prefix . 'postmeta');

        $post0 = $this->createPost(null, null);
        $post1 = $this->createPost(3, 1);
        $post2 = $this->createPost(10, 2);
        $post3 = $this->createPost(8, 2);
        $post4 = $this->createPost(15, 3);
        $post5 = $this->createPost(3, 1);

        wp_set_post_categories($post1->ID, 2);
        $this->assertEmpty(wp_get_post_categories($post1->ID));

        $posts = kk_star_ratings_get(4, 1);

        $this->assertNotNull($posts);
        $this->assertCount(4, $posts);

        $this->assertEquals($post4->ID, $posts[0]->ID);
        $this->assertEquals('5.0', $posts[0]->score);

        $this->assertEquals($post2->ID, $posts[1]->ID);
        $this->assertEquals('5.0', $posts[1]->score);

        $this->assertEquals($post3->ID, $posts[2]->ID);
        $this->assertEquals('4.0', $posts[2]->score);

        $this->assertEquals($post5->ID, $posts[3]->ID);
        $this->assertEquals('3.0', $posts[3]->score);
    }

    /** @test */
    function func_kk_star_ratings_get_accepts_an_offset()
    {
        global $wpdb;
        $wpdb->query('DELETE FROM '.$wpdb->posts);
        $wpdb->query('DELETE FROM '.$wpdb->prefix . 'postmeta');

        $post0 = $this->createPost(null, null);
        $post1 = $this->createPost(3, 1);
        $post2 = $this->createPost(10, 2);
        $post3 = $this->createPost(8, 2);
        $post4 = $this->createPost(15, 3);
        $post5 = $this->createPost(6, 2);

        $posts = kk_star_ratings_get(4, null, 3);

        $this->assertNotNull($posts);
        $this->assertCount(2, $posts);

        $this->assertEquals($post5->ID, $posts[0]->ID);
        $this->assertEquals('3.0', $posts[0]->score);

        $this->assertEquals($post1->ID, $posts[1]->ID);
        $this->assertEquals('3.0', $posts[1]->score);
    }

    function createPost($ratings = 8, $count = 2)
    {
        $post = static::factory()->post->create_and_get(null, [
            'post_status' => 'publish',
            'post_content' => 'content',
        ]);

        update_post_meta($post->ID, '_kksr_count', $count);

        update_post_meta($post->ID, '_kksr_ratings', $ratings);

        return $post;
    }

    function assertPostMarkup($post, $markup, $ratings = 8, $count = 2)
    {
        return MarkupTest::assertMarkup($post, compact('count', 'ratings'), '', $markup);
    }
}
