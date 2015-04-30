<?php
//==== jc Core Shortcodes

/**
 * [site-name]
 * Prints site name from theme customizer
 **/
function fsm_shortcode_site_name($atts) {
    return '<span class="site-name">' . get_theme_mod( 'fsm_site_site_name', 'Your Site Name Here') . '</span>';
}
add_shortcode( 'site-name', 'fsm_shortcode_site_name');

/**
 * [copyright-name]
 * Prints copyright name from theme customizer
 **/
function fsm_shortcode_copyright_name($atts) {
    return '<span class="copyright-name">' . get_theme_mod( 'fsm_site_copyright_name', 'Your Copyright Name Here') . '</span>';
}
add_shortcode( 'copyright-name', 'fsm_shortcode_copyright_name');

/**
 * [site-logo]
 * Prints site logo from theme customizer
 **/
function fsm_shortcode_site_logo($atts) {
    if ( get_theme_mod( 'fsm_site_site_logo' ) !== "" ) {
        return '<img src="' . get_theme_mod( 'fsm_site_site_logo' ) . '" alt="' . get_theme_mod( 'fsm_site_site_name', 'Your Site Name Here') . '" class="logo" />';
    } else {
        return '<img src="' . get_template_directory_uri() . '/img/logo-dark.png' . '" alt="' . get_theme_mod( 'fsm_site_site_name', 'Your Site Name Here') . '" class="logo" />';
    }
}
add_shortcode( 'site-logo', 'fsm_shortcode_site_logo');

/**
 * [list-sibling-pages]
 * Renders a list of sibling pages of the current page, as determined by page 'Parent' attribute
 **/
function fsm_list_sibling_pages(){
    $siblings = wp_list_pages( array(
        'echo'  => false,
        'title_li'	=> '',
        'depth'	=> 1,
        'sort_column' => 'menu_order',
        'child_of'	=> wp_get_post_parent_id( get_the_ID() ),
    ) );
    return '<nav><ul class="sibling-pages">'.$siblings.'</ul></nav>';
}
add_shortcode( 'list-sibling-pages', 'fsm_list_sibling_pages');

?>
