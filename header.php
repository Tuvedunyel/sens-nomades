<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin=""></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open();
// Create a function who return a loop of li tags
function get_contact_menu() {
	$menu_items_first  = '';
	$menu_items_second = '';
	$menu_items_third  = '';
	$menu_items_fourth = '';
	$menu_items_last   = '';
	if ( have_rows( 'panier_compte_contact', 'option' ) ) :
		$menu_items_first = '<div class="header-infos"><nav class="commerce" id="commerce-links"><ul id="commerce-list">';

		while ( have_rows( 'panier_compte_contact', 'options' ) ) : the_row();
			$lien        = get_sub_field( 'lien' );
			$lien_url    = $lien['url'];
			$lien_title  = $lien['title'];
			$lien_target = $lien['target'];

			$image_commerce     = get_sub_field( 'image' );
			$image_commerce_url = $image_commerce['url'];
			$image_commerce_alt = $image_commerce['alt'];
			$image_deux         = get_sub_field( 'image_deux' );

			$radio = get_sub_field( 'deuxieme_image' );

			$menu_items_second = '<li class="pos"><a href="' . esc_url(
					$lien_url ) . '" target="' . esc_attr(
				                     $lien_target
			                     ) . '"title="' . esc_html( $lien_title ) . '"><img src="' . esc_url( $image_commerce_url ) . '" alt="' . esc_attr( $image_commerce_alt ) . '" class="commerce__img">';
			if ( $radio === 'Oui' ) :
				$menu_items_third = '<img src="' . esc_url( $image_deux['url'] ) . '"alt="' . esc_attr( $image_deux['alt'] ) . '" class="commercer__second-img">';
			endif;

			$menu_items_fourth = '</a></li>';
		endwhile;
		$menu_items_last = '</ul></nav></div>';
	endif;

	return $menu_items_first . $menu_items_second . $menu_items_third . $menu_items_fourth . $menu_items_last;
}

?>

<header>
    <div class="container">
		<?php $logo = get_field( 'logo', 'option' );
		$logo_url   = $logo['url'];
		$logo_alt   = $logo['alt'];

		$logo_mobile     = get_field( 'logo_mobile', 'option' );
		$logo_mobile_url = $logo_mobile['url'];
		$logo_mobile_alt = $logo_mobile['alt'];
		?>
        <a href="<?= home_url( $path = '/', $scheme = 'https' ); ?>" class="logo-link">
            <img src="<?= esc_url( $logo_url ) ?>" alt="<?= esc_attr( $logo_alt ) ?>" class="logo-desktop">
            <img src="<?= esc_url( $logo_mobile_url ); ?>" alt="<?= esc_attr( $logo_mobile_alt ); ?>"
                 class="logo-mobile">
        </a>
        <div class="main-menu__container">
			<?php wp_nav_menu( array(
				'theme_location' => 'main',
				'container'      => 'nav',
				'menu_id'        => 'main-menu',
				'fallback_cb'    => false,
				'items_wrap'     => '<div class="menu-btn" id="burger-btn">
                    <div class="menu-btn__burger">
                    </div>
                </div><ul id="%1$s" class="%2$s">%3$s<div class="form-button__container">
            </div>' . get_contact_menu() . '</ul>',
			) ); ?>
        </div>
		<?php if ( have_rows( 'panier_compte_contact', 'option' ) ) : ?>
            <div class="header-infos">
				<?php wp_nav_menu( array(
					'theme_location' => 'icon-menu',
					'container'      => 'nav',
                    'container_id'   => 'commerce-links',
                    'container_class'   => 'commerce',
					'menu_id'        => 'commerce-list',
                    'menu_class'    => 'commerce-list',
					'fallback_cb'    => false,
				) ); ?>
<!--                <nav class="commerce" id="commerce-links">-->
<!--                    <ul id="commerce-list">-->
<!--						--><?php //while ( have_rows( 'panier_compte_contact', 'option' ) ) : the_row();
//							$lien        = get_sub_field( 'lien' );
//							$lien_url    = $lien['url'];
//							$lien_title  = $lien['title'];
//							$lien_target = $lien['target'];
//
//							$image_commerce     = get_sub_field( 'image' );
//							$image_commerce_url = $image_commerce['url'];
//							$image_commerce_alt = $image_commerce['alt'];
//							$image_deux         = get_sub_field( 'image_deux' );
//
//							$radio = get_sub_field( 'deuxieme_image' );
//							?>
<!--                            <li class="--><?//= $radio === 'Oui' ? 'pos' : '' ?><!--">-->
<!--                                <a href="--><?//= esc_url( $lien_url ) ?><!--" target="--><?//= esc_attr( $lien_target ); ?><!--"-->
<!--                                   title="--><?//= esc_html( $lien_title ); ?><!--">-->
<!--                                    <img src="--><?//= esc_url( $image_commerce_url ); ?><!--" alt="--><?//= esc_attr
//									( $image_commerce_alt ); ?><!--" class="commerce__img">-->
<!--									--><?php //if ( $radio === 'Oui' ) : ?>
<!--                                        <img src="--><?//= esc_url( $image_deux['url'] ); ?><!--"-->
<!--                                             alt="--><?//= esc_attr( $image_deux['alt'] );
//										     ?><!--" class="commercer__second-img">-->
<!--									--><?php //endif; ?>
<!--                                </a>-->
<!--                            </li>-->
<!--						--><?php //endwhile; ?>
<!--                    </ul>-->
<!--                </nav>-->
            </div>
		<?php endif; ?>
    </div>
</header>
