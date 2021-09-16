<?php


add_filter( 'shb_post_type_params', 'shb_change_post_type_params' );

add_action( 'init', 'shb_create_post_type' );
function shb_create_post_type() {
    $labels = [
        'name'                  => __('Books', 'simple-handbook'),
        'singular_name'         => __('Book', 'simple-handbook'),
        'menu_name'             => __('Books', 'simple-handbook'),
        'name_admin_bar'        => __('Book', 'simple-handbook'),
        'add_new'               => __('Add New Book', 'simple-handbook'),
        'add_new_item'          => __('Add New Book', 'simple-handbook'),
        'new_item'              => __('New Book', 'simple-handbook'),
        'edit_item'             => __('Edit Book', 'simple-handbook'),
        'view_item'             => __('View Book', 'simple-handbook'),
        'all_items'             => __('All Books', 'simple-handbook'),
        'search_items'          => __('Search Books', 'simple-handbook'),
        'parent_item_colon'     => __('Parent Book', 'simple-handbook'),
        'not_found'             => __('No books found', 'simple-handbook'),
        'not_fount_in_trash'    => __('No books found in Trash', 'simple-handbook'),
        'featured_image'        => __('Book Cover Image', 'simple-handbook'),
        'set_featured_image'    => __('Set cover image', 'simple-handbook'),
        'remove_featured_image' => __('Set cover image', 'simple-handbook'),
        'use_featured_image'    => __('Remove cover image', 'simple-handbook'),
        'archives'              => __('Book archives', 'simple-handbook'),
        'insert_into_item'      => __('Insert into book', 'simple-handbook'),
        'uploaded_to_this_item' => __('Uploaded to this book', 'simple-handbook'),
        'filter_items_list'     => __('Filter books list', 'simple-handbook'),
        'items_list_navigation' => __('Books list navigation', 'simple-handbook'),
        'items_list'            => __('Books list', 'simple-handbook')
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'shb_handbook'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 50,
        'supports'           => ['title', 'thumbnail', 'editor', 'author']
    ];

    register_post_type(
        'shb_handbook', 
        apply_filters('shb_post_type_params', $args)
    );
}
function shb_change_post_type_params( $labels ) {             
    $labels['hierarchical'] = true;
    return $labels;
}
