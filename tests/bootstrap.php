<?php

$testDir = ltrim(getenv('WP_TEST_DIR'), '/');

if (!$testDir) {
    $testDir = __DIR__ . '/_wp_';
}

if (!file_exists($testDir . '/includes/functions.php')) {
    echo "Could not find {$testDir}/includes/functions.php. Have you run bin/install-test-suite.sh ?" . PHP_EOL;
    exit(1);
}

$pluginFile = __DIR__ . '/../' . ltrim(getenv('WP_PLUGIN_FILE'), '/');

if (!file_exists($pluginFile)) {
    $pluginFile = __DIR__ . '/../' . dirname(__DIR__ . '/../');

    if (!file_exists($pluginFile)) {
        echo "Could not find {$pluginFile} file." . PHP_EOL;
        exit(1);
    }
}

// Setup the database.
// if (file_exists($sqliteDb = $testDir . '/src/wp-content/database/.ht.sqlite')) {
//     unlink($sqliteDb);
//     touch($sqliteDb);
// }

// Get access to tests_add_filter() function.
require_once $testDir . '/includes/functions.php';

// Manually load the plugin being tested.
tests_add_filter('muplugins_loaded', function () use ($pluginFile) {
    require $pluginFile;
});

// Start up the WP testing environment.
require $testDir . '/includes/bootstrap.php';
