<div class="wrap">
    <?php settings_errors(); ?>

    <h1>
        <?php echo $label; ?>
        <small style="margin-left: .5rem; font-size: 80%; font-family: monospace; letter-spacing: -2px; color: gray;">
            <?php echo $version; ?>
        </small>
    </h1>

    <h2 class="nav-tab-wrapper">
        <?php do_action('kksr_setting_tabs'); ?>
    </h2>

    <?php do_action('kksr_setting_contents'); ?>
</div>
