<?php
    ob_start();
    include KKSR_PATH_VIEWS.'star.php';
    $star = apply_filters('kksr_star', apply_filters('kksr_star_'.($active ? 'active' : 'inactive'), ob_get_clean(), $size), $size);

    for ($i = 1; $i <= $stars; $i++) :
?>
    <div data-star="<?php echo $i; ?>" class="kksr-star">
        <?php echo $star; ?>
    </div>
<?php endfor; ?>
