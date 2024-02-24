<?php
/**
 * Class AdminLoginTest
 *
 * @package X_Core
 */

class AdminLoginTest extends WP_UnitTestCase {

  private $admin;

  public function setUp() {
    parent::setUp();
    $this->admin = new X_Core_Admin;
  }

  public function tearDown() {
    unset($this->admin);
    parent::tearDown();
  }

  // test admin sub feature

  public function test_admin_login() {
    $class = $this->admin->get_sub_features()['x_core_admin_login'];
    // key
    $this->assertNotEmpty(
      $class->get_key()
    );
    // name
    $this->assertNotEmpty(
      $class->get_name()
    );
    // status
    $this->assertTrue(
      $class->is_active()
    );

    /**
     * Run
     */

    // check filter hooks
    $this->assertSame(
      10, has_filter('login_headertext', array($class, 'x_core_login_logo_url_title'))
    );
    $this->assertSame(
      10, has_filter('login_headerurl', array($class, 'x_core_login_logo_url'))
    );

    // X_CORE_LOGIN_LOGO_URL_TITLE()

    // check that the callback function returns correct value
    $this->assertEquals(
      get_bloginfo('name'), $class->x_core_login_logo_url_title('Test')
    );

    // X_CORE_LOGIN_LOGO_URL()

    // check that the callback function returns correct value
    $this->assertEquals(
      get_site_url(), $class->x_core_login_logo_url('https://test.test')
    );
  }

}
