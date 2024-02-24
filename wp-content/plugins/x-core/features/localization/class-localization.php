<?php
/**
 * Class Localization
 */
class X_Core_Localization extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_localization');

    // var: name
    $this->set('name', 'Localization');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_localization_string_translations' => new X_Core_Localization_String_Translations,
    ));

  }

}
