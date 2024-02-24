<?php
/**
 * Class Speed_Remove_Metabox
 */
class Axio_Core_Speed_Remove_Metabox extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_speed_remove_metabox');

    // var: name
    $this->set('name', 'Remove slow performing post_meta metabox');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('add_meta_boxes', array($this, 'x_core_remove_post_meta_metabox'));
  }

  /**
   * Remove slow performing post_meta metabox
   */
  public static function x_core_remove_post_meta_metabox() {
    foreach (get_post_types() as $type) {
      remove_meta_box('postcustom', $type, 'normal');
    }
  }

}
