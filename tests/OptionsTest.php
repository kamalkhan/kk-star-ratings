<?php

namespace Bhittani\StarRating;

use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    var $options = [
        'enable' => true,
    ];

    /** @test */
    function the_defaults_options_are_respected()
    {
        foreach ($this->options as $key => $value) {
            $this->assertSame($value, get_option($key));
        }
    }

    /** @test */
    function options_can_be_updated()
    {
        $this->assertTrue(get_option('enable'));

        update_option('enable', false);

        $this->assertEquals('', get_option('enable'));
    }
}
