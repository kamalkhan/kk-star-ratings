<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<input type="number" name="<?= $name ?>" value="<?= $value ?>"
    <?= isset($min) ? "min=\"{$min}\"" : '' ?>
    <?= isset($max) ? "max=\"{$max}\"" : '' ?>
    <?= isset($step) ? "step=\"{$step}\"" : '' ?>
    style="width: 5rem;">
