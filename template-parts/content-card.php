<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cmk23
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		$feature = get_the_post_thumbnail_url();
		if(!$feature){
			$feature = get_theme_mod('cmk__placeholder_image');
		}
		if( $feature ){
			echo '<a class="post-thumbnail" href="' . get_post_permalink() . '" target="_blank">
				<img src="'.$feature.'" />
			</a>';
		}
	?>
	
	<div class="entry-body">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title"><a href="' . get_post_permalink() . '" target="_blank">', '</a></h1>' ); ?>
			<?php cmk23_post_meta(); ?>
		</header><!-- .entry-header -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
