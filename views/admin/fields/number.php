<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<input type="number" name="<?= esc_attr($name) ?>" value="<?= esc_attr($value) ?>"
    <?= isset($min) ? ('min="'. esc_attr($min).'"') : '' ?>
    <?= isset($max) ? ('max="'. esc_attr($max).'"') : '' ?>
    <?= isset($step) ? ('step="'. esc_attr($step).'"') : '' ?>
    style="width: 5rem; padding-right: 0;">
