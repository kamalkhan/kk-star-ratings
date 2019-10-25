<div style="display: none;"
    class="kk-star-ratings <?= $valign ? ("kksr-valign-{$valign}") : '' ?> <?= $align ? ("kksr-align-{$align}") : '' ?> <?= $disabled ? 'kksr-disabled' : '' ?>"
    data-id="<?= $id ?>"
    data-slug="<?= $slug ?>">
    <?= \Bhittani\StarRating\view('stars') ?>
    <?= \Bhittani\StarRating\view('legend') ?>
</div>
