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
    }

    function tearDown()
    {
        static::wpTearDownAfterClass();
    }
}
