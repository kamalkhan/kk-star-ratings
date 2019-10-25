<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<input name="<?= $name ?>" value="<?= $value ?>"
    style="width: 15rem;">
