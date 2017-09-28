<?php
function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
    wp_enqueue_script( 'tainacan_child_js', get_template_directory_uri() . '-child/assets/js/script.js', '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function tainacan_child_script(){
    $parent_style = 'parent-style';
    wp_enqueue_script( 'tainacan_child_js', get_template_directory_uri() . '/assets/js/script.js', array( $parent_style ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'tainacan_child_script' );