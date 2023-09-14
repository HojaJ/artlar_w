<?php
/**
* Plugin's Options
*/

if ( !class_exists( 'TRXPopupOptions' ) ) {
    class TRXPopupOptions {
        /**
         * Holds the values to be used in the fields callbacks
         */
        private $options;

        /**
         * Start up
         */        
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

        /**
         * Add options page
         */
        public function add_plugin_page()  {
            // This page will be under "Settings"
             add_menu_page(
                __('ThemeREX Pop-Up', 'trx_popup'), 
                __('ThemeREX Pop-Up', 'trx_popup'), 
                'manage_options', 
                'trx-popup-options-page', 
                array( $this, 'create_admin_page' )
            );
        }

        /**
         * Options page callback 
         */
        public function create_admin_page()
        {
            // Set class property
            $this->options = get_option( 'trx-popup-options' );
            ?>
            <div class="trx_popup_options_form">
                <h2 class="trx_popup_options_title"><?php echo __('ThemeREX Pop-Up Settings', 'trx_popup'); ?></h2>
                <form method="post" action="options.php">
                <?php
                    // This prints out all hidden setting fields
                    settings_fields( 'trx-popup-option-group' );
                    do_settings_sections( 'trx-popup-options-page' );
                    submit_button();
                ?>
                </form>
            </div>
            <?php
        }

        /**
         * Register and add settings
         */
        public function page_init()
        {        
            register_setting(
                'trx-popup-option-group',
                'trx-popup-options', 
                array( $this, 'sanitize' ) 
            ); 
            /* Content
            ------------------------------ */
            add_settings_section(
                'content-section',
                __('Content', 'trx_popup'),
                array( $this, 'section_callback' ),
                'trx-popup-options-page'
            ); 
            add_settings_field(
                'title-text', 
                __('Title', 'trx_popup'), 
                array( $this, 'textarea_callback' ), 
                'trx-popup-options-page', 
                'content-section',
                array(
                    'name' => 'title-text',
                    'default' => __('This Pop-up Is Included in the Theme', 'trx_popup'),
                    'wp_editor' => true,
                    'media_buttons' => false
                ) 
            );        
            add_settings_field(
                'subtitle-text', 
                __('Subtitle', 'trx_popup'), 
                array( $this, 'text_callback' ), 
                'trx-popup-options-page', 
                'content-section',
                array(
                    'name' => 'subtitle-text',
                    'default' => __('Best Choice for Creatives', 'trx_popup'),
                )                 
            );                
            add_settings_field(
                'subtitle-pos', 
                __('Subtitle position', 'trx_popup'),
                array( $this, 'select_callback' ), 
                'trx-popup-options-page', 
                'content-section',
                array(
                    'name' => 'subtitle-pos', 
                    'list' => array(
                        'below' => 'Below title',
                        'above' => 'Above title'
                    )
                )
            );       
            add_settings_field(
                'descr-text', 
                __('Description', 'trx_popup'), 
                array( $this, 'textarea_callback' ), 
                'trx-popup-options-page', 
                'content-section',
                array(
                    'name' => 'descr-text',
                    'wp_editor' => true,
                    'media_buttons' => true
                )
            );    
            add_settings_field(
                'button-text', 
                __('Button text', 'trx_popup'), 
                array( $this, 'text_callback' ), 
                'trx-popup-options-page', 
                'content-section',                
                array(
                    'name' => 'button-text',
                    'default' => __('Purchase Now', 'trx_popup')
                )
            );     
            add_settings_field(
                'button-url', 
                __('Button URL', 'trx_popup'), 
                array( $this, 'text_callback' ), 
                'trx-popup-options-page', 
                'content-section',
                array(
                    'name' => 'button-url',
                    'default' => '#'
                )                
            );
             /* Content after timer triggered
            ------------------------------ */
            add_settings_section(
                'timer-section',
                __('Content after timer triggered', 'trx_popup') . '<span>'. __("These parameters will be applied when the timer is triggered. If you want to disable the pop-up after a certain date, specify only the 'Date and time' values and leave the rest of the fields empty.", 'trx_popup') .'</span>',
                array( $this, 'section_callback' ),
                'trx-popup-options-page'
            ); 
            add_settings_field(
                'date', 
                __("Date and time", 'trx_popup'),
                array( $this, 'date_callback' ),  
                'trx-popup-options-page', 
                'timer-section',               
                array(
                    'name' => 'date', 
                    'descr' => ''
                )
            ); 
            add_settings_field(
                'time', 
                '',
                array( $this, 'time_callback' ),  
                'trx-popup-options-page', 
                'timer-section',
                array(
                    'name' => 'time', 
                    'descr' => ''
                )
            );
            add_settings_field(
                'timer-title-text', 
                __('Title', 'trx_popup'), 
                array( $this, 'textarea_callback' ), 
                'trx-popup-options-page', 
                'timer-section',
                array(
                    'name' => 'timer-title-text',
                    'wp_editor' => true,
                    'media_buttons' => false
                )
            ); 
            add_settings_field(
                'timer-subtitle-text', 
                __('Subtitle', 'trx_popup'), 
                array( $this, 'text_callback' ), 
                'trx-popup-options-page', 
                'timer-section',
                array(
                    'name' => 'timer-subtitle-text', 
                )
            );
            add_settings_field(
                'timer-descr-text', 
                __('Description', 'trx_popup'), 
                array( $this, 'textarea_callback' ), 
                'trx-popup-options-page', 
                'timer-section',
                array(
                    'name' => 'timer-descr-text',
                    'wp_editor' => true,
                    'media_buttons' => true
                )
            );
            add_settings_field(
                'timer-button-text', 
                __('Button text', 'trx_popup'), 
                array( $this, 'text_callback' ), 
                'trx-popup-options-page', 
                'timer-section',
                array(
                    'name' => 'timer-button-text', 
                )
            );
            add_settings_field(
                'timer-button-url', 
                __('Button URL', 'trx_popup'), 
                array( $this, 'text_callback' ), 
                'trx-popup-options-page', 
                'timer-section',
                array(
                    'name' => 'timer-button-url', 
                )
            );  
            /* Pop-up style
            ------------------------------ */
            add_settings_section(
                'style-section',
                __('Style, position & animation', 'trx_popup'),
                array( $this, 'section_callback' ),
                'trx-popup-options-page'
            ); 
            add_settings_field(
                'image', 
                __('Background image', 'trx_popup'), 
                array( $this, 'image_callback' ), 
                'trx-popup-options-page', 
                'style-section',
                array(
                    'name' => 'image',
                    'descr' => __('Pop-up background image.', 'trx_popup')
                )
            );
            add_settings_field(
                'position', 
                __('Pop-Up position', 'trx_popup'),
                array( $this, 'select_callback' ), 
                'trx-popup-options-page', 
                'style-section',
                array(
                    'name' => 'position', 
                    'descr' => __('Pop-up position on the site.', 'trx_popup'),                
                    'list' => array(
                        'topleft' => 'Top Left', 
                        'topright' => 'Top Right',
                        'bottomleft' => 'Bottom Left',
                        'bottomright' => 'Bottom Right'
                    )
                )
            );
            add_settings_field(
                'appearance', 
                __('Animation appearance', 'trx_popup'),
                array( $this, 'select_callback' ), 
                'trx-popup-options-page', 
                'style-section',
                array(
                    'name' => 'appearance', 
                    'list' => array(
                        'fadeIn' => 'Fade In', 
                        'fadeInDown' => 'Fade In Down',
                        'fadeInLeft' => 'Fade In Left',
                        'fadeInRight' => 'Fade In Right',
                        'fadeInUp' => 'Fade In Up'
                    )
                )
            );  
            add_settings_field(
                'disappearance', 
                __('Animation disappearance', 'trx_popup'),
                array( $this, 'select_callback' ), 
                'trx-popup-options-page', 
                'style-section',
                array(
                    'name' => 'disappearance', 
                    'list' => array(
                        'fadeOut' => 'Fade Out', 
                        'fadeOutDown' => 'Fade Out Down',
                        'fadeOutLeft' => 'Fade Out Left',
                        'fadeOutRight' => 'Fade Out Right',
                        'fadeOutUp' => 'Fade Out Up'
                    )
                )
            ); 
            add_settings_field(
                'custom-css', 
                __('Custom CSS', 'trx_popup'), 
                array( $this, 'textarea_callback' ), 
                'trx-popup-options-page', 
                'style-section',
                array(
                    'name' => 'custom-css',
                    'wp_editor' => false,
                    'media_buttons' => false                 
                )
            );  
            /* Other
            ------------------------------ */
            add_settings_section(
                'other-section',
                __('Other', 'trx_popup'),
                array( $this, 'section_callback' ),
                'trx-popup-options-page'
            ); 
            add_settings_field(
                'animation-delay', 
                __('Pop-Up delay', 'trx_popup'), 
                array( $this, 'range_callback' ), 
                'trx-popup-options-page', 
                'other-section',
                array(
                    'name' => 'animation-delay',
                    'descr' => __('How many seconds to wait before the popup appears.', 'trx_popup'),
                    'default' => 1,
                    'max' => 120
                )
            );
            add_settings_field(
                'pages', 
                __("Pages for pop-up display ", 'trx_popup'),
                array( $this, 'text_callback' ),  
                'trx-popup-options-page', 
                'other-section',
                array(
                    'name' => 'pages', 
                    'descr' => __("Insert IDs of the pages (comma-separated) where you want the pop-up to be displayed. Leave the input empty if you want to show the pop-up on all pages.", 'trx_popup'),
                )
            );  
            add_settings_field(
                'cache', 
                __("Hide after closure", 'trx_popup'),
                array( $this, 'checkbox_callback' ),  
                'trx-popup-options-page', 
                'other-section',
                array(
                    'name' => 'cache', 
                    'descr' => __("Don't show the pop-up again after closure.", 'trx_popup'),
                )
            );  
            add_settings_field(
                'refresh-interval', 
                __('Refresh interval', 'trx_popup'), 
                array( $this, 'range_callback' ),  
                'trx-popup-options-page', 
                'other-section',
                array(
                    'name' => 'refresh-interval',
                    'descr' => __("Choose the number of days after which the popup should be displayed again.", 'trx_popup'),
                    'default' => 1,
                    'max' => 365
                )
            ); 
            add_settings_field(
                'publish', 
                __("Publish pop-up", 'trx_popup'),
                array( $this, 'checkbox_callback' ),  
                'trx-popup-options-page', 
                'other-section',                
                array(
                    'name' => 'publish', 
                    'descr' => __("Pop-up is ready to be published.", 'trx_popup'),
                )
            );  
        }

        /**
         * Sanitize each setting field as needed
         *
         * @param array $input Contains all settings fields as array keys
         */
        public function sanitize( $input )
        {
            $new_input = array();
            $options = array(
            'title-text',           
            'subtitle-text',
            'subtitle-pos',
            'descr-text',
            'button-text',
            'button-url',

            'date',
            'time',
            'timer-title-text',
            'timer-subtitle-text', 
            'timer-descr-text',
            'timer-button-text',
            'timer-button-size',
            'timer-button-url',

            'image',
            'position',
            'action',
            'animation-delay',
            'appearance',
            'disappearance',
            'custom-css',

            'pages',
            'cache',
            'refresh-interval',
            'publish',
            );
            foreach ($options as $key) {
                if( isset( $input[$key] ) ) {                    
                    $new_input[$key] =  $input[$key];
                }
            }         
            return $new_input;
        }

        /** 
         * Get the settings option array and print one of its values
         */        
        // Section
        public function section_callback() {}

        // Text      
        public function text_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            $default = array_key_exists('default', $args) ? $args['default'] : '';
            if ( !empty($name) ) {  
                $val = isset( $this->options[$name] ) ? $this->options[$name] : $default;
                echo '<input type="text" id="' . esc_attr($name) . '" name="trx-popup-options[' . esc_attr($name) . ']" value="' . esc_attr($val) . '" />';
            }
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }
        }

        // Textarea      
        public function textarea_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            $default = array_key_exists('default', $args) ? $args['default'] : '';
            if ( !empty($name) ) {   
                $val = isset( $this->options[$name] ) ? $this->options[$name] : $default;
                if (  $args['wp_editor'] ) {
                    wp_editor( $val, esc_attr($name), array(
                        'wpautop'       => 1,
                        'media_buttons' => $args['media_buttons'] ? 1 : 0,
                        'textarea_name' => 'trx-popup-options['. esc_attr($name) .']', 
                        'textarea_rows' => 5,
                        'tabindex'      => null,
                        'editor_css'    => '',
                        'editor_class'  => '',
                        'teeny'         => 0,
                        'dfw'           => 0,
                        'tinymce'       => 1,
                        'quicktags'     => 1,
                        'drag_drop_upload' => false
                    ) );
                } else {
                    echo '<textarea id="' . esc_attr($name) . '" name="trx-popup-options[' . esc_attr($name) . ']" rows="10" cols="20">' . esc_html($val) . '</textarea>';
                }
            }
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }
        }

        // Range    
        public function range_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            $default = array_key_exists('default', $args) ? $args['default'] : '';
            $min = array_key_exists('min', $args) ? $args['min'] : 0;
            $max = array_key_exists('max', $args) ? $args['max'] : 500;

            if ( !empty($name) ) {
                $val = isset( $this->options[$name] ) ? $this->options[$name] :  $default;
                echo '<div class="range_slider_wrap">
                        <span class="range_slider_min">' . esc_html($min) . '</span>
                        <div class="range_slider">
                            <input type="range" id="' . esc_attr($name) . '" name="trx-popup-options[' . esc_attr($name) . ']" value="' . esc_attr($val) . '" min="' . esc_html($min) . '" max="' . esc_html($max) . '" />
                            <span class="range_slider_runner">' . esc_html($val) . '</span>
                        </div>
                        <span class="range_slider_max">' . esc_html($max) . '</span>
                    </div>';
            }
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }
        }

        // Date
        public function date_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            $default = array_key_exists('default', $args) ? $args['default'] : '';
            if ( !empty($name) ) {
                $val = isset( $this->options[$name] ) ? $this->options[$name] :  $default;
                echo '<input type="date" id="' . esc_attr($name) . '" name="trx-popup-options[' . esc_attr($name) . ']" value="' . esc_attr($val) . '" />';
            }
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }
        }  

        // Time
        public function time_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            $default = array_key_exists('default', $args) ? $args['default'] : '';
            if ( !empty($name) ) {                
                $val = isset( $this->options[$name] ) ? $this->options[$name] :  $default;
                echo '<input type="time" id="' . esc_attr($name) . '" name="trx-popup-options[' . esc_attr($name) . ']" value="' . esc_attr($val) . '" />';
            }
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }
        }  

        // Select
        public function select_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            $list = array_key_exists('list', $args) ? $args['list'] : '';
            if ( !empty($name) ) {
                $selected = isset( $this->options[$name] ) ? esc_attr( $this->options[$name]) : '';
                $output =  '<select id="'. esc_attr($name) .'" name="trx-popup-options[' . esc_attr($name) . ']">';
                foreach ($list as $key => $value) {
                    if ( !empty($selected) && $key == $selected ) {
                        $output .=  '<option selected value="'. esc_attr($key) .'">'. esc_html($value) .'</option>';
                    } else {
                        $output .=  '<option value="'. esc_attr($key) .'">'. esc_html($value) .'</option>';
                    } 
                }
                $output .=  '</select>';
                echo $output;
            }
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }
        } 

        // Checkbox
        public function checkbox_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            if ( !empty($name) ) {
                $val = isset( $this->options[$name] ) ? 'checked' : '';
                echo '<input type="checkbox" id="' . esc_attr($name) . '" name="trx-popup-options[' . esc_attr($name) . ']" value="' . esc_attr($val) . '" ' . esc_attr($val) . ' />';
            }
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }         
        }

        // Image
        public function image_callback($args) {
            $name = array_key_exists('name', $args) ? $args['name'] : '';
            $descr = array_key_exists('descr', $args) ? $args['descr'] : '';
            $src = '';
            if ( !empty($name) ) {
                $value = trx_popup_get_option($name);    
                if ( $value > 0 ) {
                    $src = wp_get_attachment_image_url($value, 'full');
                }
                echo '<div class="upload">
                        <img '.(!empty($src) ? 'src="' . esc_url($src) . '"' : 'class="hide"' ) . ' width="150px" />
                        <div>
                            <input type="hidden" name="trx-popup-options[' . esc_attr($name) . ']" id="trx_popup_options_' . esc_attr($name) . '" value="' . esc_attr($value) . '" />
                            <button type="submit" class="upload_image_button button">' . esc_html__( 'Upload', 'trx_popup' ) . '</button>
                            <button type="submit" class="remove_image_button button">' . esc_html__( 'Remove', 'trx_popup' ) . '</button>
                        </div>
                    </div>';      
            }   
            if ( !empty($descr) ) { 
                echo '<span>'. esc_html($descr) .'</span>';
            }          
        }
    }
}

if( is_admin() ) {
   $trx_popup_settings = new TRXPopupOptions();
}