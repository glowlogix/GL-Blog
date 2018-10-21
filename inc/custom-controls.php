<?php
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'glblog_Customize_Category_Dropdown_Control' )):

    /**
     * Custom Control for category dropdown
     * @package glblog Blog
     * @since 1.0.0
     *
     */
    class glblog_Customize_Category_Dropdown_Control extends WP_Customize_Control {

        /**
         * Declare the control type.
         *
         * @access public
         * @var string
         */
        public $type = 'category_dropdown';

        /**
         * Function to  render the content on the theme customizer page
         *
         * @access public
         * @since 1.0.0
         *
         * @param null
         * @return void
         *
         */
        public function render_content() {
            $glblog_customizer_name = 'glblog_customizer_dropdown_categories_' . $this->id;;
            $glblog_dropdown_categories = wp_dropdown_categories(
                array(
                    'name'              => $glblog_customizer_name,
                    'echo'              => 0,
                    'show_option_none'  =>__('Select','glblog'),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
            $glblog_dropdown_final = str_replace( '<select', '<select ' . $this->get_link(), $glblog_dropdown_categories );
            printf(
                '<label><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $glblog_dropdown_final
            );
        }
    }
    endif;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'glblog_Customize_Post_Dropdown_Control' )):

    /**
     * Custom Control for post dropdown
     * @package AcmeThemes
     * @subpackage glblog
     * @since 1.0.0
     *
     */
    class glblog_Customize_Post_Dropdown_Control extends WP_Customize_Control {
        /**
         * Declare the control type.
         *
         * @access public
         * @var string
         */
        public $type = 'post_dropdown';

        /**
         * Function to  render the content on the theme customizer page
         *
         * @access public
         * @since 1.0.0
         *
         * @param null
         * @return void
         *
         */
        public function render_content() {
            $glblog_customizer_post_args = array(
                'posts_per_page'   => -1,
            );
            $glblog_posts = get_posts( $glblog_customizer_post_args );
            if(!empty($glblog_posts))  {
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <select <?php $this->link(); ?>>
                        <?php
                        $glblog_default_value = $this->value();
                        if( -1 == $glblog_default_value || empty($glblog_default_value)){
                            $glblog_default_selected = 1;
                        }
                        else{
                            $glblog_default_selected = 0;
                        }
                        printf('<option value="-1" %s>%s</option>',selected($glblog_default_selected, 1, false),__('Select','glblog'));
                        foreach ( $glblog_posts as $glblog_post ) {
                            printf('<option value="%s" %s>%s</option>', $glblog_post->ID, selected($this->value(), $glblog_post->ID, false), $glblog_post->post_title);
                        }
                        ?>
                    </select>
                </label>
                <?php
            }
        }
    }
endif;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'glblog_Customize_Message_Control' )):
    /**
     * Custom Control for html display
     * @package AcmeThemes
     * @subpackage glblog
     * @since 1.0.0
     *
     */
    class glblog_Customize_Message_Control extends WP_Customize_Control {

        /**
         * Declare the control type.
         * @access public
         * @var string
         */
        public $type = 'message';

        /**
         * Function to  render the content on the theme customizer page
         *
         * @access public
         * @since 1.0.0
         *
         * @param null
         * @return void
         *
         */
        public function render_content() {
            if ( empty( $this->description ) ) {
                return;
            }
            ?>
            <div class="glblog-customize-customize-message">
                <?php echo wp_kses_post($this->description); ?>
            </div> <!-- .glblog-customize-customize-message -->
            <?php
        }
    }
endif;