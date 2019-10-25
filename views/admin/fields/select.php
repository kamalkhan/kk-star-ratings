<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<select name="<?= $name ?><?= (isset($multiple) && $multiple) ? '[]' : '' ?>"
    style="min-width: 15rem; padding: .5rem;"
    <?= (isset($multiple) && $multiple) ? 'multiple="multiple"' : '' ?>>
    <?php foreach ($options as $option) : ?>
        <option value="<?= $option['value'] ?>"
            <?= $option['selected'] ? 'selected="selected"' : '' ?>>
            <?= $option['label'] ?>
        </option>
    <?php endforeach; ?>
</select>
