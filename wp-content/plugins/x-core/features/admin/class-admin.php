<?php
/**
 * Class Admin
 */
class X_Core_Admin extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_admin');

    // var: name
    $this->set('name', 'Admin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_admin_front_page_edit_link'  => new X_Core_Admin_Front_Page_Edit_Link,
      'x_core_admin_gallery'               => new X_Core_Admin_Gallery,
      'x_core_admin_image_link'            => new X_Core_Admin_Image_Link,
      'x_core_admin_login'                 => new X_Core_Admin_Login,
      'x_core_admin_menu_cleanup'          => new X_Core_Admin_Menu_Cleanup,
      'x_core_admin_notifications'         => new X_Core_Admin_Notifications,
      'x_core_admin_profile_cleanup'       => new X_Core_Admin_Profile_Cleanup,
      'x_core_admin_remove_customizer'     => new X_Core_Admin_Remove_Customizer,
    ));

  }

}
