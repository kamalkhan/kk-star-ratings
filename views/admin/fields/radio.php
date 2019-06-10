<label>
    <input type="radio" name="<?php echo $name; ?>" value="<?php echo $value; ?>"
        <?php echo isset($id) ? ('id="'.$id.'"') : ''; ?>
        <?php echo $checked ? 'checked="checked"' : ''; ?>>

    <?php echo isset($label) ? $label : ''; ?>
</label>
