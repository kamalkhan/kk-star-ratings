<?php foreach ($tabs as $tab => $label) : ?>
    <a class="nav-tab <?php echo $tab == $active ? 'nav-tab-active' : ''; ?>"
        href="<?php echo admin_url('admin.php?page=' . KKSR_SLUG . '&tab=' . $tab); ?>">
        <?php echo $label; ?>
    </a>
<?php endforeach; ?>
