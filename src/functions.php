<?php

namespace Bhittani\StarRating;

function prefix($subject)
{
    if (strpos($subject, KKSR_PREFIX) === 0) {
        return $subject;
    }

    return KKSR_PREFIX.$subject;
}

function get_option($key)
{
    static $defaults;

    if (! $defaults) {
        $defaults = require __DIR__.'/options.php';
    }

    $default = isset($defaults[$key]) ? $defaults[$key] : null;

    return \get_option(prefix($key), $default);
}

function update_option($key, $value)
{
    // `false` does not update the value, so we will default to `null`,
    // which will set the value to an empty string, i.e. ''.
    return \update_option(prefix($key), $value ?: null);
}
