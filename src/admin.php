<?php

namespace Bhittani\StarRating;

add_action('admin_menu', KKSR_NAMESPACE . 'admin'); function admin() {
    add_menu_page(
        KKSR_LABEL,
        KKSR_LABEL,
        'manage_options',
        KKSR_SLUG,
        KKSR_NAMESPACE . 'adminCallback',
        'dashicons-star-filled'
    );
} function adminCallback() {
    ob_start();
    include KKSR_PATH_VIEWS . 'admin/index.php';
    echo ob_get_clean();
}

add_action('kksr_settings_tab', KKSR_NAMESPACE . 'adminTabs'); function adminTabs() {
    $tabs = getAdminTabs();
    $active = getActiveAdminTab();

    ob_start();
    include KKSR_PATH_VIEWS . 'admin/tabs.php';
    echo ob_get_clean();
}

add_action('kksr_settings_content', KKSR_NAMESPACE . 'adminContents'); function adminContents() {
    $active = getActiveAdminTab();

    ob_start();
    include KKSR_PATH_VIEWS . 'admin/tabs/' . $active . '.php';
    echo ob_get_clean();
}
