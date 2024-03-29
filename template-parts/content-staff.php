<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cmk23
 */

$staff_data = get_post_meta(get_the_ID(), '_staff_data', true);
$staff_data = json_decode($staff_data, true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-body">
		<?php cmk23_post_thumbnail(); ?>
		
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php
			if(isset($staff_data["name"]) && is_array($staff_data["name"])){
				foreach($staff_data["name"] as $name){
					echo "<h1 class=\"entry-title\">" . $name . "</h2>";
				}
			}
			?>
		</header><!-- .entry-header -->


		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cmk23' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'cmk23' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					),
					'<span class="edit-link">',
					'</span>'
				);
				?>
			</footer><!-- .entry-footer -->
		</div><!-- .entry-body -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
