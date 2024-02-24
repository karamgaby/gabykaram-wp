<?php
/**
 * Class Dashboard
 */
class X_Core_Dashboard extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_dashboard');

    // var: name
    $this->set('name', 'Dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_dashboard_cleanup'       => new X_Core_Dashboard_Cleanup,
      'x_core_dashboard_recent_widget' => new X_Core_Dashboard_Recent_Widget,
      'x_core_dashboard_remove_panels' => new X_Core_Dashboard_Remove_Panels,
    ));

  }

}
