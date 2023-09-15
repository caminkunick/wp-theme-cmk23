<?php

function cmk23_save_staff_data($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  
  if (isset($_POST['staff_data'])) {
    // replace \" with "
    $staff_data = str_replace('\\"', '"', $_POST['staff_data']);
    update_post_meta($post_id, '_staff_data', $staff_data);
    // update_post_meta($post_id, '_staff_data', sanitize_text_field($_POST['staff_data']));
  }
}

add_action('save_post', 'cmk23_save_staff_data');


function render_staff_metabox($post) {
  // Retrieve any existing data for the post, if needed
  $custom_data = get_post_meta($post->ID, '_staff_data', true);

  // Output HTML for the metabox
  ?>
  <div id="staff"></div>
  <script>
  (() => {
    const data = <?php echo $custom_data ?: "{}"; ?>;
    const staff = new MetaStaff();
    staff.render(data);
  })()
  </script>
  <?php
}

function custom_metaboxes() {
  add_meta_box(
      'metabox-staff',       // Unique ID for the metabox
      'Staff Infomation',    // Title displayed on the metabox
      'render_staff_metabox',   // Callback function to render the metabox content
      array('staff'),                     // Post type(s) to add the metabox to
      'normal',                  // Context (normal, advanced, side)
      'high'                  // Priority (default, high, low)
  );
}

add_action('add_meta_boxes', 'custom_metaboxes');