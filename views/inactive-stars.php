<div class="kksr-stars-inactive">
    <?php for ($i = 1; $i <= $best; $i++) : ?>
        <div class="kksr-star" data-star="<?= $i ?>">
            <?= \Bhittani\StarRating\view('inactive-star') ?>
        </div>
    <?php endfor; ?>
</div>
