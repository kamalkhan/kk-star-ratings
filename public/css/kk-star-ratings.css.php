<?php if ($gap !== false) : ?>
    .kk-star-ratings .kksr-stars .kksr-star {
        margin-right: <?= $gap ?>px;
    }
    [dir="rtl"] .kk-star-ratings .kksr-stars .kksr-star {
        margin-left: <?= $gap ?>px;
        margin-right: 0;
    }
<?php endif; ?>

<?php if ($stars['inactive']) : ?>
    .kk-star-ratings .kksr-stars .kksr-star .kksr-icon,
    .kk-star-ratings:not(.kksr-disabled) .kksr-stars .kksr-star:hover ~ .kksr-star .kksr-icon {
        background-image: url("<?= $stars['inactive'] ?>");
    }
<?php endif; ?>

<?php if ($stars['active']) : ?>
    .kk-star-ratings .kksr-stars .kksr-stars-active .kksr-star .kksr-icon {
        background-image: url("<?= $stars['active'] ?>");
    }
<?php endif; ?>

<?php if ($stars['selected']) : ?>
    .kk-star-ratings.kksr-disabled .kksr-stars .kksr-stars-active .kksr-star .kksr-icon,
    .kk-star-ratings:not(.kksr-disabled) .kksr-stars:hover .kksr-star .kksr-icon {
        background-image: url("<?= $stars['selected'] ?>");
    }
<?php endif; ?>