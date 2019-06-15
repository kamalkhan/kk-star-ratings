<div data-id="<?php echo $id; ?>"
    class="kk-star-ratings kksr-<?php echo isset($placement) ? $placement : 'top'; ?> kksr-<?php echo isset($alignment) ? $alignment : 'left'; ?><?php echo (isset($isRtl) && $isRtl) ? ' kksr-rtl' : ''; ?>">
    <div class="kksr-stars">
        <div class="kksr-inactive-stars">
            <?php echo $starsMarkup; ?>
        </div>
        <div class="kksr-active-stars" style="width: <?php echo $width; ?>px;">
            <?php echo $starsMarkup; ?>
        </div>
    </div>
    <div class="kksr-legend" style="<?php echo $count ? '' : 'display: none; ' ?>line-height: <?php echo $size; ?>px; font-size: <?php echo $size/1.5; ?>px">
        <span class="kksr-legend-score"><?php echo $score; ?></span>
        <span class="kksr-legend-meta"><?php echo $count; ?></span>
    </div>
</div>
