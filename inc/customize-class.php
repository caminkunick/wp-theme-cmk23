<?php
class CustomizerSection {
  public function __construct( $wp_customize, $parent, $slug, $title, $priority ){
    $this->slug = $slug;
    $this->wp_customize = $wp_customize;

    $this->wp_customize->add_section( $slug , array(
      'title' => esc_html__( $title, 'cmk23' ),
      'priority' => $priority,
      'panel' => $parent,
    ));
  }

  public function add_control_text( $slug, $title, $default = "" ){
    $this->wp_customize->add_setting( $slug, array(
      'default' => $default
    ));
    $this->wp_customize->add_control( $slug, array(
      'label'   => esc_html__( $title, 'cmk23' ),
      'section' => $this->slug,
      'type'    => 'text',
    ));
  }

  public function add_control_textarea( $slug, $title, $default = "" ){
    $this->wp_customize->add_setting( $slug, array(
      'default' => $default
    ));
    $this->wp_customize->add_control( $slug, array(
      'label'   => esc_html__( $title, 'cmk23' ),
      'section' => $this->slug,
      'type'    => 'textarea',
    ));
  }

  public function add_control_color( $slug, $title, $default = "#5BBFDD" ){
    $this->wp_customize->add_setting( $slug, array(
      'default' => $default
    ));
    $this->wp_customize->add_control( $slug, array(
      'label'   => esc_html__( $title, 'cmk23' ),
      'section' => $this->slug,
      'type'    => 'color',
    ));
  }

  public function add_control_number( $slug, $title, $default = "1" ){
    $this->wp_customize->add_setting( $slug, array(
      'default' => $default
    ));
    $this->wp_customize->add_control( $slug, array(
      'label'   => esc_html__( $title, 'cmk23' ),
      'section' => $this->slug,
      'type'    => 'number',
    ));
  }
}

class CustomizerPanel {
  public function __construct( $wp_customize, $slug, $title, $priority ){
    $this->slug = $slug;
    $this->wp_customize = $wp_customize;

    $this->wp_customize->add_panel( $slug, array(
      'title' => esc_html__( $title, 'cmk23' ),
      'priority' => $priority,
    ));
  }
  //SECTION - SECTION
  public function add_section( $slug, $title, $priority = 10 ){
    return new CustomizerSection( $this->wp_customize, $this->slug, $slug, $title, $priority );
  }
  //!SECTION
}

class Customizer {
  public function __construct( $wp_customize ){
    $this->wp_customize = $wp_customize;
  }
  //SECTION - PANEL
  public function add_panel( $slug, $title, $priority = 10 ){
    return new CustomizerPanel( $this->wp_customize, $slug, $title, $priority );
  }
  //!SECTION
}
