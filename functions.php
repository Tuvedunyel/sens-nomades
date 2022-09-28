<?php

add_theme_support('post-thumbnails');
add_theme_support('title-tag');

function sensnomades_add_woocommerce_support () {
	add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'sensnomades_add_woocommerce_support');

function btg_register_assets()
{
    wp_enqueue_style('btg-style', get_template_directory_uri() . '/css/style.css', 1.0);
	wp_enqueue_script('axios', 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js', array(), 1.0);
	wp_enqueue_script('vue', 'https://unpkg.com/vue@3', array(), 1.0);
    wp_enqueue_script('btg-script', get_template_directory_uri() . '/js/script.js', array(), 1.0, true);
}

register_nav_menus( array(
    'main' => 'Menu principal',
	'icon-menu' => 'Menu d\'icônes',
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

// Remove contact Form 7 auto p
add_filter('wpcf7_autop_or_not', '__return_false');

add_filter( 'wp_nav_menu_objects', 'btg_wp_nav_menu_objects', 10, 2 );

function btg_wp_nav_menu_objects( $items, $args ) {
	// loop
	foreach( $items as &$item ) {
		// vars
		$icon = get_field('image', $item);
		// append icon
		if( $icon ) {
			$item->title = '<span class="screen-reader-text">' . $item->title . '</span><img src="' . $icon . '" alt="' . $item->title . '" />';
		}
	}
	// return
	return $items;
}