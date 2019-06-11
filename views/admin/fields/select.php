<select name="<?php echo $name; ?><?php echo (isset($multiple) && $multiple) ? '[]' : ''; ?>"
    style="min-width: 15rem; padding: .5rem;"
    <?php echo isset($id) ? ('id="'.$id.'"') : ''; ?>
    <?php echo isset($multiple) ? ('multiple="multiple"') : ''; ?>>
    <?php foreach ($options as $option) : ?>
        <option value="<?php echo $option['value']; ?>"
            <?php echo $option['selected'] ? 'selected="selected"' : ''; ?>>
            <?php echo $option['label']; ?>
        </option>
    <?php endforeach; ?>
</select>
