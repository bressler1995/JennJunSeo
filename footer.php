<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-footer' );
	} else {
		get_template_part( 'template-parts/footer' );
	}
}
?>

<div id="jseo_lightbox" class="jseo_lightbox">
	<div id="jseo_lightbox_overlay" class="jseo_lightbox_overlay"></div>
	<div id="jseo_lightbox_ui" class="jseo_lightbox_ui">
		<div id="jseo_lightbox_ui_top" class="jseo_lightbox_ui_top">
			<div class="jseo_lbui_col"></div>
			<div class="jseo_lbui_col">
				<button id="jseo_lbui_zoom" class="jseo_lbui_opt"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/zoom-in.svg'?>"></button>
				<button id="jseo_lbui_close" class="jseo_lbui_opt"><img src="<?php echo get_stylesheet_directory_uri() . '/svg/close.svg'?>"></button>
			</div>
		</div>
		<div class="jseo_lightbox_ui_content">
			<div id="jseo_lightbox_image" class="jseo_lightbox_image">
				<div draggable="false" id="jseo_lightbox_image_media" class="jseo_lightbox_image_media">
					<img draggable="false" id="jseo_lbimage_img" src="<?php echo get_stylesheet_directory_uri() . '/img/defaultimg.png'?>">
				</div>
				<div id="jseo_lightbox_image_text" class="jseo_lightbox_image_text">
					<h3 id="jseo_lbimage_title">Lorem Ipsum</h3>
				</div>
			</div>
			<div id="jseo_lightbox_video" class="jseo_lightbox_video">
				<div id="jseo_lightbox_video_container" class="jseo_lightbox_video_container">
					<div id="jseo_lightbox_video_media" class="jseo_lightbox_video_media">
						<div class="jseo_lbvideo_iframe_container">
							<iframe id="jseo_lbvideo_iframe" src="" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
					<div class="jseo_lightbox_video_text">
						<h3 id="jseo_lbvideo_title">Lorem Ipsum</h3>
					</div>
				</div>
			</div>
			<div id="jseo_lightbox_pdf" class="jseo_lightbox_pdf">
				<div id="jseo_lightbox_pdf_container" class="jseo_lightbox_pdf_container">
					<div id="jseo_lightbox_pdf_media" class="jseo_lightbox_pdf_media">

					    <div id="jseo_pdfreader_container" class="jseo_pdfreader_container">
							<!-- <div class="jseo_pdfreader_loader" id="loader">Loading ......</div>
							<div class="jseo_pdfreader_controls">
								<button class="pdfviewer_nav" id="prev_page">Previous Page</button>
								<button class="pdfviewer_nav" id="next_page">Next Page</button>
								<span id="current_page_num"></span>
									of
								<span id="total_page_num"></span>
									
								<input type="text" id="page_num">
								<button id="go_to_page">Go To Page</button>
							</div>
							<canvas class="pdf_canvas" id="pdf_canvas"></canvas> -->
							
						</div>

					</div>
					<div class="jseo_lightbox_pdf_text">
						<h3 id="jseo_lbpdf_title">Lorem Ipsum</h3>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php wp_footer(); ?>

</body>
</html>
