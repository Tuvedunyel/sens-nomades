<?php

add_theme_support('post-thumbnails');
add_theme_support('title-tag');

function btg_register_assets()
{
    wp_enqueue_style('btg-style', get_template_directory_uri() . '/css/style.css', 1.0);
	wp_enqueue_script('axios', 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js', array(), 1.0);
	wp_enqueue_script('vue', 'https://unpkg.com/vue@3', array(), 1.0);
    wp_enqueue_script('btg-script', get_template_directory_uri() . '/js/script.js', array(), 1.0, true);
}

register_nav_menus( array(
    'main' => 'Menu principal',
    'footer-main' => 'Menu bas de page',
	'legals' => 'Menu mentions légales'
) );

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );

add_action('wp_enqueue_scripts', 'btg_register_assets');

if (function_exists('acf_add_options_page')) {
    acf_add_options_page( array(
        'page_title' => 'Options générales',
        'menu_title' => 'Options générales',
        'menu_slug' => 'options-generales',
        'capability' => 'edit_posts',
        'redirect' => false,
        'position' => '2'
    ) );
}