<?php
/*
 * Template Name: Contact
 */
get_template_part( 'parts/hero-wave' );
?>

<section class="contact">
    <div class="container-narrow">
        <div class="contact-content">
            <div class="contact-wrapper">
				<?php the_content(); ?>
            </div>
        </div>
        <aside class="coord">
			<?php $logo = get_field( 'logo', 'option' ); ?>
            <img src="<?= esc_url( $logo['url'] ); ?>" alt="<?= esc_attr( $logo['alt'] ); ?>">
            <address>
                <p><?php the_field( 'adresse' ); ?></p>
                <div>
					<?php the_field( 'horaires' ); ?>
                </div>
            </address>
			<?php $image = get_field( 'image' ); ?>
            <img src="<?= esc_url( $image['url'] ); ?>" alt="<?= esc_attr( $image['alt'] ); ?>" class="address-img">
        </aside>
    </div>
</section>

</main>

<?php get_footer(); ?>
