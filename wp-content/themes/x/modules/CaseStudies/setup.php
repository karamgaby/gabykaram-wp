<?php
namespace X_Modules\Products;

/**
 * Load ACF fields
 */
add_filter('acf/settings/load_json', function ($paths) {
    $custom_acf_json_dir = dirname(__FILE__) . '/acf-json';
    $paths[] = $custom_acf_json_dir;

    return $paths;
});

add_action('init', __NAMESPACE__ . '\\create_cpt');


function create_cpt()
{
    $labels = array(
        'name' => _x('Case Studies', 'Post type general name', 'textdomain'),
        'singular_name' => _x('Case Study', 'Post type singular name', 'textdomain'),
        'menu_name' => _x('Case Studies', 'Admin Menu text', 'textdomain'),
        'name_admin_bar' => _x('Case Study', 'Add New on Toolbar', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'add_new_item' => __('Add New Case Study', 'textdomain'),
        'new_item' => __('New Case Study', 'textdomain'),
        'edit_item' => __('Edit Case Study', 'textdomain'),
        'view_item' => __('View Case Study', 'textdomain'),
        'all_items' => __('All Case Studies', 'textdomain'),
        'search_items' => __('Search Case Studies', 'textdomain'),
        'parent_item_colon' => __('Parent Case Studies:', 'textdomain'),
        'not_found' => __('No Case Studies found.', 'textdomain'),
        'not_found_in_trash' => __('No Case Studies found in Trash.', 'textdomain'),
        'featured_image' => _x('Case Study Cover Image', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image' => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image' => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'archives' => _x('Case Study archives', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'textdomain'),
        'insert_into_item' => _x('Insert into Case Study', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this Case Study', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list' => _x('Filter Case Studies list', 'Screen reader text for the filter links heading on the admin screen. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Case Studies list navigation', 'Screen reader text for the pagination heading on the admin screen. Added in 4.4', 'textdomain'),
        'items_list' => _x('Case Studies list', 'Screen reader text for the items list heading on the admin screen. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'case-studies'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 2,
        'supports' => array('title', 'thumbnail', 'editor'),
    );

    register_post_type('case-studies', $args);

    // Register custom taxonomy for categories
    $category_labels = array(
        'name' => _x('Case Study Types', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Case Study Type', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search Case Study Types', 'textdomain'),
        'all_items' => __('All Case Study Types', 'textdomain'),
        'parent_item' => __('Parent Case Study Type', 'textdomain'),
        'parent_item_colon' => __('Parent Case Study Type:', 'textdomain'),
        'edit_item' => __('Edit Case Study Type', 'textdomain'),
        'update_item' => __('Update Case Study Type', 'textdomain'),
        'add_new_item' => __('Add New Case Study Type', 'textdomain'),
        'new_item_name' => __('New Case Study Type Name', 'textdomain'),
        'menu_name' => __('Case Study Types', 'textdomain'),
    );

    $category_args = array(
        'hierarchical' => false,
        'labels' => $category_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'case-study-tag'),
    );

    register_taxonomy('case-study-tag', array('case-studies'), $category_args);
}