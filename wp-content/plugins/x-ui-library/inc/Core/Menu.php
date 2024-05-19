<?php

namespace X_UI\Core;

use WP_Query;
use WP_Rewrite;

class Menu {

  private static ?Menu $instance = null;

  private function __construct() {
    add_action( 'admin_menu', [ $this, 'change_menus_position' ] );
  }

  public static function getInstance(): Menu {
    if ( ! self::$instance ) {
      self::$instance = new Menu();
    }

    return self::$instance;
  }

  public function change_menus_position(): void {

    // Remove old menu
    remove_submenu_page( 'themes.php', 'nav-menus.php' );

    //Add new menu page
    add_menu_page(
      'Menus',
      'Menus',
      'edit_theme_options',
      'nav-menus.php',
      '',
      'dashicons-list-view',
      68
    );
  }


  /**
   * Adds the class property classes for the current context, if applicable.
   *
   * Original code from wp-includes/nav-menu-template.php to copy how WordPress menus works
   *
   * @access private
   *
   * @param \WP_POST[] $menu_items The current menu item objects to which to add the class property information.
   *
   * @global WP_Query   $wp_query   WordPress Query object.
   * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
   *
   * @since 1.0.0
   *
   */
  private static function _wp_menu_item_parser_by_context( array &$menu_items ): void {
    global $wp_query, $wp_rewrite;

    $queried_object    = $wp_query->get_queried_object();
    $queried_object_id = (int) $wp_query->queried_object_id;

    $active_object               = '';
    $active_ancestor_item_ids    = array();
    $active_parent_item_ids      = array();
    $active_parent_object_ids    = array();
    $possible_taxonomy_ancestors = array();
    $possible_object_parents     = array();
    $home_page_id                = (int) get_option( 'page_for_posts' );

    if ( $wp_query->is_singular && ! empty( $queried_object->post_type ) && ! is_post_type_hierarchical( $queried_object->post_type ) ) {
      foreach ( (array) get_object_taxonomies( $queried_object->post_type ) as $taxonomy ) {
        if ( is_taxonomy_hierarchical( $taxonomy ) ) {
          $term_hierarchy = _get_term_hierarchy( $taxonomy );
          $terms          = wp_get_object_terms( $queried_object_id, $taxonomy, array( 'fields' => 'ids' ) );
          if ( is_array( $terms ) ) {
            $possible_object_parents = array_merge( $possible_object_parents, $terms );
            $term_to_ancestor        = array();
            foreach ( (array) $term_hierarchy as $anc => $descs ) {
              foreach ( (array) $descs as $desc ) {
                $term_to_ancestor[ $desc ] = $anc;
              }
            }

            foreach ( $terms as $desc ) {
              do {
                $possible_taxonomy_ancestors[ $taxonomy ][] = $desc;
                if ( isset( $term_to_ancestor[ $desc ] ) ) {
                  $_desc = $term_to_ancestor[ $desc ];
                  unset( $term_to_ancestor[ $desc ] );
                  $desc = $_desc;
                } else {
                  $desc = 0;
                }
              } while ( ! empty( $desc ) );
            }
          }
        }
      }
    } elseif ( ! empty( $queried_object->taxonomy ) && is_taxonomy_hierarchical( $queried_object->taxonomy ) ) {
      $term_hierarchy   = _get_term_hierarchy( $queried_object->taxonomy );
      $term_to_ancestor = array();
      foreach ( (array) $term_hierarchy as $anc => $descs ) {
        foreach ( (array) $descs as $desc ) {
          $term_to_ancestor[ $desc ] = $anc;
        }
      }
      $desc = $queried_object->term_id;
      do {
        $possible_taxonomy_ancestors[ $queried_object->taxonomy ][] = $desc;
        if ( isset( $term_to_ancestor[ $desc ] ) ) {
          $_desc = $term_to_ancestor[ $desc ];
          unset( $term_to_ancestor[ $desc ] );
          $desc = $_desc;
        } else {
          $desc = 0;
        }
      } while ( ! empty( $desc ) );
    }

    $possible_object_parents = array_filter( $possible_object_parents );

    $front_page_url         = home_url();
    $front_page_id          = (int) get_option( 'page_on_front' );
    $privacy_policy_page_id = (int) get_option( 'wp_page_for_privacy_policy' );

    foreach ( (array) $menu_items as $key => $menu_item ) {

      $menu_items[ $key ]->current = false;

      $classes   = (array) $menu_item->classes;
      $classes[] = 'menu-item';
      $classes[] = 'menu-item-type-' . $menu_item->type;
      $classes[] = 'menu-item-object-' . $menu_item->object;

      // This menu item is set as the 'Front Page'.
      if ( 'post_type' === $menu_item->type && $front_page_id === (int) $menu_item->object_id ) {
        $classes[] = 'menu-item-home';
      }

      // This menu item is set as the 'Privacy Policy Page'.
      if ( 'post_type' === $menu_item->type && $privacy_policy_page_id === (int) $menu_item->object_id ) {
        $classes[] = 'menu-item-privacy-policy';
      }

      // If the menu item corresponds to a taxonomy term for the currently queried non-hierarchical post object.
      if ( $wp_query->is_singular && 'taxonomy' === $menu_item->type
           && in_array( (int) $menu_item->object_id, $possible_object_parents, true )
      ) {
        $active_parent_object_ids[] = (int) $menu_item->object_id;
        $active_parent_item_ids[]   = (int) $menu_item->db_id;
        $active_object              = $queried_object->post_type;

        // If the menu item corresponds to the currently queried post or taxonomy object.
      } elseif (
        $menu_item->object_id == $queried_object_id
        && (
          ( ! empty( $home_page_id ) && 'post_type' === $menu_item->type
            && $wp_query->is_home && $home_page_id == $menu_item->object_id )
          || ( 'post_type' === $menu_item->type && $wp_query->is_singular )
          || ( 'taxonomy' === $menu_item->type
               && ( $wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax )
               && $queried_object->taxonomy == $menu_item->object )
        )
      ) {
        $classes[]                   = 'current-menu-item';
        $menu_items[ $key ]->current = true;
        $_anc_id                     = (int) $menu_item->db_id;

        while (
          ( $_anc_id = (int) get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) )
          && ! in_array( $_anc_id, $active_ancestor_item_ids, true )
        ) {
          $active_ancestor_item_ids[] = $_anc_id;
        }

        if ( 'post_type' === $menu_item->type && 'page' === $menu_item->object ) {
          // Back compat classes for pages to match wp_page_menu().
          $classes[] = 'page_item';
          $classes[] = 'page-item-' . $menu_item->object_id;
          $classes[] = 'current_page_item';
          $menu_items[ $key ]->current_page_item = true;
        }

        $active_parent_item_ids[]   = (int) $menu_item->menu_item_parent;
        $active_parent_object_ids[] = (int) $menu_item->post_parent;
        $active_object              = $menu_item->object;

        // If the menu item corresponds to the currently queried post type archive.
      } elseif (
        'post_type_archive' === $menu_item->type
        && is_post_type_archive( array( $menu_item->object ) )
      ) {
        $classes[]                   = 'current-menu-item';
        $menu_items[ $key ]->current = true;
        $_anc_id                     = (int) $menu_item->db_id;

        while (
          ( $_anc_id = (int) get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) )
          && ! in_array( $_anc_id, $active_ancestor_item_ids, true )
        ) {
          $active_ancestor_item_ids[] = $_anc_id;
        }

        $active_parent_item_ids[] = (int) $menu_item->menu_item_parent;

        // If the menu item corresponds to the currently requested URL.
      } elseif ( 'custom' === $menu_item->object && isset( $_SERVER['HTTP_HOST'] ) ) {
        $_root_relative_current = untrailingslashit( $_SERVER['REQUEST_URI'] );

        // If it's the customize page then it will strip the query var off the URL before entering the comparison block.
        if ( is_customize_preview() ) {
          $_root_relative_current = strtok( untrailingslashit( $_SERVER['REQUEST_URI'] ), '?' );
        }

        $current_url        = set_url_scheme( 'https://' . $_SERVER['HTTP_HOST'] . $_root_relative_current );
        $raw_item_url       = strpos( $menu_item->url, '#' ) ? substr( $menu_item->url, 0, strpos( $menu_item->url, '#' ) ) : $menu_item->url;
        $item_url           = set_url_scheme( untrailingslashit( $raw_item_url ) );
        $_indexless_current = untrailingslashit( preg_replace( '/' . preg_quote( $wp_rewrite->index, '/' ) . '$/', '', $current_url ) );

        $matches = array(
          $current_url,
          urldecode( $current_url ),
          $_indexless_current,
          urldecode( $_indexless_current ),
          $_root_relative_current,
          urldecode( $_root_relative_current ),
        );

        if ( $raw_item_url && in_array( $item_url, $matches, true ) ) {
          $classes[]                   = 'current-menu-item';
          $menu_items[ $key ]->current = true;
          $_anc_id                     = (int) $menu_item->db_id;

          while (
            ( $_anc_id = (int) get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) )
            && ! in_array( $_anc_id, $active_ancestor_item_ids, true )
          ) {
            $active_ancestor_item_ids[] = $_anc_id;
          }

          if ( in_array( home_url(), array( untrailingslashit( $current_url ), untrailingslashit( $_indexless_current ) ), true ) ) {
            // Back compat for home link to match wp_page_menu().
            $classes[] = 'current_page_item';
            $menu_items[ $key ]->current_page_item = true;
          }
          $active_parent_item_ids[]   = (int) $menu_item->menu_item_parent;
          $active_parent_object_ids[] = (int) $menu_item->post_parent;
          $active_object              = $menu_item->object;

          // Give front page item the 'current-menu-item' class when extra query arguments are involved.
        } elseif ( $item_url == $front_page_url && is_front_page() ) {
          $classes[] = 'current-menu-item';
          $menu_items[ $key ]->current = true;
        }

