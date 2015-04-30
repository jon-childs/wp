<?php

//=====================================
//==== FSM Widget Definitions
//=====================================

//==== Logo Widget

class fsm_logo_widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct(
            'fsm_logo_widget', // Base ID
            __( 'Company Logo', 'fsm_core' ), // Name
            array( 'description' => __( 'Displays your company\'s logo, set from the theme customizer.', 'fsm_core' ), ) // Args
        );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo do_shortcode('<a href="'.get_site_url().'">[company-logo]</a>');
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        echo "<p><em>Your company's logo (as set in the Theme Customizer's \"Site Settings\" tab)</em></p>";
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
    }
}

add_action( 'widgets_init', function () {
    register_widget( 'fsm_logo_widget' );
});

//==== Facebook Widget

class fsm_facebook_widget extends WP_Widget {

    //==== Sets up the widget's name, etc.
	
    public function __construct() {
        parent::__construct(
            'fsm_facebook_widget', // Base ID
            __( 'Facebook Block', 'fsm_core' ), // Name
            array( 'description' => __( 'Promote a Facebook Page, with options to include posts and more.', 'fsm_core' ), ) // Args
        );
    }
    
    public function fields( $instance ){
        //---- Define fields
        $fields['title'] = array_key_exists( 'title', $instance ) ? $instance['title'] : __( 'Updates', 'fsm_core' );
        $fields['url'] = ! empty( $instance['url'] ) ? $instance['url'] : '';
        $fields['posts'] = ! empty( $instance['posts'] ) ? $instance['posts'] : 'true';
        $fields['cover'] = ! empty( $instance['cover'] ) ? $instance['cover'] : 'false';
        $fields['faces'] = ! empty( $instance['faces'] ) ? $instance['faces'] : 'false';
        $fields['width'] = ! empty( $instance['width'] ) ? $instance['width'] : '';
        $fields['height'] = ! empty( $instance['height'] ) ? $instance['height'] : '';
        return $fields;
    }
	
    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        
        $fields = $this->fields( $instance );
        
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $fields['title'] ). $args['after_title'];
        }

        if ( ! empty( $fields['url'] ) ) {
			echo '<div class="fb-page" data-href="'.$fields['url'].'" data-width="'.$fields['width'].'" data-height="'.$fields['height'].'" data-hide-cover="'.$fields['cover'].'" data-show-facepile="'.$fields['faces'].'" data-show-posts="'.$fields['posts'].'"><div class="fb-xfbml-parse-ignore"></div></div>';
			
        }
		
        echo $args['after_widget'];

    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        
        $fields = $this->fields( $instance );
        
        ?>
        <div class="fsm-location-widget-settings">
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $fields['title'] ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Facebook Page URL:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $fields['url'] ); ?>">
            </p>
            <p class="fsm-location-format-selector">
                <label for="<?php echo $this->get_field_id( 'format' ); ?>"><?php _e( 'Format:' ); ?></label>
                <br />
                <input type="checkbox" class="posts" name="<?php echo $this->get_field_name( 'posts' ); ?>" <?php echo $fields['posts'] == 'true' ? 'checked' : '' ?> /> Show Page Posts
                <br />
                <input type="checkbox" class="cover" name="<?php echo $this->get_field_name( 'cover' ); ?>" <?php echo $fields['cover'] == 'true' ? 'checked' : '' ?> /> Hide Cover Photo
                <br />
                <input type="checkbox" class="faces" name="<?php echo $this->get_field_name( 'faces' ); ?>" <?php echo $fields['faces'] == 'true' ? 'checked' : '' ?> /> Show Friend's Faces
                <br />
                <input type="number" class="width" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $fields['width'] ?>" placeholder="min 280, max 500" /> Width (px)
                <br />
                <input type="number" class="height" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $fields['height'] ?>" placeholder="min 130" /> Height (px)
            </p>
        </div>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? $new_instance['url'] : '';
        $instance['faces'] = ( ! empty( $new_instance['faces'] ) ) ? 'true' : 'false';
        $instance['cover'] = ( ! empty( $new_instance['cover'] ) ) ? 'true' : 'false';
        $instance['posts'] = ( ! empty( $new_instance['posts'] ) ) ? 'true' : 'false';
        $instance['width'] = ( ! empty( $new_instance['width'] ) ) ? $new_instance['width'] : '280';
        $instance['height'] = ( ! empty( $new_instance['height'] ) ) ? $new_instance['height'] : '130';
        return $instance;
    }

}

function fsm_social_register_widgets() {
    register_widget( 'fsm_facebook_widget' );
}

add_action( 'widgets_init', 'fsm_social_register_widgets' );

//=====================================
//==== REGISTER WIDGET AREAS ====
//=====================================

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Header Widget Area
    register_sidebar(array(
        'name' => __('Header', 'fsm_core'),
        'description' => __('Header content', 'fsm_core'),
        'id' => 'header',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>'
    ));

    // Define Footer Widget Area
    register_sidebar(array(
        'name' => __('Footer', 'fsm_core'),
        'description' => __('Footer Content', 'fsm_core'),
        'id' => 'footer',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
    ));

	//======== NOTICE ========
	//==== If Themes 'Memphis' or 'Portland' are being used, include 'Home Page Banner, Home Page Blocks, Above Footer' widget areas
	$themes_with_homepage = array( 'FSM Memphis', 'FSM Portland' );
	if ( in_array( wp_get_theme(), $themes_with_homepage ) ) {
		
		// Define Home Page Banner Widget Area
		register_sidebar(array(
			'name' => __('Home Page Banner', 'fsm_core'),
			'description' => __('Area below the Header Menu', 'fsm_core'),
			'id' => 'homepage-banner',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		));
	
		// Define Home Page Blocks Widget Area
		register_sidebar(array(
			'name' => __('Home Page Blocks', 'fsm_core'),
			'description' => __('Blocks to be displayed on the Home Page', 'fsm_core'),
			'id' => 'homepage-block',
			'before_widget' => '<div id="%1$s" class="%2$s block-container"><div class="block">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="block-title">',
			'after_title' => '</h3>',
		));
		
		// Define Home Page Above Footer Widget Area
		register_sidebar(array(
			'name' => __('Above Footer', 'fsm_core'),
			'description' => __('Area above the Footer on the Home Page', 'fsm_core'),
			'id' => 'above-footer',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		));

	}

	//======== NOTICE ========
	//==== If Templates 'Left Sidebar' or 'Right Sidebar' exist, include 'Inner Sidebar' widget area
	$templates = wp_get_theme()->get_page_templates();
	if ( in_array( 'Left Sidebar', $templates ) || in_array( 'Right Sidebar', $templates ) ) {
		// Define Inner Sidebar Widget Area
		register_sidebar(array(
			'name' => __('Inner Sidebar', 'fsm_core'),
			'description' => __('Inner Page Sidebar', 'fsm_core'),
			'id' => 'inner-sidebar',
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		));
	}


}


?>