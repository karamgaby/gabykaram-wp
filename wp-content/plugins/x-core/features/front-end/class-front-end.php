<?php
/**
 * Class Front_End
 */
class Axio_Core_Front_End extends Axio_Core_Feature {

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
      'x_core_front_end_html_fixes'                  => new Axio_Core_Front_End_Html_Fixes,
      'axio_core_front_end_uglify_attachment_permalink' => new Axio_Core_Front_End_Uglify_Attachment_Permalink,
    ));

  }

}
