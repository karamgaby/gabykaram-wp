<?php
/**
 * Class PluginsGravityformsTest
 *
 * @package X_Core
 */

class PluginsGravityformsTest extends WP_UnitTestCase {

  private $plugins;

  public function setUp() {
    parent::setUp();
    $this->plugins = new X_Core_Plugins;
  }

  public function tearDown() {
    unset($this->plugins);
    parent::tearDown();
  }

  // test plugins sub feature

  public function test_plugins_gravityforms() {
    $class = $this->plugins->get_sub_features()['x_core_plugins_gravityforms'];
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
      10, has_filter('gform_tabindex', '__return_false')
    );
    $this->assertSame(
      10, has_filter('gform_init_scripts_footer', '__return_true')
    );
  }

}
