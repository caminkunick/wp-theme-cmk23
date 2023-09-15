<?php

class cmk23_staff {
  public function __construct($id){
    $this->id = $id;

  }
  
  public function render($position){
    $post = $this->query_from_id($this->id);
    if($post){
      $thumbnail = get_the_post_thumbnail_url($this->id, 'full');
      $staff_data = json_decode(get_post_meta($this->id, '_staff_data', true) ?: "{}", true);
  
      $div = '<a class="staff-shortcode-item" href="'. get_permalink( $this->id ) .'" target="_blank">
        <div class="staff-item-thumbail">
          <img src="' . $thumbnail . '" />
        </div>
        <div class="staff-item-content">
          <h4>' . $post->post_title . '</h4>';
      
      if($position === "true" && isset($staff_data["position"])){
        $div .= '<p>' . $staff_data["position"] . '</p>';
      }
      
      $div .= '</div>
      </a>';
  
      return $div;
    }
    return '';
  }

  private function query_from_id($id){
    $query = new WP_Query(array(
      'post_type' => 'staff',
      'post_status' => 'publish',
      'p' => $id
    ));

    if($query->have_posts()){
      // get first post
      return $query->posts[0];
    }
    return null;
  }
}

function cmk23_staff_shortcut( $atts ) {
	$atts = shortcode_atts( array(
		'ids' => '',
		'names' => '',
    'position' => 'false'
	), $atts, 'staff' );

	$ids = array_map(
    "trim",
    array_filter(
      explode( ',', $atts['ids'] ),
      function($id){ return !!$id; }
    )
  );
  $names = array_map(
    "trim",
    array_filter(
      explode( ',', $atts['names'] ),
      function($name){ return !!$name; }
    )
  );

  $staff_component = '<div class="staff-shortcode">';

  if(count($ids) > 0){
    foreach($ids as $id){
      $staff = new cmk23_staff($id);
      $staff_component .= $staff->render( $atts['position'] );
    }
  }

  if(count($names) > 0){
    foreach($names as $name){
      $staff_component .= '<div class="staff-shortcode-item">
      <div class="staff-item-thumbail">
        <i class="far fa-user"></i>
      </div>
      <div class="staff-item-content">
        <h4>' . $name . '</h4>
      </div>
      </div>';
    }
  }

  $staff_component .= '</div>';
	
	return $staff_component;
}
add_shortcode( 'staff', 'cmk23_staff_shortcut' );