        if ( untrailingslashit( $item_url ) == home_url() ) {
          $classes[] = 'menu-item-home';
        }
      }

      // Back-compat with wp_page_menu(): add "current_page_parent" to static home page link for any non-page query.
      if ( ! empty( $home_page_id ) && 'post_type' === $menu_item->type
           && empty( $wp_query->is_page ) && $home_page_id == $menu_item->object_id
      ) {
        $classes[] = 'current_page_parent';
        $menu_items[ $key ]->current_page_parent = true;
      }

      $menu_items[ $key ]->classes = array_unique( $classes );
    }
    $active_ancestor_item_ids = array_filter( array_unique( $active_ancestor_item_ids ) );
    $active_parent_item_ids   = array_filter( array_unique( $active_parent_item_ids ) );
    $active_parent_object_ids = array_filter( array_unique( $active_parent_object_ids ) );

    // Set parent's class.
    foreach ( (array) $menu_items as $key => $parent_item ) {
      $classes                                   = (array) $parent_item->classes;
      $menu_items[ $key ]->current_item_ancestor = false;
      $menu_items[ $key ]->current_item_parent   = false;

      if (
        isset( $parent_item->type )
        && (
          // Ancestral post object.
          (
            'post_type' === $parent_item->type
            && ! empty( $queried_object->post_type )
            && is_post_type_hierarchical( $queried_object->post_type )
            && in_array( (int) $parent_item->object_id, $queried_object->ancestors, true )
            && $parent_item->object != $queried_object->ID
          ) ||

          // Ancestral term.
          (
            'taxonomy' === $parent_item->type
            && isset( $possible_taxonomy_ancestors[ $parent_item->object ] )
            && in_array( (int) $parent_item->object_id, $possible_taxonomy_ancestors[ $parent_item->object ], true )
            && (
              ! isset( $queried_object->term_id ) ||
              $parent_item->object_id != $queried_object->term_id
            )
          )
        )
      ) {
        if ( ! empty( $queried_object->taxonomy ) ) {
          $classes[] = 'current-' . $queried_object->taxonomy . '-ancestor';
          $property_name = 'current_' . $queried_object->taxonomy . '_ancestor';
          $menu_items[$key]->$property_name = true;
        } else {
          $classes[] = 'current-' . $queried_object->post_type . '-ancestor';
          $property_name = 'current_' . $queried_object->post_type . '_ancestor';
          $menu_items[$key]->$property_name = true;
        }
      }

      if ( in_array( (int) $parent_item->db_id, $active_ancestor_item_ids, true ) ) {
        $classes[] = 'current-menu-ancestor';

        $menu_items[ $key ]->current_item_ancestor = true;
      }
      if ( in_array( (int) $parent_item->db_id, $active_parent_item_ids, true ) ) {
        $classes[] = 'current-menu-parent';

        $menu_items[ $key ]->current_item_parent = true;
      }
      if ( in_array( (int) $parent_item->object_id, $active_parent_object_ids, true ) ) {
        $classes[] = 'current-' . $active_object . '-parent';
        $property_name = 'current_' . $active_object . '_parent';
        $menu_items[$key]->$property_name = true;
      }

      if ( 'post_type' === $parent_item->type && 'page' === $parent_item->object ) {
        // Back compat classes for pages to match wp_page_menu().
        if ( in_array( 'current-menu-parent', $classes, true ) ) {
          $classes[] = 'current_page_parent';
          $menu_items[ $key ]->current_page_parent = true;

        }
        if ( in_array( 'current-menu-ancestor', $classes, true ) ) {
          $classes[] = 'current_page_ancestor';
          $menu_items[ $key ]->current_page_ancestor = true;
        }
      }

      $menu_items[ $key ]->classes = array_unique( $classes );
    }
  }

  public static function get_location_menu_items($location) {
    $locations = get_nav_menu_locations();
    if ( ! isset( $locations[ $location ] ) ) {
      if ( defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY ) {
        trigger_error( sprintf( 'Menu location "%s" does not exist.', esc_html( $location ) ), E_USER_NOTICE );
      }
      return [];
    }

// Get the nav menu based on the theme_location.
    $menu = wp_get_nav_menu_object( $locations[ $location ] );
    $menu_items = wp_get_nav_menu_items( $menu->term_id );
    static::_wp_menu_item_parser_by_context( $menu_items );


    $sorted_menu_items = [];
    $menu_items_with_children = [];
    $menu_item_map = [];

    // Create a map of menu items by their ID for easy reference.
    foreach ( (array) $menu_items as $menu_item ) {
      // Fix invalid `menu_item_parent`.
      if ( (string) $menu_item->ID === (string) $menu_item->menu_item_parent ) {
        $menu_item->menu_item_parent = 0;
      }

      $menu_item_map[ $menu_item->ID ] = $menu_item;

      if ( $menu_item->menu_item_parent ) {
        $menu_items_with_children[ $menu_item->menu_item_parent ] = true;
      }
    }

// Build the hierarchical menu structure.
    foreach ( (array) $menu_items as $menu_item ) {
      if ( $menu_item->menu_item_parent ) {
        if ( isset( $menu_item_map[ $menu_item->menu_item_parent ] ) ) {
          if ( ! isset( $menu_item_map[ $menu_item->menu_item_parent ]->children ) ) {
            $menu_item_map[ $menu_item->menu_item_parent ]->children = [];
          }
          $menu_item_map[ $menu_item->menu_item_parent ]->children[] = $menu_item;
        }
      } else {
        $sorted_menu_items[] = $menu_item;
      }
    }

// Add the menu-item-has-children class where applicable.
    foreach ( $menu_item_map as $menu_item_id => $menu_item ) {
      if ( isset( $menu_item->children ) ) {
        $menu_item->classes[] = 'menu-item-has-children';
      }
    }

    unset( $menu_items, $menu_item_map );

    /**
     * Filters the sorted list of menu item objects before generating the menu's HTML.
     *
     * @since 3.1.0
     *
     * @param array    $sorted_menu_items The menu items, sorted by each menu item's menu order.
     * @param \stdClass $args              An object containing wp_nav_menu() arguments.
     */
    $sorted_menu_items = apply_filters( 'wp_nav_menu_objects', $sorted_menu_items, [
      'theme_location' => $location
    ] );

    return $sorted_menu_items;
  }

  public static function get_menu_item_list_attr($menu_item, $args, $depth) {
    $classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
    $classes[] = 'menu-item-' . $menu_item->ID;

    /**
     * Filters the arguments for a single nav menu item.
     *
     * @since 4.4.0
     *
     * @param \stdClass $args      An object of wp_nav_menu() arguments.
     * @param \WP_Post  $menu_item Menu item data object.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    $args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

    /**
     * Filters the CSS classes applied to a menu item's list item element.
     *
     * @since 3.0.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
     * @param \WP_Post  $menu_item The current menu item object.
     * @param \stdClass $args      An object of wp_nav_menu() arguments.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );

    /**
     * Filters the ID attribute applied to a menu item's list item element.
     *
     * @since 3.0.1
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param string   $menu_item_id The ID attribute applied to the menu item's `<li>` element.
     * @param \WP_Post  $menu_item    The current menu item.
     * @param \stdClass $args         An object of wp_nav_menu() arguments.
     * @param int      $depth        Depth of menu item. Used for padding.
     */
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

    $li_atts          = array();
    $li_atts['id']    = ! empty( $id ) ? $id : '';
    $li_atts['class'] = ! empty( $class_names ) ? $class_names : '';

    /**
     * Filters the HTML attributes applied to a menu's list item element.
     *
     * @since 6.3.0
     *
     * @param array $li_atts {
     *     The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
     *
     *     @type string $class        HTML CSS class attribute.
     *     @type string $id           HTML id attribute.
     * }
     * @param \WP_Post  $menu_item The current menu item object.
     * @param \stdClass $args      An object of wp_nav_menu() arguments.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    return apply_filters( 'nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth );
  }
  public static function get_menu_item_link_attr($menu_item, $args, $depth) {
    $atts           = array();
    $atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
    $atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
    if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
      $atts['rel'] = 'noopener';
    } else {
      $atts['rel'] = $menu_item->xfn;
    }

    if ( ! empty( $menu_item->url ) ) {
      if ( get_privacy_policy_url() === $menu_item->url ) {
        $atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
      }

      $atts['href'] = $menu_item->url;
    } else {
      $atts['href'] = '';
    }

    $atts['aria-current'] = $menu_item->current ? 'page' : '';

    /**
     * Filters the HTML attributes applied to a menu item's anchor element.
     *
     * @since 3.6.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     *
     *     @type string $title        Title attribute.
     *     @type string $target       Target attribute.
     *     @type string $rel          The rel attribute.
     *     @type string $href         The href attribute.
     *     @type string $aria-current The aria-current attribute.
     * }
     * @param \WP_Post  $menu_item The current menu item object.
     * @param \stdClass $args      An object of wp_nav_menu() arguments.
     * @param int      $depth     Depth of menu item. Used for padding.
     */
    return apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
  }
}
