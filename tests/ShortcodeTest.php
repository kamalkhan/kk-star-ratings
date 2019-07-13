<?php

namespace Bhittani\StarRating;

class ShortcodeTest extends TestCase
{
    /** @test */
    function it_turns_into_markup()
    {
        $this->assertTrue(shortcode_exists('kkstarratings'));

        $post = static::factory()->post->create_and_get(['post_content' => '[kkstarratings]']);

        $this->onPost($post);

        MarkupTest::assertMarkup($post, [], PHP_EOL);
    }
}
