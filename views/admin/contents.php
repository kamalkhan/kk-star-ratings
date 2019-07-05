<form action="options.php?tab=<?php echo $active; ?>" method="POST" style="margin: 2rem;">
    <?php settings_fields(KKSR_SLUG); ?>
    <?php do_settings_sections(KKSR_SLUG); ?>
    <?php submit_button(); ?>
</form>
