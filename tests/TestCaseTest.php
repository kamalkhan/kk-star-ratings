<?php

namespace Bhittani\StarRating;

class TestCaseTest extends TestCase
{
    /** @test */
    function atHome()
    {
        parent::atHome();

        $this->assertTrue(is_home());
    }

    /** @test */
    function onFrontPage()
    {
        parent::onFrontPage();

        $this->assertFalse(is_home());
        $this->assertTrue(is_front_page());
    }

    /** @test */
    function inArchives()
    {
        parent::inArchives();

        $this->assertTrue(is_archive());
    }

    /** @test */
    function onPost($postOrType = null, $type = 'post')
    {
        $post = parent::onPost();

        $this->assertTrue(is_single($post));
        $this->assertTrue(is_singular('post'));
        $this->assertEquals('post', get_post_type($post));
    }

    /** @test */
    function onPage($page = null)
    {
        $page = parent::onPost('page');

        $this->assertTrue(is_page($page));
        $this->assertTrue(is_singular('page'));
        $this->assertEquals('page', get_post_type($page));
    }

    /** @test */
    function onCustomPostType($type = 'custom')
    {
        $custom = parent::onPost('custom');

        $this->assertTrue(is_singular('custom'));
        $this->assertEquals('custom', get_post_type($custom));
    }

    /** @test */
    function onArchivePost($postOrType = null, $type = 'post')
    {
        parent::onArchivePost();

        $this->assertFalse(is_single());
        $this->assertFalse(is_singular());
        $this->assertTrue(is_archive());
    }

    /** @test */
    function onHomePost($postOrType = null, $type = 'post')
    {
        parent::onHomePost();

        $this->assertFalse(is_single());
        $this->assertFalse(is_singular());
        $this->assertTrue(is_home());
    }
}
