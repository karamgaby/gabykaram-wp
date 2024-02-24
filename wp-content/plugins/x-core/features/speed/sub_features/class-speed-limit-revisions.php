<?php
/**
 * Class Speed_Limit_Revisions
 */
class X_Core_Speed_Limit_Revisions extends X_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_speed_limit_revisions');

    // var: name
    $this->set('name', 'Limit revision number');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_filter('wp_revisions_to_keep', array($this, 'x_core_limit_revision_number'), 10, 2);
  }

  /**
   * Limit revision number
   *
   * @param int $number current revision limit
   * @param int $post_id the ID of current post
   *
   * @return int revision limit
   */
  public static function x_core_limit_revision_number($number, $post_id) {
    return 10;
  }

}
