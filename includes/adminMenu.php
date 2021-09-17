<?php
namespace Simple_Handbook;

class SHB_admin_menu {

    public function __construct()
    {
        add_action( 'admin_menu', [$this, 'shb_admin_menu_page'] );
        add_action( 'admin_init', [$this, 'shb_register_setting_panel'] );
    }

    public function shb_admin_menu_page() {
        add_menu_page( 
            __('Simple Handbook Options', 'simple-handbook'),
            __('Simple Handbook Options', 'simple-handbook'),
            'manage_options',
            'simple_handbook',
            [$this, 'shb_options_page_html'],
            '',
            80
         );

         add_submenu_page( 
             'simple_handbook',
             __('Update UserMeta', 'simple-handbook'),
             __('Update UserMeta', 'simple-handbook'),
             'manage_options',
             'shb-update-usermeta',
             [$this, 'shb_update_usermeta_callback']
        );

    }

    public function shb_options_page_html() {
        // check user capabilities
        if ( !current_user_can('manage_options')) {
            return;
        }
        ?>

        <div class="simple-handbook-admin">
            <h1><?php echo esc_html__(get_admin_page_title(  )); ?></h1>
            <?php 
                echo do_shortcode( '[shb_shortcode title="hello shortcode" id="10"]' );
            ?>

            <form action="options.php" method="POST">
                <?php 
                    settings_fields('shb_settings_panel_text_group');
                    do_settings_sections('simple_handbook');
                    submit_button(__('Save Settings', 'simple-handbook'));
                ?>
            </form>
        </div>
        
        <?php
    }


    public function shb_update_usermeta_callback() {
        global $wpdb;
        $results = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}posts AS P 
        WHERE P.post_type = 'shb_handbook' and P.post_status = 'publish'"
        );
        error_log(print_r($results, 1));
        ?>
            <div class="shb-usermeta-field">
                <h1><?php esc_html_e('Usermeta', 'simple-handbook'); ?></h1>
                <p>
                    Date of birth: <strong><?php echo get_user_meta( '1', 'birthday', true ); ?></strong>
                </p>

                <form id="shb-radioform">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <input 
                                    type="radio" 
                                    class="shb-radio-input" 
                                    name="book" 
                                    checked="checked" 
                                    value="<?php esc_attr_e('Sycamore Row', 'simple-handbook'); ?>"> <?php esc_html_e('Sycamore Row', 'simple-handbook'); ?>
                                </td>
                                <td>
                                    <?php esc_html_e('John Grisham', 'simple-handbook'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input 
                                    type="radio" 
                                    class="shb-radio-input" 
                                    name="book" 
                                    value="<?php esc_attr_e('Dark Witch', 'simple-handbook'); ?>"> <?php esc_html_e('Dark Witch', 'simple-handbook'); ?>
                                </td>
                                <td>
                                    <?php esc_html_e('Nora Roberts', 'simple-handbook'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>

                <table class="shb-handbook-table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('ID', 'simple-handbook'); ?></th>
                            <th><?php esc_html_e('Title', 'simple-handbook'); ?></th>
                            <th><?php esc_html_e('Content', 'simple-handbook'); ?></th>
                            <th><?php esc_html_e('Status', 'simple-handbook'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($results as $item) { ?>
                            <tr>
                                <td><?php echo esc_html($item->ID); ?></td>
                                <td><?php echo esc_html($item->post_title); ?></td>
                                <td>
                                    <?php 
                                    $content = wp_trim_words( $item->post_content, 3, '...' );
                                    echo esc_html($content); 
                                    ?>
                                </td>
                                <td><?php echo esc_html($item->post_status); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
    }

    public function shb_register_setting_panel() {
        register_setting(
            'shb_settings_panel_text_group', // settings group name
            'simple_text_output', // options name
            'sanitize_text_field' // saintization function
        );
        add_settings_section(
            'shb_settings_panel_main_section_id', // section ID
            '', // title (if needed)
            '', // callback function (if needed)
            'simple_handbook' // page slug
        );
        add_settings_field( 
            'simple_text_output',
            __('Simple Text', 'simple-handbook'),
            [$this, 'shb_simple_text_callback'], // function which prints the field
            'simple_handbook', // page slug
            'shb_settings_panel_main_section_id',
            array(
                'label_for' => 'simple_text_output',
                'class'     => 'shb_simple_text'
            )
        );
    }


    public function shb_simple_text_callback() {
        $simple_text = get_option( 'simple_text_output' );
        ?>
        
        <input 
            type="text" 
            name="simple_text_output" 
            placeholder="<?php esc_attr_e('Add Text here', 'simple-handbook'); ?>" 
            value="<?php echo isset($simple_text) ? esc_attr($simple_text) : ''; ?>">
        <?php
    }


}