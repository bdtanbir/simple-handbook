<?php
namespace Simple_Handbook;

class CustomMetaboxes {

    public function __construct()
    {
        add_action( 'add_meta_boxes', [$this, 'shb_add_meta_box'] );
        add_action( 'save_post_shb_handbook', [$this, 'shb_save_meta_box'] );
    }


    public function shb_add_meta_box() {

        add_meta_box(
            'shb_handbook_meta',
            __('Book Options', 'simple-handbook'),
            [$this, 'shb_render_meta_box_content'],
            'shb_handbook',
            'advanced',
            'high'
        );
    }

    /**
     * Save the meta when the post is saved.
     * 
     * @param int $post_id The ID of the post being saved.
     */
    public function shb_save_meta_box($post_id) {
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
 
 
        /* OK, it's safe for us to save the data now. */
 
        // Sanitize the user input.
        $mydata = sanitize_text_field( $_POST['shb_book_badge'] );
 
        // Update the meta field.
        update_post_meta( $post_id, 'shb_book_badge', $mydata );

    }


    /**
     * Render Meta Box content.
     * 
     * @param WP_Post $post The post object.
     */
    public function shb_render_meta_box_content( $post ) {

        $badge = get_post_meta( $post->ID, 'shb_book_badge', true );

        // Display the form, using the current value.
        ?>
        <label for="shb_book_badge">
            <?php esc_html_e('Badge for Book', 'simple-handbook'); ?>
        </label>
        <input type="text" class="widefat" id="shb_book_badge" name="shb_book_badge" value="<?php echo esc_attr($badge); ?>">
        <?php

    }
}




