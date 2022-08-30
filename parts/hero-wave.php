<?php get_header(); ?>

<section class="hero-wave-banner">
    <div class="wave"></div>
    <div class="container-narrow">
        <?php $rose_vents = get_field('rose_des_vents');
            if ( $rose_vents === "Oui" ) :
                $image_rose_vents = get_field( 'image_rose_des_vents' ); ?>
                <img src="<?= esc_url($image_rose_vents['url']); ?>" alt="<?= esc_attr($image_rose_vents['alt']); ?>"
                     class="rose-vents">
            <?php endif; ?>
        <div class="rose-vents"></div>
        <h1><?php the_title(); ?></h1>
		<?php $image_haut_page = get_field( 'image_haut_de_page' ); ?>
        <img src="<?= esc_url( $image_haut_page['url'] ); ?>" alt="<?= esc_attr( $image_haut_page['alt'] ); ?>"
             class="image-hero">
        <h2><?php the_field('titre_haut_de_page'); ?></h2>
        <p><?php the_field('texte_haut_de_page'); ?></p>
    </div>
</section>
