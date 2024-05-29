<?php
/**
 * Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package x
 */

use X_Modules\MenuBar\Component as MenuBar;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class('front-end'); ?> itemscope itemtype="https://schema.org/WebPage">

<?php do_action('theme_before_page'); ?>

<div id="page" class="site js-page">

  <?php
  $site_icon_id = (int) get_option( 'site_icon' );

  AccessibilitySkipToContent::render();
  MenuBar::render(
    array(
      'image_id' => $site_icon_id,
      'menu_location' => 'primary'
    )
  );
  ?>

  <div id="content" class="site-content" role="main" itemscope itemprop="mainContentOfPage">
