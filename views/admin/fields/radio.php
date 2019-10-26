<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<label>
    <input type="radio" name="<?= $name ?>" value="<?= $value ?>"
        <?= $checked ? 'checked="checked"' : '' ?>>

    <?= $label ?>
</label>
