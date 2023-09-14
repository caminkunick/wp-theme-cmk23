<?php

class cmk23_slideshow {
  public $atts;

  public function __construct( $atts ){
    $this->atts = $atts;
  }

  public function render($containerId, $query){
    $slideshow = '<div id="'. $containerId .'" class="slideshow swiper-container">
      <div class="swiper-wrapper">';
    while ( $query->have_posts() ) : $query->the_post();
      $categories = get_the_category();

      $cats = array();
      foreach($categories as $category){
        $categoryName = $category->name;
        $categorySlug = $category->slug;
        $cats[] = '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $categoryName ) ) . '" class="category-' . $categorySlug . '" target="_blank">' . $categoryName . '</a>';
      }

      $slideshow .= '<div class="swiper-slide">
        ' . $this->thumbnail() . '
        <div class="cover-meta">
          <div class="categories">' . implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $cats) . '</div>
          <h3>' . get_the_title() . '</h3>
          <div class="actions">
            <a class="btn-readmore" href="' . get_permalink() . '" target="_blank">
              <div class="th">อ่านต่อ</div>
              <div class="en">READ MORE</div>
            </a>
          </div>
        </div>
      </div>';
    endwhile;

    $slideshow .= '
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
    <script>
      new Swiper("#'. $containerId .'", {
        speed: 600,
        loop: true,
        centeredSlides: true,
        grabCursor: true,
        lazy: true,
        pagination: { el: ".swiper-pagination", dynamicBullets: true },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        scrollbar: { el: ".swiper-scrollbar" },
      });
    </script>';

    wp_reset_postdata();

    return $slideshow;
  }

  public function thumbnail(){
    if ( has_post_thumbnail() ) {
      $thumbnail = get_the_post_thumbnail( get_the_ID(), 'full' );
    } else {
      $content = apply_filters( 'the_content', get_the_content() );
      preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
      if ( isset( $matches[1][0] ) ) {
        $thumbnail = '<img src="' . $matches[1][0] . '" alt="' . get_the_title() . '" />';
      } else {
        $thumbnail = '<img src="' . get_template_directory_uri() . '/assets/images/no-image.jpg" alt="' . get_the_title() . '" />';
      }
    }
    return $thumbnail;
  }

  public function query(){
    $args = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 5,
      'orderby' => 'date',
      'order' => 'DESC',
      'category__in' => $this->atts['ids'],
      'posts_per_page' => $this->atts['amount']
    );

    $query = new WP_Query( $args );

    return $query;
  }

  static function randId(){
    return substr(md5(microtime()),rand(0,26),5);
  }
}

function cmk23_slideshow_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'ids' => '',
		'amount' => '-1'
	), $atts, 'slideshow' );

	$ids = explode( ',', $atts['ids'] );

  $slide = new cmk23_slideshow( $atts );
	$query = $slide->query();

  $containerId = cmk23_slideshow::randId();

  $slideshow = $slide->render($containerId, $query);
	
	return $slideshow;
}
add_shortcode( 'slideshow', 'cmk23_slideshow_shortcode' );