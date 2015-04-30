<?php
  //==== Create FSM Site Settings Page ====
  add_action('admin_menu', 'create_fsm_settings_page');
  
  function create_fsm_settings_page() {

	//---- Create Menu Item
	add_options_page('FSM Settings', __( 'FSM Settings' ), 'administrator', __FILE__, 'fsm_site_settings_page');
  
	//---- Register Settings
	add_action( 'admin_init', 'register_fsm_site_settings' );
	
  }
  
  //==== Declare Variables ====  
  $posts_with_template_options = array(
	'location',
	'department',
	'service',
	'brand',
	'product',
  );

  
  function register_fsm_site_settings() {
	global $posts_with_template_options;
	foreach ( $posts_with_template_options as $post_type ) {
		register_setting( 'site-settings', 'fsm_'.$post_type.'_template' );
	}
	register_setting( 'site-settings', 'fsm_site_notes' );
  }
  
  function fsm_site_settings_page() {

	//---- Includes

  
  ?>
  <div class="wrap">
	<h2>Custom Site Settings</h2>
	
	<form method="post" action="options.php" class="fsm_site_settings">
		
		<?php settings_fields( 'site-settings' ); ?>
		<?php do_settings_sections( 'site-settings' ); ?>
		
		<?php
		  
		  $templates = wp_get_theme()->get_page_templates();
		  unset( $templates['template-homepage.php'] );
		  
		?>
		
		<h3>
		  FSM Plugin Templates
		</h3>
		
		<?php
		
			global $posts_with_template_options;
			foreach ( $posts_with_template_options as $post_type ) :
			
				if ( post_type_exists( $post_type ) ) : ?>
				
				  <h4>
					<?php echo( ucwords( $post_type ) ) ?>s
				  </h4>
				  
				  <?php $option_name = 'fsm_'.$post_type.'_template'; ?>
				  
				  <select name="<?php echo $option_name ?>" value="<?php echo get_option( $option_name ) ?>">
					<option value="">Default</option>
					<?php
					  foreach( $templates as $template_filename => $template_name ){
						echo '<option value="'.$template_filename.'"';
						echo $template_filename == get_option( $option_name ) ? ' selected="selected">' : '>';
						echo $template_name;
						echo '</option>';
					  }
					?>
				  </select>			
			
				<?php endif; ?>
			  
			<?php endforeach; ?>
		
		<h3>
		  Notes
		</h3>
		<textarea class="" name="fsm_site_notes"><?php echo esc_textarea( get_option('fsm_site_notes') ); ?></textarea>
	
		<?php submit_button(); ?>

	</form>
  </div>
	<?php
} ?>