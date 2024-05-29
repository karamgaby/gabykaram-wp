<?php

use X_UI\Core\AbstractComponent;
use X_UI\Core\Menu;
use X_Modules\MenuBar\Tokens;
use X_UI\Modules\Buttons\Component as Button;
if ( ! isset( $data ) ) {
  return;
}
$menu_location = $data->menu_location;
$componentTokens       = Tokens::getInstance();
$mobileTokens          = $componentTokens->getMeta( 'mobile' );
$menu_btn_style        = $mobileTokens['button_style'];
$active_menu_btn_style = $mobileTokens['active_button_style'];
$menu_items = Menu::get_location_menu_items($menu_location);
?>
<div class="x-header-drawer offcanvas-js offcanvas offcanvas-end" data-bs-custom-class="beautifier" tabindex="-1"
     id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

  <nav>
    <div class="d-flex flex-column gap-1" role="list">
      <?php
      foreach ($menu_items as $menu_item) :
        $is_active = $menu_item->current;
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

        if(!isset($link_attr['class'])) {
          $link_attr['class'] = '';
        }
        $link_attr['class'] .= ' x-header-drawer-link-js w-100';
        ?>
        <div role="listitem" <?php AbstractComponent::render_attributes($list_attr)?>>
          <?php
          Button::render(
            array(
              'style'=> $is_active ? $active_menu_btn_style : $menu_btn_style,
              'title' => $title,
              'attr' => $link_attr
            )
          );
          ?>
        </div>
      <?php
      endforeach;
      ?>
    </div>
  </nav>
</div>
