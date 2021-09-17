<?php
namespace Simple_Handbook;

class Custom_Taxonomy {
    public function __construct()
    {
        add_action( 'init', [$this, 'shb_register_taxonomy_book'] );
    }

    public function shb_register_taxonomy_book() {
        $labels  = array(
            'name'              => __('Book Categories', 'simple-handbook'),
            'singular_name'     => __('Book', 'simple-handbook'),
            'search_items'      => __('Search Books Categories', 'simple-handbook'),
            'all_items'         => __('All Books Categories', 'simple-handbook'),
            'parent_item'       => __('Parent Book Category', 'simple-handbook'),
            'parent_item_colon' => __('Parent Book Category', 'simple-handbook'),
            'edit_item'         => __('Edit Book Category', 'simple-handbook'),
            'update_item'       => __('Update Book Category', 'simple-handbook'),
            'add_new_item'      => __('Add New Book Category', 'simple-handbook'),
            'new_item_name'     => __('New Book Name', 'simple-handbook'),
            'menu_name'         => __('Books Categories', 'simple-handbook')
        );
        $args = array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'book_cats']
        );
        register_taxonomy( 'book_cats', 'shb_handbook', $args );
    }
}