<?php
    if (! defined('ABSPATH')) {
        http_response_code(404);
        die();
    }
?>

<div class="wrap">
    <?php settings_errors(); ?>

    <h1>
        <?= $label; ?>
        <small style="
            color: gray;
            font-size: 80%;
            margin-left: .5rem;
            letter-spacing: -2px;
            font-family: monospace;">
            <?= $version; ?>
        </small>
    </h1>

    <!-- \Bhittani\StarRating\view('admin.social') -->

    <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab => $label) : ?>
            <a class="nav-tab <?= $tab === $active ? 'nav-tab-active' : ''; ?>"
                href="<?= admin_url('admin.php?page='.$_GET['page'].'&tab='.$tab); ?>">
                <?= $label; ?>
            </a>
        <?php endforeach; ?>
    </h2>

    <?= $content ?>
</div>
