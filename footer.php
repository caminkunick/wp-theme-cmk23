<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cmk23
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="footer-container">
			<div class="site-info">
				<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php dynamic_sidebar( 'footer-2' ); ?>
				<?php dynamic_sidebar( 'footer-3' ); ?>
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div>
			<div class="typography-caption">
				&copy;<?php echo date("Y"); ?>
				<?php
					$organizer = get_theme_mod( 'cmk__footer_organizer', '' );
					if( $organizer ){
						echo $organizer;
					} else {
						bloginfo( 'name' );
					}
				?>,
				All Rights Reserved
			</div>
		</div><!-- .footer-container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
