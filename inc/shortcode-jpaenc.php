<?php

function cmk23_shortcode_jpaenc( $atts ){
  $atts = shortcode_atts( array(
    "ids" => "",
		"action" => "/",
    "target" => "_blank"
	), $atts, 'jpaenc' );

  $html = '<div class="jpaenc">
    <form action="' . $atts["action"] . '" target="' . $atts["target"] . '" method="get">
      <h3><strong>สารานุกรมวัฒนธรรมญี่ปุ่น</strong><br />日本文化百科事典</h3>
      <div class="search-box">
        <input type="text" name="s" placeholder="ค้นหา" value="' . get_search_query() . '" />
        <button><i class="fa fa-search"></i></button>
      </div>
    </form>
  </div>';

  if($atts["ids"]){
    $categories = get_categories( array(
      'orderby' => 'name',
      'order'   => 'ASC',
      'parent'  => $atts["ids"]
    ));
    
    $html .= '<div><pre>' . print_r( $categories, true ) . '</pre></div>';
  }

  return $html;
}
add_shortcode( 'jpaenc', 'cmk23_shortcode_jpaenc' );