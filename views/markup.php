<div style="display: none;"
    class="kk-star-ratings <?= $valign ? ('kksr-valign-'. esc_attr($valign)) : '' ?> <?= $align ? ('kksr-align-'. esc_attr($align)) : '' ?> <?= $disabled ? 'kksr-disabled' : '' ?>"
    data-id="<?= esc_attr($id) ?>"
    data-slug="<?= esc_attr($slug) ?>">
    <?= \Bhittani\StarRating\view('stars') ?>
    <?= \Bhittani\StarRating\view('legend') ?>
</div>
