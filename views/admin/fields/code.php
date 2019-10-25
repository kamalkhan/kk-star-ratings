<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<textarea rows="15" cols="50" name="<?= $name ?>"
    style="font-family: monospace; padding: .5rem;"><?= $value ?></textarea>
