<div data-id="<?php echo $id; ?>" class="kk-star-ratings<?php echo $isRtl ? ' kksr-rtl' : ''; ?>">
    <div class="kksr-stars">
        <?php echo $starsMarkup; ?>
        <div class="kksr-active-stars" style="width: <?php echo $width; ?>px;">
            <?php echo $starsMarkup; ?>
        </div>
    </div>
    <div class="kksr-legend" style="<?php echo $count ? '' : 'display: none; ' ?>line-height: <?php echo $size; ?>px; font-size: <?php echo $size/1.5; ?>px">
        <span class="kksr-legend-score"><?php echo $score; ?></span>
        <span class="kksr-legend-meta"><?php echo $count; ?></span>
    </div>
</div>
