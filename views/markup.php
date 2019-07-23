<div data-id="<?php echo $id; ?>" data-score="<?php echo $score; ?>" data-count="<?php echo $count; ?>"
    style="display:none;"
    class="kk-star-ratings <?php echo (isset($disabled) && $disabled) ? 'kksr-disable' : ''; ?> kksr-<?php echo isset($placement) ? $placement : 'top'; ?> kksr-<?php echo isset($alignment) ? $alignment : 'left'; ?><?php echo (isset($isRtl) && $isRtl) ? ' kksr-rtl' : ''; ?>">
    <?php
        ob_start();
        include KKSR_PATH_VIEWS.'legend.php';
        echo apply_filters('kksr_legend', ob_get_clean(), $score, $count);
    ?>
    <div class="kksr-stars">
        <div class="kksr-inactive-stars">
            <?php
                ob_start();
                $active = false;
                include KKSR_PATH_VIEWS.'stars.php';
                echo apply_filters('kksr_stars', apply_filters('kksr_stars_inactive', ob_get_clean(), $size, $stars), $size, $stars);
            ?>
        </div>
        <div class="kksr-active-stars" style="width: <?php echo apply_filters('kksr_width', $width); ?>px;">
            <?php
                ob_start();
                $active = true;
                include KKSR_PATH_VIEWS.'stars.php';
                echo apply_filters('kksr_stars', apply_filters('kksr_stars_active', ob_get_clean(), $size, $stars), $size, $stars);
            ?>
        </div>
    </div>
</div>
