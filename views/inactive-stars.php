<div class="kksr-stars-inactive">
    <?php for ($i = 1; $i <= $best; $i++) : ?>
        <div class="kksr-star" data-star="<?= esc_attr($i) ?>">
            <?= \Bhittani\StarRating\view('inactive-star') ?>
        </div>
    <?php endfor; ?>
</div>
