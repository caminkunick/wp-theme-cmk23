<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cmk23
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="ญี่ปุ่น, จุฬา, Japanese, Chula">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<style>
		<?php
			//ANCHOR - Embed Fonts
			$font_embed = get_theme_mod("cmk__font_embed", "");
			echo !!$font_embed ? $font_embed : "";
		?>
		:root {
			--font-header-family: <?php echo get_theme_mod("cmk__font_h_family", '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif'); ?>;
			--font-paragraph-family: <?php echo get_theme_mod("cmk__font_p_family", '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif'); ?>;
			--footer-bg-color: <?php echo get_theme_mod("cmk__footer_bg_color", '#000000'); ?>;
			--footer-text-color: <?php echo get_theme_mod("cmk__footer_text_color", '#ffffff'); ?>;
		}
	</style>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'cmk23' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			echo '<div class="site-title-desc">';
			?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			$cmk23_description = get_bloginfo( 'description', 'display' );
			if ( $cmk23_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $cmk23_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php
				endif;
				echo '</div>';
			?>
		</div><!-- .site-branding -->
		<div class="flex-1"></div>
		<nav id="site-navigation" class="main-navigation">
			<div class="menu-toggle"></div>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php get_template_part('template-parts/navigate','button',array(
			"class" => "menu-toggle edge-end",
			"th" => "เมนู",
			"en" => "Menu",
			"icon" => "fa-regular fa-chevron-down"
		)); ?>
	</header><!-- #masthead -->
