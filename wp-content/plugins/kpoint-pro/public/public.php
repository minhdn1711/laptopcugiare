<?php
add_action( 'wp_enqueue_scripts', 'kpoint_public_enqueue_scripts' );

function kpoint_public_enqueue_scripts() {
	wp_enqueue_style(
		'kpoint-style', 
		KPOINT_PLUGIN_URL . 'public/css/style.css',
		array(), KPOINT_VERSION
	);

	
    wp_enqueue_script(
        'kpoint-script',
        KPOINT_PLUGIN_URL . 'public/js/scripts.js',
        array('jquery'),
        KPOINT_VERSION,
        true
    );
    
    
    wp_register_style( 'dropzone_css', KPOINT_PLUGIN_URL . 'public/css/dropzone.min.css', array(), KPOINT_VERSION);
    wp_register_style( 'basic_css', KPOINT_PLUGIN_URL. 'public/css/basic.min.css', array(), KPOINT_VERSION);
    wp_register_style( 'popup_iframe', KPOINT_PLUGIN_URL. 'public/css/jquery.modalLink-1.0.0.css', array(), KPOINT_VERSION);

    wp_register_script( 'dropzone', KPOINT_PLUGIN_URL. 'public/js/dropzone.min.js', array('jquery'), KPOINT_VERSION, true);
    wp_register_script( 'kp_upload_bill', KPOINT_PLUGIN_URL . 'public/js/upload.js', array('jquery'), KPOINT_VERSION, true);
    wp_register_script( 'popup_iframe', KPOINT_PLUGIN_URL . 'public/js/jquery.modalLink-1.0.0.js', array('jquery'), KPOINT_VERSION, true);

   
    //wp_localize_script('loigiai-script', 'loigiai_object', 
    //	array('all_lop' => $all_lop, 'lop_mon' => $all_lop_mon, 'mon_sach' => $all_mon_sach));
}