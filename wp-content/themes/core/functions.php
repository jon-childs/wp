<?php

	//==== EXTERNAL FILES ====
	include 'inc/customizer.php';

	//==== INCLUDES ====
	function core_includes(){
		wp_register_style('style-css', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
		wp_enqueue_style('style-css');
		
		wp_enqueue_script( 'script-js', 'js/scripts.js', 'jquery', 1.0, false );
	}
	add_action( 'wp_enqueue_scripts', 'core_includes' );
	
	//==== ADD FILTERS ====
	add_filter( 'get_the_exceprt', 'do_shortcode' );
	
?>