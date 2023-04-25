<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package cmk23
 */

function filter_the_content_in_the_main_loop($content) {
	if ( is_singular() && in_the_loop() && is_main_query() ) {
		$query = new WP_Query(array(
			'post_type' => 'staff',
			'posts_per_page' => -1
		));
		$posts = $query->post;

		preg_match_all("|<div class=\"staff-query\">(.*)</[^>]+>|U", $content, $out, PREG_PATTERN_ORDER);

		foreach($out[0] as $index => $row){
			$html = '';
			$show_position = false;

			$ids = array_map(function($id){
				return trim($id);
			}, explode(",", $out[1][$index]));

			if(in_array('true', $ids)){
				$show_position = true;
				$ids = array_filter($ids, function($id){
					return $id !== "true";
				});
			}

			foreach($ids as $id){
				$post = get_post($id);
				if($post){
					$title = explode( "<br />", $post->post_title );
					$position = get_post_meta( $id, 'position', true );
					$thumbnail = get_the_post_thumbnail_url( $post );
					$html = $html . '<a class="staff-list-item" href="'.get_post_permalink( $post ).'" target="_blank">
						<div class="list-item-image">
							'.( !!$thumbnail ? '<img src="'.$thumbnail.'" />' : '<i class="fa-regular fa-user"></i>' ).'
						</div>
						<div class="list-item-text">
							<div class="primary">'.$title[0].'</div>
							'.( (!!$position && $show_position) ? '<div class="secondary">'.$position.'</div>' : "" ).'
						</div>
					</a>';
				} else {
					$html = $html . '<div class="staff-list-item">
						<div class="list-item-image">
							<i class="fa-regular fa-user"></i>
						</div>
						<div class="list-item-text">
							<div class="primary">'.$id.'</div>
						</div>
					</div>';
				}
			}
			$content = str_replace($row, '<div class="staff-list">'.$html.'</div>', $content);
		}

		return $content;
	}
	return $content;
}
add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 1 );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php cmk23_post_thumbnail(); ?>
	<div class="entry-body">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
		<?php endif; ?>
	</div><!-- .entry-body -->
</article><!-- #post-<?php the_ID(); ?> -->
