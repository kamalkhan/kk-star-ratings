<?php

namespace Bhittani\StarRating;

add_action('wp_enqueue_scripts', KKSR_NAMESPACE . 'styles'); function styles() {
    // global $post;
    // die(var_dump($post));
    wp_enqueue_style(
        KKSR_SLUG,
        KKSR_URI . 'css/kk-star-ratings.css',
        [],
        KKSR_VERSION
    );
}

add_action('wp_enqueue_scripts', KKSR_NAMESPACE . 'scripts'); function scripts() {
    // global $post;
    // die(var_dump($post));
    wp_enqueue_script(
        KKSR_SLUG,
        KKSR_URI . 'js/kk-star-ratings.js',
        ['jquery'],
        KKSR_VERSION,
        true
    );
}
