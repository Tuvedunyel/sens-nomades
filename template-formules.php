<?php
/*
 * Template Name: Formules
 */
get_template_part( 'parts/hero-wave' );
?>

<section id="formule">
    <div class="container-narrow pages-container">
        <article class="content">
			<?php the_content(); ?>

			<?php if ( have_rows( 'formules' ) ) : ?>
                <section class="formules__container">
					<?php while ( have_rows( 'formules' ) ) : the_row();
						$image   = get_sub_field( 'image' );
						$icone   = get_sub_field( 'icones' );
						$couleur = get_sub_field( 'couleur' );
						?>
                        <div class="<?= $couleur === 'Sable' ? 'sable' : 'bleu_glacie' ?> formule-unit">
                            <div class="formule-unit__image">
                                <a href="<?php the_field('lien_page_voyages'); ?>?<?php the_sub_field('titre');
                                ?>">
                                    <img src="<?= esc_url( $image['url'] ); ?>" alt="<?= esc_attr( $image['alt'] ); ?>">
                                </a>
                            </div>
                            <div class="formule-unit__content">
                                <div class="icone-formule">
                                    <img src="<?= esc_url( $icone['url'] ); ?>" alt="<?= esc_attr( $icone['alt'] ); ?>">
                                </div>
                                <h3><?php the_sub_field( 'titre' ); ?></h3>
                                <strong>
									<?php the_sub_field( 'sous_titre' ); ?>
                                    <div class="tri-open">
                                        <a href="<?php the_field( 'lien_page_voyages' ); ?>?<?php the_sub_field( 'titre' ) ?>">
											<?php if ( $couleur === 'Sable' ) : ?>
                                                <img src="<?= get_template_directory_uri() ?>/assets/open.svg" alt="Se
                                            rendre sur la page des voyages">
											<?php else : ?>
                                                <img src="<?= get_template_directory_uri() ?>/assets/open-sable.svg"
                                                     alt="Se rendre sur la page des voyages">
											<?php endif; ?>
                                        </a>
                                    </div>
                                </strong>
                            </div>
                        </div>
					<?php endwhile; ?>
                </section>
			<?php endif; ?>
            <section class="bottom-formule">
				<?php $lien_privatiser = get_field( 'bouton' ); ?>
                <a href="<?= esc_url( $lien_privatiser['url'] ); ?>" class="lien__privatiser"><?= esc_html
					( $lien_privatiser['title'] ); ?></a>
                <div class="bottom-formule__randonneur">
                    <img src="<?= get_template_directory_uri() ?>/assets/randonneur-black.svg" alt="Petit randonneur">
                    <div class="moon-flower randonneur-formule"><?php the_field( 'texte_randonneur' ); ?></div>
                    <img src="<?= get_template_directory_uri() ?>/assets/fleche.svg" alt="Flèche pointant vers le haut">
                </div>
                <strong class="coliving"><?php the_field( 'coliving_texte' ); ?></strong>
				<?php $coliving = get_field( 'coliving' ); ?>
                <a href="<?= esc_url( $coliving['url'] ); ?>" class="coliving-btn"><?= esc_html( $coliving['title'] );
					?></a>
            </section>
        </article>
		<?php get_template_part( 'parts/left-part-page' ); ?>
    </div>
</section>
</main>

<?php get_footer(); ?>
