<?php
    /*
        <?= isset($gap) ? ('style="padding-left: '.(((! is_rtl() && $i == 1 || is_rtl() && $i == $best) ? 0 : (int) $gap/2).'px; padding-right: '.(((! is_rtl() && $i == $best || is_rtl() && $i == 1) ? 0 : (int) $gap))/2).'px"') : '' ?> -->
    */
?>

<div class="kksr-stars-active" style="width: <?= esc_attr($width) ?>px;">
    <?php for ($i = 1; $i <= $best; $i++) : ?>
        <div class="kksr-star" <?= isset($gap) ? ('style="padding-'.(is_rtl() ? 'left' : 'right').': '.$gap.'px"') : '' ?>>
            <?= $__view('markup/active-star.php') ?>
        </div>
    <?php endfor; ?>
</div>
