<?php

namespace X_UI\Modules\Footer;

use X_UI\Core\Menu;
use X_UI\Modules\Image\Component as Image;

use \X_UI\Core\AbstractComponent;

/**
 * Component: Footer
 *
 * @example
 * X_Footer::render();
 *
 * @package axio
 */
class Component extends AbstractComponent {


  public static function frontend( $data ) {
    $acfData = get_field( 'footer_data', 'option' );
    $logoId                  = $acfData['logo']['id'];
    $about                   = $acfData['about'];
    $site_map_title          = $acfData['site_map_title'];
    $contact_section         = $acfData['contact_section'];
    $contact_section_title   = $contact_section['title'];
    $contact_section_content = $contact_section['content'];

    $menu_location = "site_map";
    $menu_items = Menu::get_location_menu_items($menu_location);
    ?>
    <footer <?php parent::render_attributes( $data['attr'] ); ?> >
      <div class="site-footer__container">
        <div class="site-footer__about-section d-flex gap-3 align-items-center">
          <div class="site-footer__logo">
            <?php
            Image::render( array(
              'size' => 'full',
              'id'   => $logoId
            ) );
            ?>
          </div>
          <?php
          if ( ! empty( $about ) ) :
            ?>
            <div class="site-footer__about">
              <?= $about; ?>
            </div>
          <?php
          endif;
          ?>
        </div>
        <div class="site-footer__explore">
          <div class="site-footer__sitemap">
            <p class="site-footer__title text-center"><?= $site_map_title ?></p>
            <div class="d-flex flex-column" role="list">
              <?php
              foreach ($menu_items as $menu_item) :
                $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
                $title = apply_filters( 'nav_menu_item_title', $title, $menu_item, [
                  'theme_location' => $menu_location
                ], 0 );
                $link_attr = Menu::get_menu_item_link_attr($menu_item, [
                  'theme_location' => $menu_item
                ], 0);
                $list_attr = Menu::get_menu_item_list_attr($menu_item, [
                  'theme_location' => $menu_item
                ], 0);
                if(!isset($list_attr['class'])) {
                  $list_attr['class'] = [];
                } else if( !is_array($list_attr['class']) ) {
                  $list_attr['class'] = [ $list_attr['class'] ];
                }
                $list_attr['class'][] = 'text-center site-footer__sitemap__list-item ';
                ?>
                <div role="listitem" <?php AbstractComponent::render_attributes($list_attr)?>>
                  <a <?php AbstractComponent::render_attributes($link_attr)?> > <?= $title; ?></a>
                </div>
              <?php
              endforeach;
              ?>
            </div>
          </div>
          <div class="site-footer__contact">
            <p class="site-footer__title text-center"><?= $contact_section_title ?></p>
            <div class="site-footer__contact__content d-flex flex-column">
              <?= $contact_section_content ?>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <?php
  }

  public static function backend( $args = [] ) {

    if ( ! isset( $args['attr']['class'] ) ) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'site-footer';
    $args['attr']['class'][] = 'js-site-footer';

    // id
    $args['attr']['id'] = 'colophon';

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype']  = 'https://schema.org/WPFooter';

    return $args;

  }

}
