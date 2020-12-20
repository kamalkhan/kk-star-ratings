<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<div class="wrap">
    <?php settings_errors(); ?>

    <h1>
        <?= esc_html($label); ?>
        <small style="
            color: gray;
            font-size: 80%;
            margin-left: .5rem;
            letter-spacing: -2px;
            font-family: monospace;">
            <?= esc_html($version); ?>
        </small>
    </h1>

    <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab => $label) : ?>
            <a class="nav-tab <?= $tab === $active ? 'nav-tab-active' : ''; ?>"
                href="<?= admin_url('admin.php?page='.esc_attr($_GET['page']).'&tab='. esc_attr($tab)); ?>">
                <?= esc_html($label); ?>
            </a>
        <?php endforeach; ?>
        <div style="float: left; margin-left: 10px;">
            <?= \Bhittani\StarRating\view('admin.social') ?>
        </div>
    </h2>

    <?= $content ?>
</div>
