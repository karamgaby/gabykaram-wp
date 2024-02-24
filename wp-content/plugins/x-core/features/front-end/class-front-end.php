<?php
/**
 * Class Front_End
 */
class X_Core_Front_End extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_front_end');

    // var: name
    $this->set('name', 'Front End');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_front_end_html_fixes'                  => new X_Core_Front_End_Html_Fixes,
    ));

  }

}
