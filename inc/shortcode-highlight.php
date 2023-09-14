<?php

class cmk_highlight extends cmk23_slideshow {
  public function __construct( $atts ){
    parent::__construct( $atts );
  }

  public function render( $containerId,  $query ){
    $highlight = '<div class="px-2">
    <div
      id="'. $containerId .'"
      class="'. $this->atts["class"] .' highlight-container highlight-column-'. $this->atts["column"] .' highlight-spacing-'. $this->atts["gap"] .'"
      style="--primary-color: '. $this->atts["primary"] .';"
    >';
    while( $query->have_posts() ){
      $query->the_post();
      $secTitle = get_post_meta( get_the_ID(), 'phrain_secondaryTitle', true );
      $link = get_post_meta( get_the_ID(), 'phrain_author', true );
      $highlight .= '<div class="highlight-item">
        <div class="highlight-image">
          <a href="'. $link .'" target="_blank">'.$this->thumbnail().'</a>
        </div>
        <div class="highlight-content">
          <h2>
            <a href="'. $link .'" target="_blank">
              <span class="primary">'.get_the_title().'</span>
              <span class="secondary">'. $secTitle .'</span>
            </a>
          </h2>
          <p>'.get_the_excerpt().'</p>
        </div>
      </div>';
    }
    $highlight .= '</div>
    </div>';

    return $highlight;
  }
}

function cmk23_shortcode_highlight( $atts ){
  $atts = shortcode_atts( array(
    "class" => "",
    "ids" => "",
    "amount" => "-1",
    "column" => "1",
    "gap" => "1",
    "primary" => "#333",
  ), $atts, 'highlight' );

  $highlight = new cmk_highlight( $atts );

  $containerId = cmk_highlight::randId();
  $query = $highlight->query();

  return $highlight->render($containerId, $query);
}
add_shortcode( 'highlight', 'cmk23_shortcode_highlight' );