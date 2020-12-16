<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<label>
    <input type="checkbox" name="<?= esc_attr($name) ?>" value="<?= esc_attr($value) ?>"
        <?= $checked ? 'checked="checked"' : '' ?>>
    <?= esc_html($label) ?>
</label>
