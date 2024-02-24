<?php
/**
 * Class Security
 */
class X_Core_Security extends X_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'x_core_security');

    // var: name
    $this->set('name', 'Security');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'x_core_security_disable_admin_email_check' => new X_Core_Security_Disable_Admin_Email_Check,
      'x_core_security_disable_file_edit'         => new X_Core_Security_Disable_File_Edit,
      'x_core_security_disable_unfiltered_html'   => new X_Core_Security_Disable_Unfiltered_Html,
      'x_core_security_head_cleanup'              => new X_Core_Security_Head_Cleanup,
      'x_core_security_hide_users'                => new X_Core_Security_Hide_Users,
      'x_core_security_remove_comment_moderation' => new X_Core_Security_Remove_Comment_Moderation,
      'x_core_security_remove_commenting'         => new X_Core_Security_Remove_Commenting,
    ));

  }

}
