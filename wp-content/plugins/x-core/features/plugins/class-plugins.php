<?php
/**
 * Class Plugins
 */
class X_Core_Plugins extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_plugins');

    // var: name
    $this->set('name', 'Plugins');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_plugins_acf'                   => new X_Core_Plugins_Acf,
      'x_core_plugins_cookiebot'             => new X_Core_Plugins_Cookiebot,
      'x_core_plugins_public_post_preview'   => new X_Core_Plugins_Public_Post_Preview,
      'x_core_plugins_redirection'           => new X_Core_Plugins_Redirection,
      'x_core_plugins_seo'                   => new X_Core_Plugins_Seo,
      'x_core_plugins_yoast'                 => new X_Core_Plugins_Yoast,
    ));

  }

}
