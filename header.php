<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header>
    <div class="container">
		<?php $logo = get_field( 'logo', 'option' );
		$logo_url   = $logo['url'];
		$logo_alt   = $logo['alt'];
		?>
        <a href="<?= home_url( $path = '/', $scheme = 'https' ); ?>">
            <img src="<?= esc_url( $logo_url ) ?>" alt="<?= esc_attr( $logo_alt ) ?>">
        </a>
        <div class="main-menu__container">
			<?php wp_nav_menu( array(
				'theme_location' => 'main',
				'container'      => 'nav',
				'menu_id'        => 'main-menu',
				'fallback_cb'    => false,
				'items_wrap'     => '<div class="menu-btn">
                    <div class="menu-btn__burger" id="burget-btn">
                    </div>
                </div><ul id="%1$s" class="%2$s">%3$s<div class="form-button__container">
            </div></ul>',
			) ); ?>
        </div>
		<?php if ( have_rows( 'panier_compte_contact', 'option' ) ) : ?>
            <div class="header-infos">
                <button class="show__commerce-menu" id="show-commerce">
                    <span id="arrow">
                        &#10096;
                    </span>
                    <span class="screen-reader-text">
                        <?php _e( 'Ouvrir le menu', 'wp-commerce' ); ?>
                    </span>
                </button>
                <nav class="commerce" id="commerce-links">
                    <ul id="commerce-list">
                        <?php while( have_rows('panier_compte_contact', 'option') ) : the_row();
                            $lien = get_sub_field('lien');
                            $lien_url = $lien['url'];
                            $lien_title = $lien['title'];
                            $lien_target = $lien['target'];

                            $image_commerce = get_sub_field('image');
                            $image_commerce_url = $image_commerce['url'];
                            $image_commerce_alt = $image_commerce['alt'];
                            $image_deux = get_sub_field('image_deux');

                            $radio = get_sub_field('deuxieme_image');
                        ?>
                            <li class="<?= $radio === 'Oui' ? 'pos' : '' ?>">
                                <a href="<?= esc_url($lien_url) ?>" target="<?= esc_attr($lien_target); ?>"
                                   title="<?= esc_html($lien_title); ?>" >
                                    <img src="<?= esc_url($image_commerce_url); ?>" alt="<?= esc_attr
                                    ($image_commerce_alt); ?>" class="commerce__img">
                                    <?php if( $radio === 'Oui' ) : ?>
                                        <img src="<?= esc_url($image_deux['url']); ?>" alt="<?= esc_attr($image_deux['alt']);
                                        ?>" class="commercer__second-img">
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </nav>
            </div>
		<?php endif; ?>
    </div>
</header>
