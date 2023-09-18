<?php
add_action('init', function() {
  $jspath = get_template_directory() . "/plugins/fa/fontawesome.js";

  wp_register_script(
    'cmk23-fontawesome-block',
    get_template_directory_uri() . "/plugins/fa/fontawesome.js?v=" . filemtime($jspath),
    array('wp-blocks', 'wp-editor')
  );

  register_block_type(
    'cmk23-fontawesome-block/cmk23-fontawesome-block',
    array(
      'editor_script' => 'cmk23-fontawesome-block',
    )
  );
});