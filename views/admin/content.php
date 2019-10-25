<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<form method="POST" action="options.php?tab=<?= $active; ?>" style="margin: 2rem;">
    <?php submit_button(); ?>
    <?php settings_fields($slug); ?>
    <?php do_settings_sections($slug); ?>
    <?php submit_button(); ?>
</form>
