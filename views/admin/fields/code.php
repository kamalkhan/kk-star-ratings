<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<textarea rows="15" cols="50" name="<?= esc_attr($name) ?>"
    style="font-family: monospace; padding: .5rem;"><?= esc_textarea($value) ?></textarea>
