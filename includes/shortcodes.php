<?php
namespace Simple_Handbook;

class Shortcodes {

    public function __construct()
    {
        add_shortcode( 'shb_shortcode', [$this, 'shb_shortcode'] );
        add_action( 'init', [$this, 'shb_shortcodes_init'] );
    }


    public function shb_shortcode( $atts = [], $content = null, $tag = '') {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        // override default attributes with user attributes
        $shb_atts = shortcode_atts( 
            array(
                'title' => 'SimpleHandbook.io',
            ), $atts, $tag 
        );

        // start box
        $o = '<div class="shb-box">';

        // title
        $o .= '<h2>' . esc_html__($shb_atts['title'], 'simple-handbook') .'</h2>';

        // enclosing tags
        if (!is_null($content)) {
            // secure output by executing the_content hook on $content
            $o .= apply_filters('the_content', $content);

            // run shortcode parser recursively
            $o .= do_shortcode( $content );
        }

        // end box
        $o .= '</div>';

        // return output
        return $o;
    }

    public function shb_shortcodes_init() {
    }
}




