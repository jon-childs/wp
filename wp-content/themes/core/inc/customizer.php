<?php
//==== JC_CORE Theme Customizer

class jc_core_customize {

    public static function get_fonts_array() {
    // @todo - Get this out of this class and into a custom control for reusability + performance reasons

        $body_fonts = array(
            'arial'     => array(
                'name' => 'Arial',
                'css'  => 'Arial,"Helvetica Neue",Helvetica,sans-serif',
                'url'  => false
            ),
            'helvetica' => array(
                'name' => 'Helvetica',
                'css'  => '"Helvetica Neue",Helvetica,Arial,sans-serif',
                'url'  => false
            ),
            'verdana'   => array(
                'name' => 'Verdana',
                'css'  => 'Verdana,Geneva,sans-serif',
                'url'  => false
            ),
            'times' => array(
                'name' => 'Times New Roman',
                'css'  => 'TimesNewRoman,"Times New Roman",Times,Baskerville,Georgia,serif',
                'url'  => false
            ),
        );

        $heading_fonts = $body_fonts;

        $google_fonts_query_results = get_site_transient( 'google_fonts_query_results' ); // Check in the database for a cached copy of the google fonts list...

        if ( $google_fonts_query_results === false ) { // If it's missing, go get one and cache it
            error_log('Querying Google Fonts');
            $google_public_api_key = 'AIzaSyCXH2reNmyZDSFvdUkdg747bge3gRNtVL4';
            
            $response = wp_remote_get( 'https://www.googleapis.com/webfonts/v1/webfonts?&sort=popularity&key=' . $google_public_api_key );
            if ( ! is_wp_error($response) ) {
                $google_fonts_query_results_raw = json_decode(wp_remote_retrieve_body($response), true);
                $google_fonts_query_results = [];

                foreach ( $google_fonts_query_results_raw['items'] as $font ) {

                    $body_categories = array('sans-serif', 'serif');

                    if ( in_array( $font['category'], $body_categories ) ) {
                        $google_fonts_query_results[] = $font;
                    }

                }

                set_site_transient( 'google_fonts_query_results', $google_fonts_query_results, 3 * DAY_IN_SECONDS ); // Cache lasts for three days
            } elseif ( WP_DEBUG ) {
                echo '<pre>';
                var_dump($response);
                echo '</pre>';
                die();
            }
        }
        
        foreach ( $google_fonts_query_results as $font ) {
            $font_name = $font['family'];                       // Name of the font
            $font_name_slug = sanitize_title($font_name);       // Slug of the font (as an array key)

            $font_url_array = [];                                       // Initialize an empty array for constructing the URL to retrieve the font
            $font_url_array[] = '//fonts.googleapis.com/css?family=';   // Base request URL
            $font_url_array[] = preg_replace('/ /', '+', $font_name);  // Font name (URL friendly)

            // Figure out variants

            $variants_url_attachment = [];                                                      // Initialize an empty array for constructing the variants chunk of the URL
            $variants = array( 'regular', 'italic', '400', '400italic', '700', '700italic' );   // Look for these
            $found = false;                                                                     // Does it contain one of these variants? Not yet...

            foreach ( $variants as $variant ) {

                if ( in_array($variant, $font['variants'] ) ) {
                    $found = true;

                    if ( $variant === 'regular' ) { // Change regular (in the JSON response) to 400 (for the font include URL)
                        $variant = '400';
                    }

                    if ( $variant === 'italic' ) { // Change italic (in the JSON response) to 400italic (for the font include URL)
                        $variant = '400italic';
                    }

                    $variants_url_attachment[] = $variant;
                }
            }

            if ( $found ) {
                $font_url_array[] = ':' . implode( ',' , array_unique($variants_url_attachment) );
            }

            //Phew...

            $font_url = implode('', $font_url_array);

            // Now the CSS...

            $font_css = ( strpos($font_name, ' ') !== false ? '"' . $font_name . '"' : $font_name ) . ', ' . $font['category'];

            $body_categories = array('sans-serif', 'serif');

            if ( in_array( $font['category'], $body_categories ) ) {
                $google_fonts_query_results[] = $font;
            }

            $body_categories = array('sans-serif', 'serif');

            if ( in_array( $font['category'], $body_categories ) ) {
                $body_fonts[$font_name_slug] = array(
                    'name' => $font_name,
                    'css' => $font_css,
                    'url' => $font_url,
                );
            }
            $heading_fonts[$font_name_slug] = array(
                'name' => $font_name,
                'css' => $font_css,
                'url' => $font_url,
            );
        }

        $fonts = array(
            'body' => $body_fonts,
            'heading' => $heading_fonts
        );

        return $fonts;
    }

