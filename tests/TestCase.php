<?php

namespace Bhittani\StarRating;

use WP_UnitTestCase;

class TestCase extends WP_UnitTestCase
{
    static function wpTearDownAfterClass()
    {
        foreach (array_keys(getOptions()) as $key) {
            delete_option($key);
        }

        wp_scripts()->dequeue(KKSR_SLUG);
        wp_styles()->dequeue(KKSR_SLUG);
        delete_option('page_on_front');
        delete_option('show_on_front');
    }

    function tearDown()
    {
        static::wpTearDownAfterClass();

        parent::tearDown();
    }
}
