<?php

if ( ! function_exists( 'kksr_freemius' ) ) {
    // Create a helper function for easy SDK access.
    function kksr_freemius() {
        global $kksr_freemius;

        if ( ! isset( $kksr_freemius ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $kksr_freemius = fs_dynamic_init( array(
                'id'                  => '3890',
                'slug'                => 'kk-star-ratings',
                'premium_slug'        => '',
                'type'                => 'plugin',
                'public_key'          => 'pk_e6d3c068ac8b44274990af9fc9eeb',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'kk-star-ratings',
                    'support'        => false,
                ),
            ) );
        }

        return $kksr_freemius;
    }

    // Init Freemius.
    kksr_freemius();

    // Signal that SDK was initiated.
    do_action( 'kksr_freemius_loaded' );
}
