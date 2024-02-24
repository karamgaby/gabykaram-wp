<?php
/**
 * Class Speed
 */
class X_Core_Speed extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_speed');

    // var: name
    $this->set('name', 'Speed');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_speed_limit_revisions'  => new X_Core_Speed_Limit_Revisions,
      'x_core_speed_move_jquery'      => new X_Core_Speed_Move_Jquery,
      'x_core_speed_remove_emojis'    => new X_Core_Speed_Remove_Emojis,
      'x_core_speed_remove_metabox'   => new X_Core_Speed_Remove_Metabox,
    ));

  }

}
