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
            <div class="pillier">
                <h2><?php the_field( 'titre' ); ?></h2>
				<?php if ( have_rows( 'pillier_repeater' ) ) : ?>
                    <ul class="pillier-content">
						<?php while ( have_rows( 'pillier_repeater' ) ) : the_row(); ?>
                            <li>
                                Test
								<?php
								$juste_image = get_sub_field( 'juste_une_image' );
								if ( $juste_image === 'Non' ) :
                                    $image_pillier = get_sub_field('image') ?>
                                    <img src="<?= esc_url($image_pillier['url']); ?>" alt="<?= esc_attr
                                    ($image_pillier['alt']); ?>">
                                    <h4><?php the_sub_field('titre'); ?></h4>
                                    <p><?php the_sub_field('texte'); ?></p>
								<?php endif; ?>
                                <?php if( $juste_image === 'Oui' ) :
                                    $image = get_sub_field('image');
                                    ?>
                                    <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>">
                                <?php endif; ?>
                            </li>
						<?php endwhile; ?>
                    </ul>
				<?php endif; ?>
            </div>
        </section>

		<?php get_template_part( 'parts/left-part-page' ); ?>
    </div>
</section>

</main>
