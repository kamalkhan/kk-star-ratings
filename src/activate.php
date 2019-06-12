<?php

namespace Bhittani\StarRating;

register_activation_hook(KKSR_FILE, KKSR_NAMESPACE . 'activate'); function activate() {
    $previousVersion = get_option('kksr_ver');

    if ($previousVersion && version_compare($previousVersion, '3.0.0', '<')) {
        // We are upgrading, lets normalize the previous options.
        upgradeOptions();
        // Also normalize all the previous post ratings.
        upgradeRatings();
    }

    if (! $previousVersion) {
        // We have never used any version of this plugin.
        // Save the default options.
        saveOptions(getOptions(['kksr_strategies' => ['unique']]));
    }

    if (version_compare($previousVersion, '3.0.0', '<')) {
        // We were using a legacy version of the plugin.
        // Merge the new options.
        saveOptions(getOptions());
    }

    // Save the new version.
    saveOptions(['kksr_ver' => KKSR_VERSION]);
}
