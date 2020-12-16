<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<input name="<?= esc_attr($name) ?>" value="<?= esc_attr($value) ?>"
    style="width: 15rem;">
