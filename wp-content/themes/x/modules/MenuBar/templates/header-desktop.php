<?php

use X_UI\Core\AbstractComponent;
use \X_UI\Core\Menu;
use X_UI\Modules\Buttons\Component as Button;
use X_UI\Modules\Image\Component as Image;
if ( ! isset( $data ) ) {
  return;
}
$logo_id = $data->image_id;
$menu_location = $data->menu_location;
$componentTokens = X_Modules\MenuBar\Tokens::getInstance();
$desktopTokens = $componentTokens->getMeta('desktop');

$menu_items = Menu::get_location_menu_items($menu_location);
?>

<div class="menuBarDesktop">
  <div class="menuBarDesktop__container container py-2 d-flex justify-content-between">
    <a href="<?php echo esc_url(home_url()); ?>">
      <?php
      Image::render( array(
        'id'   => $logo_id,
        'attr' => [
          'class' => 'menuBarDesktop__site-logo'
        ]
      ) );
      ?>
    </a>
    <nav>
      <div class="d-flex gap-1" role="list">
        <?php
        foreach ($menu_items as $menu_item) :
          $is_active = $menu_item->current;
          $menu_btn_style = get_field('button_style', $menu_item->ID);
          $active_menu_btn_style = get_field('active_button_style', $menu_item->ID);
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
</div>
