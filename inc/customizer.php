<?php
/**
 * cmk23 Theme Customizer
 *
 * @package cmk23
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cmk23_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'cmk23_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'cmk23_customize_partial_blogdescription',
			)
		);
	}

	require_once( get_template_directory() . '/inc/customize-class.php' );

	$custom = new Customizer( $wp_customize );

	$setting_panel = $custom->add_panel( "cmk__setting", "[Theme] Setting" );
	
	$main_section = $setting_panel->add_section( "cmk__setting_main", "Main" );
	$main_section->add_control_textarea("cmk__font_embed", "Font Embed");
	$main_section->add_control_text("cmk__font_h_family", "[Header] Font Family");
	$main_section->add_control_text("cmk__font_p_family", "[Paragraph] Font Family");

	$image_section = $setting_panel->add_section( "cmk__setting_image", "Image" );
	$image_section->add_control_image( "cmk__placeholder_image", "Place Holder Image" );

	$info_section = $setting_panel->add_section( "cmk__setting_info", "Infomation" );
	$info_section->add_control_text("cmk__footer_organizer", "Organizer");

	$footer_section = $setting_panel->add_section( "cmk__setting_footer", "Footer" );
	$footer_section->add_control_color( "cmk__footer_bg_color", "Background Color", "#000000" );
	$footer_section->add_control_color( "cmk__footer_text_color", "Text Color", "#FFFFFF" );
}
add_action( 'customize_register', 'cmk23_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function cmk23_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function cmk23_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cmk23_customize_preview_js() {
	wp_enqueue_script( 'cmk23-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'cmk23_customize_preview_js' );
