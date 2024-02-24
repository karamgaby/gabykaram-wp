<?php
/**
 * Class PluginsCookiebotTest
 *
 * @package X_Core
 */

class PluginsCookiebotTest extends WP_UnitTestCase {

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

  public function test_plugins_acf() {
    $class = $this->plugins->get_sub_features()['x_core_plugins_cookiebot'];
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

    // check filter hook
    $this->assertSame(
      10, has_filter('pre_option_cookiebot_notice_recommend', array($class, 'x_core_hide_cookiebot_nags'))
    );

  }

}
