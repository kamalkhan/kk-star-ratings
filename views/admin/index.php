<div class="wrap">
    <h1>
        <?php echo KKSR_LABEL; ?>
        <small style="margin-left: .5rem; font-size: 80%; font-family: monospace; letter-spacing: -2px; color: gray;">
            <?php echo KKSR_VERSION; ?>
        </small>
    </h1>

    <h2 class="nav-tab-wrapper">
        <?php do_action( 'kksr_settings_tab' ); ?>
    </h2>

    <?php do_action( 'kksr_settings_content' ); ?>
</div>
