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
	// wp_enqueue_script('eccentrik_pdfjs', get_stylesheet_directory_uri() . '/js/pdf.js', array('jquery'), 1, true);

}

add_action('wp_enqueue_scripts', 'eccent_load_scripts');

add_filter('manage_posts_columns', 'add_thumbnail_column', 5);
 
function add_thumbnail_column($columns){
  $columns['new_post_thumb'] = __('Featured Image');
  return $columns;
}
 
add_action('manage_posts_custom_column', 'display_thumbnail_column', 5, 2);
 
function display_thumbnail_column($column_name, $post_id){
  switch($column_name){
    case 'new_post_thumb':
      $post_thumbnail_id = get_post_thumbnail_id($post_id);
      if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
        echo '<img width="180" src="' . $post_thumbnail_img[0] . '" />';
      }
      break;
  }
}

function my_acf_admin_head() {
    ?>
    <style type="text/css">

    /* css here */
	.acf-postbox .postbox-header {
		background-color: #302E4A;
	}

	.acf-field.acf-field-group {
		background-color: #F1F1F1;
	}

	.acf-postbox .postbox-header h2 {
		color: #FFF;
	}

	.acf-field-62085450b8d22 > .acf-label label, .acf-field-6212baba5e39b > .acf-label label, .acf-field-6212b41822185 > .acf-label label, .acf-field-6212c3fb7359c > .acf-label label {
		font-size: 22px;
	}

	.acf-field-6212c9077ef1a > .acf-label label, .acf-field-6212c92d7ef1b > .acf-label label, .acf-field-6212c4487359d > .acf-label label, .acf-field-6212c72d498a3 > .acf-label label, .acf-field-6212c9c36dbea > .acf-label label, .acf-field-6212ca53bfd70 > .acf-label label, .acf-field-6212cac2f4558 > .acf-label label, .acf-field-6212cfc06a3e1 > .acf-label label, .acf-field-6212d03bb6a90 > .acf-label label, .acf-field-6212d2ef16c2b > .acf-label label, .acf-field-6212d324c67e4 > .acf-label label {
		font-size: 18px;
	}

    </style>
    <?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');

function add_post_password_placeholder($output) {
    // Here you can customize the form HTML.
    $post = get_post();
    $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
    <p>' . __( 'This content is protected. Please enter the password that you were sent below:' ) . '</p>
    <p><input name="post_password" id="' . $label . '" type="password" placeholder="Your Password" size="20" /><input type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form' ) . '" /></p></form>
    ';

    return $output;
}

add_filter('the_password_form', 'add_post_password_placeholder');