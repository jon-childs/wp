<?php

	//==============================================
	//==== FSM Custom Hooks ====
	//==============================================
	
	//---- Executes immediately after <body> tag is rendered
	function prepend_body() {
		do_action( 'prepend_body' );
	}
	
	function render_sibling_pages() {
		do_action( 'render_sibling_pages' );
	}

	//==============================================
	//==== FSM Custom WP Functions
	//==============================================

	//==== Enable all post types for WP_Query

	function fsm_enable_all_post_types( $query ) {
		if ( $query->is_main_query() && is_category() ) {
			$query->set( 'post_type', 'any' );
		}
	}
	add_action( 'pre_get_posts', 'fsm_enable_all_post_types' );
	
	//==== Pagination
	
	// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
	function fsm_pagination($wp_query) {
		$pagination_markup = '<div class="pagination '.$wp_query->query['post_type'].'">';
		$big = 999999999;
		$pagination_markup .= paginate_links(array(
			'base' => str_replace($big, '%#%', get_pagenum_link($big)),
			'format' => '?paged=%#%',
			'current' => max(1, get_query_var('paged')),
			'total' => $wp_query->max_num_pages,
			'type' => 'plain',
			'show_all' => true
		));
		$pagination_markup .= '</div>';
		return $pagination_markup;
	}


	
	//==== Add Favicon if present
	
	function fsm_add_site_favicon() {
		if ( get_theme_mod( 'fsm_site_favicon' ) !== "" ) {
			echo '<link rel="icon" type="image/png" href="' . get_theme_mod( 'fsm_site_favicon' ) . '" />'.PHP_EOL;
		}
	}
	add_action( 'wp_head', 'fsm_add_site_favicon');

	//==== Add fsm_site_css and fsm_head_includes options to <head>
	
	function fsm_insert_into_head(){
		$insert = get_option( 'fsm_head_includes' ).PHP_EOL;
		$insert .= '<style type="text/css">'.trim( preg_replace( '/\s\s+/', ' ', get_option( 'fsm_site_css' ) ) ).'</style>'.PHP_EOL;
		echo $insert;
	}
	add_action( 'wp_head', 'fsm_insert_into_head');
	
	
	//==== Include Facebook SDK ====
	function fsm_include_facebook_sdk(){
		echo '<!-- Facebook SDK -->'.PHP_EOL.'<div id="fb-root"></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=351976621665254"; fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));</script>';
	}

	if ( is_active_widget( false, false, 'fsm_facebook_widget', true ) ) {
		add_action( 'prepend_body', 'fsm_include_facebook_sdk' ); // --- reference inc/functions.php
	}
	
	//==== Allow for shortcodes in Excerpts
	function fsm_wp_trim_excerpt($text = '') {
		$raw_excerpt = $text;
		if ( '' == $text ) {
			$text = get_the_content('');

			$text = do_shortcode( $text ); // Include shortcode

			/** This filter is documented in wp-includes/post-template.php */
			$text = apply_filters( 'the_content', $text );
			$text = str_replace(']]>', ']]&gt;', $text);

			/**
			 * Filter the number of words in an excerpt.
			 *
			 * @since 2.7.0
			 *
			 * @param int $number The number of words. Default 55.
			 */
			$excerpt_length = apply_filters( 'excerpt_length', 55 );
			/**
			 * Filter the string in the "more" link displayed after a trimmed excerpt.
			 *
			 * @since 2.9.0
			 *
			 * @param string $more_string The string shown within the more link.
			 */
			$excerpt_more = apply_filters( 'excerpt_more', '&hellip;' );
			$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}
		/**
		 * Filter the trimmed excerpt string.
		 *
		 * @since 2.8.0
		 *
		 * @param string $text        The trimmed text.
		 * @param string $raw_excerpt The text prior to trimming.
		 */
		return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
	}
	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt');
	add_filter( 'get_the_excerpt', 'fsm_wp_trim_excerpt'  );


    /* Add selector to widget controls */
    function fsm_widget_width_in_widget_form($instance) {

        $settings = $instance->get_settings();

        if ( array_key_exists( $instance->number, $settings ) ) {
            $settings = $settings[$instance->number];
        }

        $widget_width = ( array_key_exists( 'widget_width', $settings ) ? $settings['widget_width'] : 4 );
        $widget_height = ( array_key_exists( 'widget_height', $settings ) ? $settings['widget_height'] : 'normal' );
        $widget_align = ( array_key_exists( 'widget_align', $settings ) ? $settings['widget_align'] : 'left' );

        ?>
        <h4>Widget Formatting Options</h4>
        <div class="fsm-widget-formatting-section">
            <p class="fsm-widget_width-selector">
                <label for="<?php echo $instance->get_field_id('widget_width'); ?>">Widget Width:</label>
                <select id="<?php echo $instance->get_field_id('widget_width'); ?>" name="<?php echo $instance->get_field_name( 'widget_width' ); ?>" class="widefat fsm-widget_width">
                <?php
                    for ( $i = 1; $i <= 12; $i++ ) {
                        echo '<option value="' . $i . '" class="width' . $i . '"', $widget_width == $i ? ' selected' : '', '>' . $i . '/12</option>';
                    }
                ?>
                </select>
            </p>
            <p class="fsm-widget_height-selector">
                <label for="<?php echo $instance->get_field_id('widget_height'); ?>">Widget Height:</label>
                <select id="<?php echo $instance->get_field_id('widget_height'); ?>" name="<?php echo $instance->get_field_name( 'widget_height' ); ?>" class="widefat fsm-widget_height">
                <?php
                    $widget_height_options = array( 'short', 'normal', 'tall' );
                    foreach ($widget_height_options as $value) {
                        echo '<option value="' . $value . '" class="height-' . $value . '"', $widget_height == $value ? ' selected' : '', '>' . ucfirst( $value ) . '</option>';
                    }
                ?>
                </select>
            </p>
            <p class="fsm-widget_align-selector">
                <label for="<?php echo $instance->get_field_id('widget_align'); ?>">Widget Text Alignment:</label>
                <select id="<?php echo $instance->get_field_id('widget_align'); ?>" name="<?php echo $instance->get_field_name( 'widget_align' ); ?>" class="widefat fsm-widget_align">
                <?php
                    $widget_align_options = array( 'left', 'center', 'right' );
                    foreach ($widget_align_options as $value) {
                        echo '<option value="' . $value . '" class="align-' . $value . '"', $widget_align == $value ? ' selected' : '', '>' . ucfirst( $value ) . '</option>';
                    }
                ?>
                </select>
            </p>
        </div>
        <?php
        return null;
    }
    add_action('in_widget_form', 'fsm_widget_width_in_widget_form');

    /* Handle updates */
    function fsm_widget_width_update_callback($instance, $new_instance, $old_instance) {
        $instance['widget_width'] = $new_instance['widget_width'];
        $instance['widget_height'] = $new_instance['widget_height'];
        $instance['widget_align'] = $new_instance['widget_align'];
        return $instance;
    }
    add_filter('widget_update_callback', 'fsm_widget_width_update_callback', 5, 3);

    /* Handle rendering */
    function fsm_widget_width_display_callback($instance, $widget, $args) {

        if ( $instance === false ) {
            return $instance;
        }

        $widget_classname = $widget->widget_options['classname'];
        $widget_width = ( array_key_exists( 'widget_width', $instance ) ? $instance['widget_width'] : 4 );
        $widget_height = ( array_key_exists( 'widget_height', $instance ) ? $instance['widget_height'] : 'normal' );
        $widget_align = ( array_key_exists( 'widget_align', $instance ) ? $instance['widget_align'] : 'left' );

        if ( $args['id'] === 'inner-sidebar' ) {
            $args['before_widget'] = str_replace($widget_classname, "{$widget_classname} col-md-12 col-sm-{$widget_width} widget-align{$widget_align}", $args['before_widget']);
        } else {
            $args['before_widget'] = str_replace($widget_classname, "{$widget_classname} col-md-{$widget_width} widget-align{$widget_align} widget-height-{$widget_height}", $args['before_widget']);
        }
        $widget->widget($args, $instance);
        return false;


    }
    add_filter('widget_display_callback', 'fsm_widget_width_display_callback', 999999, 3);

?>