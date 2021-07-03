<div class="kksr-stars-active" style="width: <?= esc_attr($width) ?>px;">
    <?php for ($i = 1; $i <= $best; $i++) : ?>
        <div class="kksr-star" <?= isset($gap) ? ('style="padding-'.(is_rtl() ? 'left' : 'right').': '.esc_attr($gap).'px"') : '' ?>>
            <?= $__view('markup/active-star.php') ?>
        </div>
    <?php endfor; ?>
</div>
