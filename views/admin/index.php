<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<div class="wrap">
    <?php settings_errors(); ?>

    <h1>
        <?php echo $label; ?>
        <small style="margin-left: .5rem; font-size: 80%; font-family: monospace; letter-spacing: -2px; color: gray;">
            <?php echo $version; ?>
        </small>
    </h1>

    <?php
        ob_start();
        include KKSR_PATH_VIEWS.'admin/social.php';
        echo ob_get_clean();
    ?>

    <h2 class="nav-tab-wrapper">
        <?php do_action('kksr_setting_tabs'); ?>
    </h2>

    <?php do_action('kksr_setting_contents'); ?>
</div>
