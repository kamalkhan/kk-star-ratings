<?php

namespace Bhittani\StarRating;

class MarkupTest extends TestCase
{
    function setUp()
    {
        parent::setUp();

        update_option('kksr_strategies', ['guests']);
    }

    /** @test */
    function it_shows_the_markup_in_posts()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        update_post_meta($post->ID, '_kksr_count', 3);
        update_post_meta($post->ID, '_kksr_ratings', 10);

        $this->onPost($post);

        $this->assertMarkup($post, ['total' => 10, 'count' => 3]);
    }

    /** @test */
    function it_can_be_placed_at_the_top_left()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_position', 'top-left');

        $this->assertMarkup($post, ['placement' => 'top', 'alignment' => 'left']);
    }

    /** @test */
    function it_can_be_placed_at_the_top_right()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_position', 'top-right');

        $this->assertMarkup($post, ['placement' => 'top', 'alignment' => 'right']);
    }

    /** @test */
    function it_can_be_placed_at_the_top_center()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_position', 'top-center');

        $this->assertMarkup($post, ['placement' => 'top', 'alignment' => 'center']);
    }

    /** @test */
    function it_can_be_placed_at_the_bottom_left()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_position', 'bottom-left');

        $this->assertMarkup($post, ['placement' => 'bottom', 'alignment' => 'left']);
    }

    /** @test */
    function it_can_be_placed_at_the_bottom_right()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_position', 'bottom-right');

        $this->assertMarkup($post, ['placement' => 'bottom', 'alignment' => 'right']);
    }

    /** @test */
    function it_can_be_placed_at_the_bottom_center()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_position', 'bottom-center');

        $this->assertMarkup($post, ['placement' => 'bottom', 'alignment' => 'center']);
    }

    /** @test */
    function it_is_disabled_for_duplicate_ip_if_unique_ips_are_enforced()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_strategies', ['guests', 'unique']);
        update_post_meta($post->ID, '_kksr_ips', md5($_SERVER['REMOTE_ADDR']));

        $this->assertMarkup($post, ['disabled' => true]);
    }

    /** @test */
    function it_is_enabled_for_guests_if_voting_for_guests_is_allowed()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_strategies', ['guests']);

        $this->assertMarkup($post, ['disabled' => false]);
    }

    /** @test */
    function it_is_disabled_for_guests_if_voting_for_guests_is_not_allowed()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onPost($post);

        update_option('kksr_strategies', []);

        $this->assertMarkup($post, ['disabled' => true]);
    }

    /** @test */
    function it_is_enabled_in_archives_if_voting_in_archives_is_allowed()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onArchivePost($post);

        update_option('kksr_strategies', ['guests', 'archives']);

        $this->assertMarkup($post, ['disabled' => false]);
    }

    /** @test */
    function it_is_disabled_in_archives_if_voting_in_archives_is_not_allowed()
    {
        $post = static::factory()->post->create_and_get(['post_content' => 'content']);

        $this->onArchivePost($post);

        $this->assertMarkup($post, ['disabled' => true]);
    }

    /** @test */
    function it_renders_in_posts_that_contain_the_shortcode_but_post_type_is_excluded()
    {
        update_option('kksr_exclude_locations', ['post']);

        $post = static::factory()->post->create_and_get(['post_content' => '[kkstarratings]']);

        $this->onPost($post);

        $this->assertMarkup($post, [], PHP_EOL);
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

    static function assertMarkup($post, array $payload = [], $content = null, $assertion = null)
    {
        global $page, $pages;
        $page = 1;
        $pages = [$post->post_content];

        $payload = array_merge([
            'id' => $post->ID,
            'size' => 24,
            'count' => 0,
            'total' => 0,
            'stars' => 5,
            // 'isRtl' => false,
            'disabled' => false,
            'placement' => 'top',
            'alignment' => 'left',
        ], $payload);

        $payload['percent'] = isset($payload['percent'])
            ? $payload['percent'] : calculatePercentage($payload['total'], $payload['count']);

        $payload['score'] = isset($payload['score'])
            ? $payload['score'] : calculateScore($payload['total'], $payload['count'], $payload['stars']);

        $payload['width'] = isset($payload['width'])
            ? $payload['width'] : calculateWidth($payload['score'], $payload['size']);

        extract($payload);

        ob_start();
        include KKSR_PATH_VIEWS.'markup.php';
        $markup = ob_get_clean();

        if (is_null($assertion)) {
            ob_start();
            the_content();
            $assertion = ob_get_clean();
        }

        if (is_null($content)) {
            $content = '<p>'.get_the_content().'</p>'.PHP_EOL;
        }

        $expectation = $placement === 'bottom' ? ($content.$markup) : ($markup.$content);

        static::assertEquals($expectation, $assertion);
    }
}
