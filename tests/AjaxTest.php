<?php

namespace Bhittani\StarRating;

function header() {}
function status_header() {}
$die;
function wp_die($json) { global $die; $die = json_decode($json, true); }
// function check_ajax_referer() { return true; }

class AjaxTest extends TestCase
{
    function setUp()
    {
        parent::setUp();

        global $die;
        $die = null;

        $_REQUEST['nonce'] = wp_create_nonce(KKSR_SLUG);
        update_option('kksr_strategies', ['guests']);
    }

    /** @test*/
    function it_allows_authenticated_users_to_vote()
    {
        $user = static::factory()->user->create_and_get();
        wp_set_current_user($user->ID);

        $post = static::factory()->post->create_and_get();

        $_REQUEST['nonce'] = wp_create_nonce(KKSR_SLUG);
        $_POST['id'] = $post->ID;
        $_POST['rating'] = 4;

        update_option('kksr_strategies', []);
        $this->assertTrue(is_user_logged_in());

        ajax();

        $this->assertVote(4, 1, $post);
    }

    /** @test*/
    function it_allows_guests_to_vote_if_guest_voting_is_allowed()
    {
        update_option('kksr_stars', 10);

        $post = static::factory()->post->create_and_get();

        $_POST['id'] = $post->ID;
        $_POST['rating'] = 8;

        $this->assertFalse(is_user_logged_in());
        $this->assertContains('guests', get_option('kksr_strategies', []));

        ajax();

        $this->assertVote(4, 1, $post);
    }

    /** @test*/
    function it_does_not_allow_guests_to_vote_if_guest_voting_is_not_allowed()
    {
        $post = static::factory()->post->create_and_get();

        update_option('kksr_strategies', []);

        ajax();

        $this->assertError('Unauthorized.', $post, '', '');
    }

    /** @test*/
    function it_enforces_unique_voting_based_on_ip_if_unique_ips_are_enforced()
    {
        $post = static::factory()->post->create_and_get();

        $_POST['id'] = $post->ID;
        $_POST['rating'] = 4;

        ajax();
        ajax();

        $this->assertVote(8, 2, $post);

        update_option('kksr_strategies', ['guests', 'unique']);

        ajax();

        $this->assertError('Not allowed to vote.', $post, 8, 2);
    }

    function assertVote($ratings, $count, $post, array $extra = [])
    {
        $score = calculateScore($ratings, $count, get_option('kksr_stars', 5));

        $this->assertPayloadSubset([
            'score' => apply_filters('kksr_score', $score),
            'count' => apply_filters('kksr_count', $count),
            'width' => apply_filters('kksr_width', calculateWidth($score)),
            'percentage' => apply_filters('kksr_percentage', calculatePercentage($ratings, $count)),
        ]);

        if ($extra) {
            $this->assertPayloadSubset($extra);
        }

        $this->assertAvg($score, $post);
        $this->assertRatings($ratings, $post);
        $this->assertVoteCount($count, $post);
    }

    function assertAvg($score, $post)
    {
        $id = is_object($post) ? $post->ID : $post;

        $this->assertEquals($score, get_post_meta($id, '_kksr_avg', true));
    }

    function assertRatings($ratings, $post)
    {
        $id = is_object($post) ? $post->ID : $post;

        $this->assertEquals($ratings, get_post_meta($id, '_kksr_ratings', true));
    }

    function assertVoteCount($count, $post)
    {
        $id = is_object($post) ? $post->ID : $post;

        $this->assertEquals($count, get_post_meta($id, '_kksr_casts', true));
    }

    function assertError($error, $post = null, $ratings = null, $count = null)
    {
        $this->assertPayloadSubset(compact('error'));

        if (! is_null($ratings)) {
            $this->assertRatings($ratings, $post);
        }

        if (! is_null($count)) {
            $this->assertVoteCount($count, $post);
        }
    }

    function assertPayloadSubset(array $subset)
    {
        global $die;

        $this->assertArraySubset($subset, $die);
    }

    function assertPayload(array $payload)
    {
        global $die;

        $this->assertEquals($payload, $die);
    }
}
