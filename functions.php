<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */

include('custom-shortcodes.php');

function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}

add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

function eccent_load_scripts() {
    wp_register_script('eccentrik_ui', get_stylesheet_directory_uri() . '/js/uicontrol.js', array('jquery'), 1, true);
    wp_enqueue_script('eccentrik_ui');
	wp_localize_script( 'eccentrik_ui', 'themeDirURI', get_stylesheet_directory_uri() ) ;

}

add_action('wp_enqueue_scripts', 'eccent_load_scripts');
