<?php
if (!defined('ABSPATH')) {
    http_response_code(404);
    die();
}
?>

<input type="text" name="<?= esc_attr($name) ?>" value="<?= esc_attr($value) ?>" class="regular-text">
