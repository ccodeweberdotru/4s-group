<?php
/**
 * 4s-group functions and definitions
 *
 * @package 4s-group
 */

add_action( 'wp_enqueue_scripts', 'four_s_group_enqueue_styles' );
function four_s_group_enqueue_styles() {
    wp_enqueue_style(
        'four-s-group-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'codeweber-style' ),
        wp_get_theme()->get( 'Version' )
    );
}
