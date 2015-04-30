<?php
  //==== Create FSM Site Styling Page ====
  add_action('admin_menu', 'create_fsm_styling_page');
  
  function create_fsm_styling_page() {

	//---- Create Menu Item
	add_theme_page('Custom CSS', __( 'Custom CSS' ), 'administrator', __FILE__, 'fsm_site_styling_page');
  
	//---- Register Settings
	add_action( 'admin_init', 'register_fsm_site_styling' );
	
  }
  
  function register_fsm_site_styling() {
	  register_setting( 'site-styling', 'fsm_site_css' );
	  register_setting( 'site-styling', 'fsm_head_includes' );
  }
  
  function fsm_site_styling_page() {

	//---- Includes
  	wp_enqueue_script( 'ace_js', '//cdnjs.cloudflare.com/ajax/libs/ace/1.1.9/ace.js', '', '2015.04.10', true );
	wp_enqueue_script( 'custom_css_js', get_template_directory_uri().'/views/site-css/js/custom-css.js', array( 'jquery', 'ace_js' ), '2015.04.10', true );

  
  ?>
  <style type="text/css">
	code.examples{
		display: block;
		padding: 0.5em;
		margin-bottom: 1em;
	}
	textarea.fsm_site_css,
	textarea.fsm_head_includes{
		display: none;
	}
	#fsm_site_css{
		height: 300px;
	}
	#fsm_head_includes{
		height: 120px;
	}
  </style>
  <div class="wrap">
	<h2>Custom Site Styling</h2>
	
	<form method="post" action="options.php" class="fsm_site_styling">
		<?php settings_fields( 'site-styling' ); ?>
		<?php do_settings_sections( 'site-styling' ); ?>
		<h3>
			&lt;head&gt; Includes
		</h3>
		<div id="fsm_head_includes"></div>
		<textarea class="fsm_head_includes" name="fsm_head_includes"><?php echo esc_textarea( get_option('fsm_head_includes') ) ?></textarea>
		<h3>
			CSS
		</h3>
		<div id="fsm_site_css"></div>
		<textarea class="fsm_site_css" name="fsm_site_css"><?php echo esc_textarea( get_option('fsm_site_css') ); ?></textarea>

		<?php submit_button(); ?>

		Responsive CSS Breakpoints
		<code class="examples">
			@media (max-width: 1199px){ } /*lg*/
			<br />
			@media (max-width: 991px){ } /*md*/
			<br />
			@media (max-width: 767px){ } /*sm*/
		</code>
		
	
	</form>
  </div>
	<?php
} ?>