    public static function register ( $wp_customize ) {

        //====================================================
        //==== Color Options
        //====================================================

        /* Header Background Color */

        $wp_customize->add_setting( 'jc_core_header_background_color',
            array(
                'default'    => false,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_header_background_color',
                array(
                    'label'    => __('Header Background Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_header_background_color',
                    'priority' => 10,
                )
            )
        );

        /* Main Accent Color */

        $wp_customize->add_setting( 'jc_core_main_accent_color',
            array(
                'default'    => '#666666',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_main_accent_color',
                array(
                    'label'    => __('Main Accent Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_main_accent_color',
                    'priority' => 10,
                )
            )
        );

        /* Secondary Accent Color */

        $wp_customize->add_setting( 'jc_core_secondary_accent_color',
            array(
                'default'    => '#444444',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_secondary_accent_color',
                array(
                    'label'    => __('Secondary Accent Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_secondary_accent_color',
                    'priority' => 10,
                )
            )
        );

        /* Main Accent Text Color */

        $wp_customize->add_setting( 'jc_core_main_accent_textcolor',
            array(
                'default'    => '#ffffff',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_main_accent_textcolor',
                array(
                    'label'    => __('Main Accent Text Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_main_accent_textcolor',
                    'priority' => 10,
                )
            )
        );
        
        /* Secondary Accent Text Color */

        $wp_customize->add_setting( 'jc_core_secondary_accent_textcolor',
            array(
                'default'    => '#666',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_secondary_accent_textcolor',
                array(
                    'label'    => __('Secondary Accent Text Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_secondary_accent_textcolor',
                    'priority' => 10,
                )
            )
        );

        /* Home Main Background Color */

        $wp_customize->add_setting( 'jc_core_home_main_background_color',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_home_main_background_color',
                array(
                    'label'    => __('Homepage Main Background Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_home_main_background_color',
                    'priority' => 10,
                )
            )
        );

        /* Footer Background Color */

        $wp_customize->add_setting( 'jc_core_footer_background_color',
            array(
                'default'    => false,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_footer_background_color',
                array(
                    'label'    => __('Footer Background Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_footer_background_color',
                    'priority' => 10,
                )
            )
        );

        /* Footer Text Color */

        $wp_customize->add_setting( 'jc_core_footer_textcolor',
            array(
                'default'    => false,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'jc_core_footer_textcolor',
                array(
                    'label'    => __('Footer Text Color', 'jc_core_core'),
                    'section'  => 'colors',
                    'settings' => 'jc_core_footer_textcolor',
                    'priority' => 10,
                )
            )
        );



        //====================================================
        //===== Header
        //====================================================

        $wp_customize->add_section( 'jc_core-header',
            array(
                'title'       => __('Header', 'jc_core_core'),
                'priority'    => 35,
                'capability'  => 'edit_theme_options',
            )
        );

        $wp_customize->add_setting( 'jc_core_header_background_image',
            array(
                'default'    => false,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'jc_core_header_background_image',
                array(
                    'label'    => __('Header Background Image', 'jc_core_core'),
                    'section'  => 'jc_core-header',
                    'settings' => 'jc_core_header_background_image',
                    'priority' => 10,
                )
            )
        );
        
        //====================================================
        //==== Nav sizing ====
        //====================================================
        
        $header_menu_alignment_array = array(
            'left'  =>  'Left',
            'center'  =>  'Center',
            'right'  =>  'Right',
        );

        $wp_customize->add_setting( 'jc_core_header_menu_font_size' );

        $wp_customize->add_control(
            'jc_core_header_menu_font_size',
            array(
                'label'    => __('Header Menu Font Size (%)', 'jc_core_core'),
                'section'  => 'nav',
                'default'  => '110',
                'type'     => 'number',
                'priority' => 20,
            )
        );
        
        $wp_customize->add_setting( 'jc_core_header_menu_item_padding' );

        $wp_customize->add_control(
            'jc_core_header_menu_item_padding',
            array(
                'label'    => __('Header Menu Item Padding (px)', 'jc_core_core'),
                'section'  => 'nav',
                'default'  => '16',
                'type'     => 'number',
                'priority' => 20,
            )
        );
        
        $wp_customize->add_setting( 'jc_core_header_menu_alignment' );

        $wp_customize->add_control(
            'jc_core_header_menu_alignment',
            array(
                'type' => 'select',
                'label' => 'Header Menu Alignment',
                'section' => 'nav',
                'choices' => $header_menu_alignment_array,
                'default'  => 'left',
                'priority' => 22,
            )
        );
        

        /**
         * Site Options
         **/

        $wp_customize->add_section( 'jc-core-site-options',
            array(
                'title'       => __('Site Options', 'jc_core_core'),
                'priority'    => 35,
                'capability'  => 'edit_theme_options',
                'description' => 'Some general settings for around your site', 'jc_core_core',
            )
        );

        /* Site Name -- Can be accessed using [site-name] (defined in shortcodes.php) */

        $wp_customize->add_setting( 'jc_core_site_site_name',
            array(
                'default'           => 'Your Site Name',
                'sanitize_callback' => 'wp_strip_all_tags'
            )
        );

        $wp_customize->add_control(
            'jc_core_site_site_name',
            array(
                'label'    => __('Site Name', 'jc_core_core'),
                'section'  => 'jc_core-site-options',
                'type'     => 'text',
                'settings' => 'jc_core_site_site_name',
                'priority' => 10,
            )
        );
        
        /* Copyright Name -- Can be accessed using [copyright-name] (defined in shortcodes.php) */

        $wp_customize->add_setting( 'jc_core_site_copyright_name',
            array(
                'default'           => 'Your Copyright Name',
                'sanitize_callback' => 'wp_strip_all_tags'
            )
        );

        $wp_customize->add_control(
            'jc_core_site_copyright_name',
            array(
                'label'    => __('Copyright Name', 'jc_core_core'),
                'section'  => 'jc_core-site-options',
                'type'     => 'text',
                'settings' => 'jc_core_site_copyright_name',
                'priority' => 10,
            )
        );

        /* Site Logo -- Can be accessed using [site-logo] (defined in shortcodes.php) */

        $wp_customize->add_setting( 'jc_core_site_site_logo' );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'jc_core_site_site_logo',
                array(
                    'label' => 'Site Logo',
                    'section' => 'jc_core-site-options',
                    'settings' => 'jc_core_site_site_logo',
                    'priority' => 6,
                )
            )
        );
        
         /* Site Favicon */

        $wp_customize->add_setting( 'jc_core_site_favicon' );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'jc_core_site_favicon',
                array(
                    'label' => 'Site Favicon',
                    'section' => 'jc_core-site-options',
                    'settings' => 'jc_core_site_favicon',
                    'priority' => 8,
                )
            )
        );


        /**
         * Font Options
         **/

        $wp_customize->add_section( 'jc-core-font-options',
            array(
                'title'       => __('Font Options', 'jc_core_core'),
                'priority'    => 35,
                'capability'  => 'edit_theme_options',
                'description' => 'Fonts used on your site', 'jc_core_core',
            )
        );

        /* Font Picker (Holy Cow!) */

        $main_fonts_array = self::get_fonts_array();
        $body_fonts_array = $main_fonts_array['body'];
        $heading_fonts_array = $main_fonts_array['heading'];
        $body_font_picker_array = [];
        $heading_font_picker_array = [];

        foreach ($body_fonts_array as $slug => $font) {
            $body_font_picker_array[$slug] = $font['name'];
        }

        foreach ($heading_fonts_array as $slug => $font) {
            $heading_font_picker_array[$slug] = $font['name'];
        }

        $wp_customize->add_setting( 'jc_core_body_font' );

        $wp_customize->add_control(
            'jc_core_body_font',
            array(
                'type' => 'select',
                'label' => 'Body Font',
                'section' => 'jc_core-font-options',
                'choices' => $body_font_picker_array
            )
        );

        $wp_customize->add_setting( 'jc_core_heading_font' );

        $wp_customize->add_control(
            'jc_core_heading_font',
            array(
                'type' => 'select',
                'label' => 'Heading Font',
                'section' => 'jc_core-font-options',
                'choices' => $heading_font_picker_array
            )
        );

    }

    public static function header_output () {
        $fonts_array = self::get_fonts_array();
        $body_fonts_array = $fonts_array['body'];
        $heading_fonts_array = $fonts_array['heading'];
        $body_font_family_slug = ! empty( get_theme_mod('jc_core_body_font') ) ? get_theme_mod('jc_core_body_font') : 'arial';
        $heading_font_family_slug = ! empty( get_theme_mod('jc_core_heading_font') ) ? get_theme_mod('jc_core_heading_font') : 'arial';
        $widget_normal_height = ! empty( get_theme_mod('jc_core_normal_block_height') ) ? get_theme_mod('jc_core_normal_block_height') : 330;
        $widget_small_height = ! empty( get_theme_mod('jc_core_small_block_height') ) ? get_theme_mod('jc_core_small_block_height') : 200;
        $widget_tall_height = ! empty( get_theme_mod('jc_core_tall_block_height') ) ? get_theme_mod('jc_core_tall_block_height') : 440;

        if ( $body_fonts_array[$body_font_family_slug]['url'] ) {
            echo '<link href="' . $body_fonts_array[$body_font_family_slug]['url'] . '" rel="stylesheet" type="text/css" />'.PHP_EOL;
        }

        if ( $heading_fonts_array[$heading_font_family_slug]['url'] ) {
            echo '<link href="' . $heading_fonts_array[$heading_font_family_slug]['url'] . '" rel="stylesheet" type="text/css" />'.PHP_EOL;
        }

        $elements_array = $elements = [];

        /* Add elements (CSS selectors) to these arrays for use in the customizer CSS output below. */

        $elements_array['header'][] = 'header';
        $elements_array['header-color'][] = 'header';
        $elements_array['header-color'][] = 'header a';

        
        //==== THEME SPECIFIC ====
        //---- Order Form ----
        $elements_array['accent_bg'][] = '.jc_core-order-form .block > .block-title';
        
        //---- Memphis ----
        $elements_array['accent_bg'][] = '.jc_core-memphis .block > .block-title';

        //---- Portland ----
        $elements_array['secondary_accent_fg'][] = '.jc_core-portland .block > .block-title';

        $elements_array['accent_bg'][] = 'header nav';
        $elements_array['accent_bg'][] = 'header nav ul';
        $elements_array['accent_bg'][] = 'header nav li a';
        $elements_array['accent_bg'][] = 'header .nav-toggle';
        $elements_array['accent_bg'][] = 'form.search button, .button, a.button';
        $elements_array['accent_bg'][] = '.gform_wrapper input[type="submit"]';
        $elements_array['accent_bg'][] = '.pagination span';
        $elements_array['accent_bg'][] = '.accent-bg';

        $elements_array['secondary_accent_bg'][] = 'header nav li:hover > a';
        $elements_array['secondary_accent_bg'][] = 'header nav li.current-menu-item > a';
        $elements_array['secondary_accent_bg'][] = 'header nav li.current-menu-ancestor > a';
        $elements_array['secondary_accent_bg'][] = 'header .nav-toggle:hover';
        $elements_array['secondary_accent_bg'][] = 'form.search button:active';
        $elements_array['secondary_accent_bg'][] = '.button:hover, a.button:hover';
        $elements_array['secondary_accent_bg'][] = '.gform_wrapper input[type="submit"]:active';

        $elements_array['secondary_accent_fg'][] = 'nav ul.sibling-pages li.current_page_item > a';
        
        $elements_array['accent_border_bg'][] = '.block';
        $elements_array['accent_border_bg'][] = '.pagination a:hover, .pagination span';

        $elements_array['block_bg_color'][] = '.block';

        $elements_array['home_main_bg_color'][] = 'body.page-template-home main';

        $elements_array['accent_fg'][] = 'a';
        $elements_array['accent_fg'][] = '.accent-fg';

        $elements_array['block'][] = '.widget-height-normal > .block';
        $elements_array['block_short'][] = '.widget-height-short > .block';
        $elements_array['block_tall'][] = '.widget-height-tall > .block';

        $elements_array['banner'][] = '#banner';

        $elements_array['header_menu'][] = 'header nav';
        $elements_array['header_menu_item'][] = 'header nav li a';

        $elements_array['footer'][] = 'footer';

        foreach ($elements_array as $key => $value)
            $elements[$key] = implode(',', $elements_array[$key]);

        ?>
        <!--Customizer CSS-->
        <style type="text/css"><?php
            self::generate_css('body', 'background-image', 'jc_core_background_image', 'url(\'', '\')');
            echo 'body{font-family:'.$body_fonts_array[$body_font_family_slug]['css'].';}';
            echo $elements['heading-font'] . '{font-family:'.$heading_fonts_array[$heading_font_family_slug]['css'].';}';

            if (!empty(get_theme_mod('jc_core_header_background_image'))) {
                echo $elements['header'] . '{background-image: url("' . get_theme_mod('jc_core_header_background_image') . '");background-size:cover;background-position:center center;background-repeat:no-repeat;}';
            }

            self::generate_css($elements['header'], 'background-color', 'jc_core_header_background_color', '');
            echo $elements['header-color'] . '{color:' . self::getContrastYIQ(get_theme_mod('jc_core_header_background_color', '#FFFFFF')) . ';}';

            self::generate_css($elements['accent_bg'], 'background-color', 'jc_core_main_accent_color', '');
            self::generate_css($elements['accent_bg'], 'color', 'jc_core_main_accent_textcolor', '');
            
            self::generate_css($elements['secondary_accent_fg'], 'color', 'jc_core_secondary_accent_textcolor', ''); 

            self::generate_css($elements['secondary_accent_bg'], 'background-color', 'jc_core_secondary_accent_color', '');

            self::generate_css($elements['accent_border_bg'], 'border-color', 'jc_core_main_accent_color', '');

            self::generate_css($elements['block_bg_color'], 'background-color', 'jc_core_block_background_color', '');

            self::generate_css($elements['home_main_bg_color'], 'background-color', 'jc_core_home_main_background_color', '');

            self::generate_css($elements['banner'], 'height', 'jc_core_banner_height', '', 'px');

            self::generate_css($elements['header_menu'], 'font-size', 'jc_core_header_menu_font_size', '', '%');

            self::generate_css($elements['header_menu_item'], 'padding-left', 'jc_core_header_menu_item_padding', '', 'px');
            self::generate_css($elements['header_menu_item'], 'padding-right', 'jc_core_header_menu_item_padding', '', 'px');
            
            //--- Block height
            echo $elements['block'] . '{height:' . $widget_normal_height . 'px;}';
            echo $elements['block_short'] . '{height:' . $widget_small_height . 'px;}';
            echo $elements['block_tall'] . '{height:' . $widget_tall_height . 'px;}';

            self::generate_css($elements['accent_fg'], 'color', 'jc_core_main_accent_color', '');

            self::generate_css($elements['footer'], 'background-color', 'jc_core_footer_background_color', '');
            self::generate_css($elements['footer'], 'color', 'jc_core_footer_textcolor', '');
        ?></style>
        <!--/Customizer CSS-->
        <?php

    }



    public static function body_class ($classes) {

        /**
         * Add body class for rounded corners and nav alignment
         **/

        if ( get_theme_mod( 'jc_core_site_round_corners' ) == '1' ) {
            $classes[] = 'round-corners';
        }
        switch ( get_theme_mod( 'jc_core_header_menu_alignment' ) ) {
            case 'left':
                $classes[] = 'nav-alignleft';
                break;
            case 'center':
                $classes[] = 'nav-aligncenter';
                break;
            case 'right':
                $classes[] = 'nav-alignright';
                break;
        }
        $classes[] = sanitize_title( wp_get_theme()->name );
        return $classes;

    }



    public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
        $return = '';
        $mod = get_theme_mod($mod_name);
        if ( ! empty( $mod ) ) {
            $return = sprintf('%s{%s:%s;}',
                $selector,
                $style,
                $prefix.$mod.$postfix
            );
            if ( $echo ) {
                echo $return;
            }
        }
        return $return;
    }



    public static function getContrastYIQ($hexcolor) {
        if ( empty($hexcolor) ) {
            return '#444444';
        }
        $hexcolor = preg_replace(
            array(
                '/^#/',
                '/^([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/',
            ),
            array(
                '',
                '${1}${1}${2}${2}${3}${3}',
            ),
            $hexcolor
        );
        $r = hexdec(substr($hexcolor,0,2));
        $g = hexdec(substr($hexcolor,2,2));
        $b = hexdec(substr($hexcolor,4,2));
        $yiq = (($r*299)+($g*587)+($b*114))/1000;
        return ($yiq >= 128) ? '#444444' : 'white';
    }

}

add_action( 'customize_register' , array( 'jc_core_customize' , 'register' ) );
add_action( 'wp_head' , array( 'jc_core_customize' , 'header_output' ) );
add_filter( 'body_class' , array( 'jc_core_customize' , 'body_class' ) );
//add_action( 'customize_preview_init' , array( 'jc_core_customize' , 'live_preview' ) );
?>
