<?php
    if (! defined('KK_STAR_RATINGS')) {
        http_response_code(404);
        exit();
    }
?>

<div class="wrap">
    <?php if ($globalErrors) : foreach ($globalErrors as $error) : ?>
        <div class="notice notice-error">
            <p><?= esc_html($error) ?></p>
        </div>
    <?php endforeach; endif; ?>

    <?php if ($processed) : ?>
        <div class="notice notice-success is-dismissible">
            <p><?= esc_html(__('Options saved.', 'kk-star-ratings')) ?></p>
        </div>
    <?php endif; ?>

    <h1>
        <?= esc_html($label) ?>
        <small style="
            color: gray;
            margin-left: .5rem;
            letter-spacing: -2px;
            font-family: monospace;">
            <?= esc_html($version) ?>
        </small>
        <small>
            by
            <a href="<?= esc_attr($authorUrl) ?>" target="_blank">
                <?= esc_html($author) ?>
            </a>
        </small>
    </h1>

    <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab) : ?>
            <a class="nav-tab <?= $tab === $active ? 'nav-tab-active' : '' ?>"
                href="<?= admin_url('admin.php?page='.esc_attr($_GET['page']).'&tab='. urlencode(esc_attr($tab))) ?>">
                <?= esc_html($tab) ?>
            </a>
        <?php endforeach; ?>
        <div style="float: left; margin-left: 10px;">
            <?= $__view('admin/social.php') ?>
        </div>
    </h2>

    <form method="POST" style="margin: 2rem;">
        <?php wp_nonce_field($nonce) ?>
        <?= $content ?>
        <?php submit_button(); ?>
    </form>
</div>
