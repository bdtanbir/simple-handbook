<?php

namespace Simple_Handbook;

class Assets {
    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', [$this, 'shb_admin_enqueue_assets'] );
    }

    public function shb_admin_enqueue_assets() {
        wp_enqueue_script( 'shb-admin', SHB_URI .'admin/js/admin.js', ['jquery'], time(), true );
        wp_localize_script( 'shb-admin', 'shb_ajax_obj', array(
			'ajaxurl'         => admin_url( 'admin-ajax.php' ),
            'nonce'           => wp_create_nonce( 'shb-nonce' )
		));
    }
}