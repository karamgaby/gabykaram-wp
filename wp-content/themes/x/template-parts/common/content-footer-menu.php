<?php

if ( ! isset( $args ) || empty( $args['menu_location'] ) ) {
	return '';
}
$menu_location = $args['menu_location'];

if ( wp_nav_menu( array(
		'theme_location' => $menu_location,
		'fallback_cb'    => false,
		'echo'           => false
	) ) !== false ) :
	$theme_locations = get_nav_menu_locations();
	$menu_obj    = get_term( $theme_locations[ $menu_location ], 'nav_menu' );
	$menu_title  = get_field( 'menu_title', $menu_obj );
	?>
    <div class="footer-menu-wrapper">
      <?php
      if ( $menu_title ) :
	      ?>
          <label class="ps-typography-subtitle1 ps-color-other-white mb-16"><?= $menu_title; ?></label>
      <?php
      endif;
      wp_nav_menu( array(
	      'container'      => false,
	      'theme_location' => $menu_location,
	      'menu_class'     => 'navigation-menu navigation-menu-primary',
	      'walker'         => new PS_Walker('ps-footer-menu-btn-white'),
	      'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	      'depth'          => 1
      ) );
      ?>
    </div>
<?php
endif;
