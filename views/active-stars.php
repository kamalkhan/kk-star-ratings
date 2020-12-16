<div class="kksr-stars-active" style="width: <?= esc_attr($width) ?>px;">
    <?php for ($i = 1; $i <= $best; $i++) : ?>
        <div class="kksr-star">
            <?= \Bhittani\StarRating\view('active-star') ?>
        </div>
    <?php endfor; ?>
</div>
