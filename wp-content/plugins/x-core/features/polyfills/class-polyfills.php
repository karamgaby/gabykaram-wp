<?php
/**
 * Class Localization
 */
class X_Core_Polyfills extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_polyfills');

    // var: name
    $this->set('name', 'Polyfills');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_polyfills_acf'         => new X_Core_Polyfills_ACF,
      'x_core_polyfills_polylang'    => new X_Core_Polyfills_Polylang,
    ));

  }

}
