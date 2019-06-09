<label for="<?php echo $id; ?>">
    <input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>"
        <?php echo $checked ? 'checked="checked"' : ''; ?>>

    <?php echo isset($label) ? $label : ''; ?>
</label>
