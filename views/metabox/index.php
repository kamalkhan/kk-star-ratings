<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<div class="components-base-control">
    <div class='components-base-control__field'>
        <label class="components-base-control__label" style="margin-top: .75rem; margin-bottom: .25rem;">
            <?php _e('Status', 'kk-star-ratings'); ?>
        </label>

        <div style="margin: 1rem 0 -.5rem 0;">
            <label class="components-base-control__label" style="margin-top: .75rem; margin-bottom: .25rem;">
                <input type="radio" name="<?php echo $statusFieldName; ?>" value="" <?php checked($status, ''); ?>>
                <?php _e('Auto', 'kk-star-ratings'); ?>
            </label>
            <label class="components-base-control__label" style="margin-top: .75rem; margin-bottom: .25rem;">
                <input type="radio" name="<?php echo $statusFieldName; ?>" value="enable" <?php checked($status, 'enable'); ?>>
                <?php _e('Enable', 'kk-star-ratings'); ?>
            </label>
            <label class="components-base-control__label" style="margin-top: .75rem; margin-bottom: .25rem;">
                <input type="radio" name="<?php echo $statusFieldName; ?>" value="disable" <?php checked($status, 'disable'); ?>>
                <?php _e('Disable', 'kk-star-ratings'); ?>
            </label>
        </div>

        <?php do_action('kksr_metabox'); ?>
    </div>
</div>
