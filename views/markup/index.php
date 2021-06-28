<div class="kk-star-ratings
    <?= $valign ? (' kksr-valign-'. esc_attr($valign)) : '' ?>
    <?= $align ? (' kksr-align-'. esc_attr($align)) : '' ?>
    <?= $readonly ? ' kksr-disabled' : '' ?>"
    data-payload="<?= esc_attr(json_encode(array_map('esc_attr', $__payload))) ?>">
    <?= $__view('markup/stars.php') ?>
    <?= $__view('markup/legend.php') ?>
</div>
