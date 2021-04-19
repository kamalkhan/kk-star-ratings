<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use function Bhittani\StarRating\prefix;
use function Bhittani\StarRating\meta_prefix;
use function Bhittani\StarRating\add_plugin_action;
use function Bhittani\StarRating\add_plugin_filter;

class kkStarRatings
{
    protected $slugs = [];

    public function __construct($slugs)
    {
        $this->slugs = (array) $slugs;

        add_plugin_filter('count', [$this, 'countFilter'], 9, 3);
        add_plugin_filter('score', [$this, 'scoreFilter'], 9, 4);
        add_plugin_filter('greet', [$this, 'greetFilter'], 9, 3);
        add_plugin_filter('validate', [$this, 'validateFilter'], 9, 3);
        add_plugin_filter('can_vote', [$this, 'canVoteFilter'], 9, 3);
        add_plugin_action('vote', [$this, 'voteAction'], 9, 4);
    }

    public function countFilter($count, $id, $slug)
    {
        if (! in_array($slug, $this->slugs)) {
            return $count;
        }

        return max(0, (int) get_post_meta($id, $this->metaPrefix('casts', $slug), true));
    }

    public function scoreFilter($score, $best, $id, $slug)
    {
        if (! in_array($slug, $this->slugs)) {
            return $score;
        }

        $count = $this->countFilter(null, $id, $slug);

        if (! $count) {
            return 0;
        }

        $counter = (float) get_post_meta($id, $this->metaPrefix('ratings', $slug), true);
        $score = $counter / $count / 5 * $best;
        $score = round($score, 1, PHP_ROUND_HALF_DOWN);

        return min(max($score, 0), $best);
    }

    public function greetFilter($greet, $id, $slug)
    {
        if (! in_array($slug, $this->slugs)) {
            return $greet;
        }

        $type = get_post_type($id);

        if (! $type) {
            return $greet;
        }

        return str_replace('[type]', $type, $greet);
    }

    public function validateFilter($bool, $id, $slug)
    {
        if (! in_array($slug, $this->slugs)) {
            return $bool;
        }

        if (! $id) {
            return $bool;
        }

        $status = get_post_meta($id, $this->metaPrefix('status', $slug), true);

        if ($status == 'enable') {
            return true;
        }

        if ($status == 'disable') {
            return false;
        }

        $categories = array_map(function ($category) {
            return $category->term_id;
        }, get_the_category($id));

        $excludedCategories = (array) get_option(prefix('exclude_categories'), []);

        if (count($categories) !== count(array_diff($categories, $excludedCategories))) {
            return false;
        }

        if (in_array(get_post_type($id), (array) get_option(prefix('exclude_locations')))) {
            return false;
        }

        return $bool;
    }

    public function canVoteFilter($bool, $id, $slug)
    {
        if (! in_array($slug, $this->slugs)) {
            return $bool;
        }

        $strategies = (array) get_option(prefix('strategies'), []);

        if (is_archive() && ! in_array('archives', $strategies)) {
            return false;
        }

        if (in_array('unique', $strategies)
            && in_array(md5($_SERVER['REMOTE_ADDR']), get_post_meta($id, $this->metaPrefix('ref', $slug)))
        ) {
            return false;
        }

        return $bool;
    }

    public function voteAction($score, $best, $id, $slug)
    {
        if (! in_array($slug, $this->slugs)) {
            return;
        }

        $count = $this->countFilter(null, $id, $slug);
        $counter = (float) get_post_meta($id, $this->metaPrefix('ratings', $slug), true);

        ++$count;
        $counter += $score / $best * 5;

        update_post_meta($id, $this->metaPrefix('casts', $slug), $count);
        update_post_meta($id, $this->metaPrefix('ratings', $slug), $counter);
        // Legacy support.
        update_post_meta($id, $this->metaPrefix('avg', $slug), $counter / $count);

        $ip = md5($_SERVER['REMOTE_ADDR']);

        add_post_meta($id, $this->metaPrefix('ref', $slug), $ip);
    }

    protected function metaPrefix($str, $slug = null)
    {
        $prefix = meta_prefix($str);

        if ($slug) {
            $prefix .= '_'.$slug;
        }

        return $prefix;
    }
}
