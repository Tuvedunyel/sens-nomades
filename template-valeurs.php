<?php
/*
 * Template Name: Valeurs
 */
get_header();
get_template_part( 'parts/hero-wave' );
?>

<section class="pages">
    <div class="container-narrow pages-container">
        <section class="content">
            <article>
				<?php the_content(); ?>
            </article>
            <div class="pilier">
				<?php if ( get_field( 'titre' ) ) : ?>
                    <h2><?php the_field( 'titre' ); ?></h2>
				<?php endif; ?>
				<?php if ( have_rows( 'pillier_repeater' ) ) : ?>
                    <ul class="pilier-content">
						<?php while ( have_rows( 'pillier_repeater' ) ) : the_row(); ?>
							<?php $juste_image = get_sub_field( 'juste_une_image' ); ?>
                            <li class="<?= $juste_image === 'Oui' ? 'no-border' : 'border' ?>">
								<?php
								if ( $juste_image === 'Non' ) :
									$image_pillier = get_sub_field( 'image_pillier' ) ?>
                                    <img src="<?= esc_url( $image_pillier['url'] ); ?>" alt="<?= esc_attr
									( $image_pillier['alt'] ); ?>" class="picto-pilier">
                                    <h4><?php the_sub_field( 'titre' ); ?></h4>
                                    <p><?php the_sub_field( 'texte' ); ?></p>
								<?php endif; ?>
								<?php if ( $juste_image === 'Oui' ) :
									$image = get_sub_field( 'image' );
									?>
                                    <img src="<?= esc_url( $image['url'] ); ?>" alt="<?= esc_attr( $image['alt'] ); ?>">
								<?php endif; ?>
                            </li>
						<?php endwhile; ?>
                    </ul>
				<?php endif; ?>
            </div>
            <div class="bottom-valeurs">
				<?php if ( get_field( 'zone_de_texte' ) ) : ?>
                    <div class="text-area">
						<?php the_field( 'zone_de_texte' ); ?>
                    </div>
				<?php endif; ?>
                <div class="badges">
					<?php if ( get_field( 'badge' ) ) :
						$badge_img = get_field( 'badge' ); ?>
                        <img src="<?= esc_url( $badge_img['url'] ) ?>" alt="<?= esc_attr( $badge_img['alt'] ); ?>">
					<?php endif; ?>
                    <strong><?php the_field( 'legende' ); ?></strong>
                </div>
				<?php if ( get_field( 'panneau' ) ) :
					$sign_img = get_field( 'panneau' ); ?>
                    <img src="<?= esc_url( $sign_img['url'] ) ?>" alt="<?= esc_attr( $sign_img['alt'] ); ?>">
				<?php endif; ?>
				<?php $button = get_field( 'button' ); ?>
                <a href="<?= esc_url( $button['url'] ); ?>"
                   target="<?= esc_attr( $button['target'] ); ?>"><?= esc_html( $button['title'] ); ?></a>
            </div>
        </section>

		<?php get_template_part( 'parts/left-part-page' ); ?>
    </div>
</section>

</main>
<?php get_footer(); ?>
