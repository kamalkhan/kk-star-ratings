<?php

namespace Bhittani\StarRating;

class StructureTest extends TestCase
{
    function setUp()
    {
        parent::setUp();

        update_option('kksr_grs', true);
    }

    /** @test*/
    function it_embeds_structured_data_for_posts_that_have_a_vote_count()
    {
        $post = $this->onPost();

        $this->assertStructuredData(
            ['id' => $post->ID],
            $this->getStructuredDataForPost($post)
        );
    }

    /** @test*/
    function it_embeds_structured_data_with_a_custom_context()
    {
        $post = $this->onPost();

        update_option('kksr_sd_context', $context = 'http://schema.org/');

        $this->assertStructuredData(
            ['id' => $post->ID, 'context' => $context],
            $this->getStructuredDataForPost($post)
        );
    }

    /** @test*/
    function it_embeds_structured_data_with_a_custom_schema_type()
    {
        $post = $this->onPost();

        update_option('kksr_sd_type', $type = 'Product');

        $this->assertStructuredData(
            ['id' => $post->ID, 'type' => $type],
            $this->getStructuredDataForPost($post)
        );
    }

    /** @test*/
    function it_does_not_embed_structured_data_for_posts_that_have_no_vote_count()
    {
        $post = $this->onPost();

        $structuredData = $this->getStructuredData($post, null, null);

        $this->assertEquals('', get_post_meta($post->ID, '_kksr_count', true));

        $this->assertEquals('', $structuredData);
    }

    /** @test*/
    function it_does_not_embed_structured_data_in_archives()
    {
        $this->inArchives();

        $this->assertEquals('', $this->getStructuredData());
    }

    /** @test*/
    function it_does_not_embed_structured_data_in_post_archives()
    {
        $post = $this->onArchivePost();

        $this->assertEquals('', $this->getStructuredDataForPost($post));
    }

    /** @test*/
    function it_does_not_embed_structured_data_when_grs_is_not_active()
    {
        update_option('kksr_grs', 0);

        $post = $this->onPost();

        $this->assertEquals('', $this->getStructuredDataForPost($post));
    }

    function getStructuredDataForPost($idOrPost, $ratings = 8, $count = 2)
    {
        $id = is_object($idOrPost) ? $idOrPost->ID : $idOrPost;

        if (! is_null($count)) {
            update_post_meta($id, '_kksr_count', $count);
        }

        if (! is_null($ratings)) {
            update_post_meta($id, '_kksr_ratings', $ratings);
        }

        return $this->getStructuredData();
    }

    function getStructuredData()
    {
        ob_start();

        structuredData();

        return ob_get_clean();
    }

    function assertStructuredData(array $payload, $assertion)
    {
        $payload = array_merge([
            'stars' => 5,
            'type' => 'CreativeWork',
            'context' => 'https://schema.org/',
        ], $payload);

        extract($payload);

        $name = isset($name) ? $name : get_the_title($id);
        $count = isset($count) ? $count : get_post_meta($id, '_kksr_count', true);
        $total = isset($total) ? $total : get_post_meta($id, '_kksr_ratings', true);
        $score = isset($score) ? $score : calculateScore($total, $count, $stars);

        ob_start();

        include KKSR_PATH_VIEWS.'structured-data.php';

        $this->assertEquals(ob_get_clean(), $assertion);

        return $this;
    }
}
