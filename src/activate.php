<?php

/*
 * This file is part of bhittani/kk-star-ratings.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * This source file is subject to the GPL v2 license that
 * is bundled with this source code in the file LICENSE.
 */

namespace Bhittani\StarRating;

register_activation_hook(KKSR_FILE, KKSR_NAMESPACE.'activate'); function activate()
{
    $previousVersion = getOption('ver', false);

    if ($previousVersion && version_compare($previousVersion, '3.0.1', '<')) {
        // We are upgrading, lets normalize the previous options.
        upgradeOptions();
        // Also normalize all the previous post ratings.
        upgradeRatings();
    }

    // if (! $previousVersion) {
    //     // We have never used any version of this plugin.
    //     // Save the default options.
    //     saveOptions(getDefaultOptions());
    // } else if (version_compare($previousVersion, '3.0.0', '<')) {
    //     // We were using a legacy version of the plugin.
    //     // Synchronize the options.
    //     saveOptions(getOptions());
    // }

    if (! $previousVersion || version_compare($previousVersion, '3.0.0', '<')) {
        saveOptions(getOptions());
    }

    // Save the new version.
    saveOption('ver', KKSR_VERSION);
}
