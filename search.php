<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package cmk23
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<!-- <header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'cmk23' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header>.page-title -->

			<?php
			$posts = array_map(function($post){
				$post->thumbnail = get_the_post_thumbnail_url($post->ID);
				if(!!$post->thumbnail === false && !!$post->post_content){
					$doc = new DOMDocument();
					$doc->loadHTML($post->post_content);
					$xpath = new DOMXPath($doc);
					$src = $xpath->evaluate("string(//img/@src)");
					$post->thumbnail = $src;
				}
				$post->permalink = get_permalink($post->ID);
				return $post;
			}, $posts);
			/* Start the Loop */
			// while ( have_posts() ) :
			// 	the_post();

			// 	/**
			// 	 * Run the loop for the search to output the results.
			// 	 * If you want to overload this in a child theme then include a file
			// 	 * called content-search.php and that will be used instead.
			// 	 */
			// 	get_template_part( 'template-parts/content', 'search' );
			// endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

	<script>
	(() => {
		const posts = <?php echo json_encode($posts); ?>;
		console.log(posts);
		const searchResult = new SearchResult("#primary", posts);
	})();
	</script>

<?php
get_sidebar();
get_footer();
