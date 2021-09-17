<?php
/**
 * Plugin Name: Simple Handbook
 * Plugin URI:
 * Author: Tanbir Ahmod
 * Author URI: 
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: An simple Description for Simple Handbook.
 * Version: 1.0
 * Text Domain: simple-handbook
 */

if (!defined('ABSPATH')) die('No Direct Access is allowed');

if (!class_exists('SimpleHandbook')) {
    class SimpleHandbook {

        /**
         * Version
         */
        public $version = '1.0';

        public $container = array();

        public function __construct()
        {
            $this->define_constants();
            register_activation_hook(__FILE__, [$this, 'activate']);
            register_deactivation_hook(__FILE__, [$this, 'deactivate']);

            add_filter( 'body_class', [$this, 'shb_css_body_class'] );


            add_action( 'plugins_loaded', [$this, 'loaded_plugin'] );
        }


        /**
         * initialize the SimpleHandbook() Class
         */
        public static function init() {
            static $instance  = false;
            if ( !$instance ) {
                $instance = new SimpleHandbook();
            }
            return $instance;
        }


        /**
         * Placeholder for activation function
         * 
         * Nothing being called here yet.
         */
        public function activate() {
            $installed = get_option( 'simplehandbook_installed' );

            if( !$installed ) {
                update_option( 'simplehandbook_installed', time() );
            }
            update_option( 'SHB_version', SHB_VERSION );
            
        }

        public function deactivate() {

        }

        public function define_constants() {
            define( 'SHB_VERSION', $this->version );
            define( 'SHB_URI', plugin_dir_url(  __FILE__ ) );
            define( 'SHB_PATH', plugin_dir_path( __FILE__ ) );
        }


        public function loaded_plugin() {
            if (is_admin()) {
                // Custom Post Types Register
                require_once SHB_PATH . '/includes/custom-posttypes.php';

                // Options Page
                require_once SHB_PATH . '/includes/adminMenu.php';
                $this->container['admin_menu'] = new Simple_Handbook\SHB_admin_menu;

                // Shortcodes
                require_once SHB_PATH . '/includes/shortcodes.php';
                $this->container['shortcodes'] = new Simple_Handbook\Shortcodes;

                // Metaboxes
                require_once SHB_PATH . '/includes/custom-metaboxes.php';
                $this->container['custom_metaboxes'] = new Simple_Handbook\CustomMetaboxes;

                // Custom Taxonomy
                require_once SHB_PATH . '/includes/custom-taxonomy.php';
                $this->container['custom_taxonomy'] = new Simple_Handbook\Custom_Taxonomy;

                // Customize Usermeta
                require_once SHB_PATH . '/includes/customize-usermeta.php';
                $this->container['customize_usermeta'] = new Simple_Handbook\Customize_usermeta;
            }
        }

        public function shb_css_body_class($classes) {
            if(!is_admin()) {
                $classes[] = 'simple-handbook-is-awesome';
            }
            return $classes;
        }


    }

    $simplehandbook = SimpleHandbook::init();
}
