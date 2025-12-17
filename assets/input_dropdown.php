<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function wptournreg_load_inputdropdown() {
	
	wp_register_script(
		'wptournreginputdropdown', // $handle
		WP_TOURNREG_DROPDOWNJS_URL, // $url
		array( 'jquery' ), // $deps
		#0, // $ver
		true // $in_footer
	);
		
	wp_register_style(
		'wptournreginputdropdown', // $handle
		WP_TOURNREG_DROPDOWNCSS_URL, // $url
		array(), // $deps
		#0, // $ver
		false // $in_footer
	);
}

/* add  scripts and styles */  
add_action( 'wp_enqueue_scripts', 'wptournreg_load_inputdropdown', 9998 );
