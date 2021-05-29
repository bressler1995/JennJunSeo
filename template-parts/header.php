<?php
/**
 * The template for displaying header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
?>
	
	<header class="eccent_navigation" role="banner">
		<div class="eccent_navigation_inner">
			<div class="eccent_logo_holder">
				<?php
					$custom_logo_id = get_theme_mod('custom_logo');
					$image = wp_get_attachment_image_src( $custom_logo_id , 'large' );
					echo '<a href="' . get_site_url() . '" class="eccent_logo_link"><img src="' . $image[0] . '" class="eccent_logo"></a>';
				?>
			</div>
			<div class="eccent_menu_holder">
				<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
				<?php wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'eccent_menu_desktop', 'menu_class' => 'eccent_menu_desktop')); ?>
				<?php endif; ?>
				<button type="button" class="eccent_toggle" id="eccent_toggle"><img class="eccent_toggle_img" src="<?php echo get_stylesheet_directory_uri() . '/svg/menu.svg' ?>"></button>
			    <div class="eccent_mobile_holder eccent_mobile_holder_hide" id="eccent_mobile_holder">
					<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
					<?php wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'eccent_menu_mobile', 'menu_class' => 'eccent_menu_mobile')); ?>
					<?php endif; ?>
					<div class="eccent_mobile_button_holder"><button type="button" class="eccent_mobile_close" id="eccent_mobile_close"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/close.svg'?>" class="eccent_mobile_close_icon"></button></div>
				</div>
			</div>
		</div>
	</header>