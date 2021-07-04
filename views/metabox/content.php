<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }
?>

<?php
    $status = $get('status_default');
?>

<div class='components-base-control__field'>
    <label class="components-base-control__label" style="margin-top: .75rem; margin-bottom: .25rem;">
        <strong><?= esc_html_x('Auto Embed', 'label', 'kk-star-ratings') ?></strong>
    </label>

    <div style="margin-top: 1rem;">
        <label class="components-base-control__label" style="margin-top: .5rem; margin-bottom: .25rem;">
            <input type="radio" name="<?= esc_attr($status[0]) ?>" value="" <?= checked($status[1], '', false) ?>>
            <?= esc_html_x('Auto', 'label', 'kk-star-ratings') ?>
        </label>
        <label class="components-base-control__label" style="margin-top: .5rem; margin-bottom: .25rem; margin-left: .5rem;">
            <input type="radio" name="<?= esc_attr($status[0]) ?>" value="enable" <?= checked($status[1], 'enable', false) ?>>
            <?= esc_html_x('Enable', 'label', 'kk-star-ratings') ?>
        </label>
        <label class="components-base-control__label" style="margin-top: .5rem; margin-bottom: .25rem; margin-left: .5rem;">
            <input type="radio" name="<?= esc_attr($status[0]) ?>" value="disable" <?= checked($status[1], 'disable', false) ?>>
            <?= esc_html_x('Disable', 'label', 'kk-star-ratings') ?>
        </label>
    </div>
</div>
