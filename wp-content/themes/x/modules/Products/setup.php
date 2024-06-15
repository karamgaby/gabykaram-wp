<?php

/**
 * Load ACF fields
 */
add_filter('acf/settings/load_json', function ($paths) {
    $custom_acf_json_dir = dirname(__FILE__) . '/acf-json';
    $paths[] = $custom_acf_json_dir;

    return $paths;
});

function create_product_cpt()
{
    $labels = array(
        'name' => _x('Products', 'Post type general name', 'textdomain'),
        'singular_name' => _x('Product', 'Post type singular name', 'textdomain'),
        'menu_name' => _x('Products', 'Admin Menu text', 'textdomain'),
        'name_admin_bar' => _x('Product', 'Add New on Toolbar', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'add_new_item' => __('Add New Product', 'textdomain'),
        'new_item' => __('New Product', 'textdomain'),
        'edit_item' => __('Edit Product', 'textdomain'),
        'view_item' => __('View Product', 'textdomain'),
        'all_items' => __('All Products', 'textdomain'),
        'search_items' => __('Search Products', 'textdomain'),
        'parent_item_colon' => __('Parent Products:', 'textdomain'),
        'not_found' => __('No products found.', 'textdomain'),
        'not_found_in_trash' => __('No products found in Trash.', 'textdomain'),
        'featured_image' => _x('Product Cover Image', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image' => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image' => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.3', 'textdomain'),
        'archives' => _x('Product archives', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'textdomain'),
        'insert_into_item' => _x('Insert into product', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this product', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list' => _x('Filter products list', 'Screen reader text for the filter links heading on the admin screen. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Products list navigation', 'Screen reader text for the pagination heading on the admin screen. Added in 4.4', 'textdomain'),
        'items_list' => _x('Products list', 'Screen reader text for the items list heading on the admin screen. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'room-products'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 2,
        'supports' => array('title', 'thumbnail'),
    );

    register_post_type('room-products', $args);

    // Register custom taxonomy for categories
    $category_labels = array(
        'name' => _x('Product Types', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Product Type', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search Product Types', 'textdomain'),
        'all_items' => __('All Product Types', 'textdomain'),
        'parent_item' => __('Parent Product Type', 'textdomain'),
        'parent_item_colon' => __('Parent Product Type:', 'textdomain'),
        'edit_item' => __('Edit Product Type', 'textdomain'),
        'update_item' => __('Update Product Type', 'textdomain'),
        'add_new_item' => __('Add New Product Type', 'textdomain'),
        'new_item_name' => __('New Product Type Name', 'textdomain'),
        'menu_name' => __('Product Types', 'textdomain'),
    );

    $category_args = array(
        'hierarchical' => false,
        'labels' => $category_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-type'),
    );

    register_taxonomy('product_type', array('room-products'), $category_args);
}

add_action('init', 'create_product_cpt');

add_action('acf/init', function () {
    acf_add_options_page(
        array(
            'page_title' => 'Products Options',
            'menu_slug' => 'products-options',
            'parent_slug' => 'edit.php?post_type=room-products',
            'menu_title' => 'Options',
            'position' => 5,
            'redirect' => false,
            'description' => 'Products Global Options',
            'autoload' => true,
        )
    );
});

add_action('acf/include_fields', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $product_type_fields = [];
    $args = array(
        'taxonomy' =>  'product_type',
        'hide_empty' => false, // Set to true to hide terms that are not assigned to any posts
    );
    
    $term_query = new WP_Term_Query($args);
    // die(var_dump($term_query->terms));
    // 
    if(!empty($term_query->terms)) {
        foreach($term_query->terms as $term) {
            $term_slug = $term->slug;
            $product_type_fields[] = array(
                'key' => 'field_666deac7ba8e6'.$term_slug,
                'label' => 'Default Image For Product Type: '.$term->name,
                'name' => 'default_product_image_tax_type_'.$term_slug,
                'aria-label' => '',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'id',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
                'preview_size' => 'medium',
            );
        }
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_666dea7735400',
            'title' => 'Products Options',
            'fields' => array_merge(array(
                array(
                    'key' => 'field_666dea77ba8e4',
                    'label' => 'Products Default Pictures',
                    'name' => '',
                    'aria-label' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'top',
                    'endpoint' => 0,
                    'selected' => 0,
                ),
                array(
                    'key' => 'field_666deaa7ba8e5',
                    'label' => 'Default Image',
                    'name' => 'default_product_image',
                    'aria-label' => '',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'id',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                    'preview_size' => 'medium',
                ),
                
            ), $product_type_fields),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'products-options',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));
});
