<?php
/*
  * Template Name: Coaches
  */
get_header(); ?>

<main class="coachs-list">
    <div class="container-narrow">
        <section class="upper-banner">
            <div class="randonneur-container">
                <img src="<?= get_template_directory_uri(); ?>/assets/randonneur-black.svg" alt="Randonneur">
                <p class="moon-flower"><?php the_field( 'texte_randonneur' ); ?></p>
                <img src="<?= get_template_directory_uri() ?>/assets/fleche.svg" alt="Fleche pointant vers le bas"
                     class="arrow-bot">
            </div>
            <h1><?php the_title(); ?></h1>
        </section>
        <section class="coachs-list__container">
            <div class="coachs-list__container-inter">
				<?php if ( have_rows( 'coachs' ) ) :
					while ( have_rows( 'coachs' ) ) : the_row();
						$coachs_image = get_sub_field( 'coachs_image' );
						?>
                        <article class="coachs">
                            <img src="<?= esc_url( $coachs_image['url'] ); ?>"
                                 alt="<?= esc_attr( $coachs_image['alt'] );
							     ?>">
                            <h2><?php the_sub_field( 'coachs_name' ); ?></h2>
                            <p><?php the_sub_field( 'coachs_description_courte' ); ?></p>
                            <div class="long-description">
                                <div class="coach-border"></div>
                                <div class="close coachs-btn">
                                    <img src="<?= get_template_directory_uri(); ?>/assets/close-roche.svg"
                                         alt="Fermer la
                                    description">
                                </div>
                                <h3><?php the_sub_field( 'coachs_name' ) ?>
                                    <span> - <?php the_sub_field( 'coachs_description_courte' ) ?></span></h3>
                                <div class="description">
									<?php the_sub_field( 'description' ); ?>
                                </div>
                                <div class="lien">
									<?php $lien_portrait = get_sub_field( 'lien_portrait' );
									$lien_sejour         = get_sub_field( 'lien_sejour' );
									if ( $lien_sejour ) :
										?>
                                        <a href="<?= esc_url( $lien_sejour['url'] ) ?>"><?= esc_html( $lien_sejour['title'] )
											?></a>
									<?php endif; ?>
                                    <a href="<?= esc_url( $lien_portrait['url'] ); ?>"><?= esc_html( $lien_portrait['title'] );
										?></a>
                                </div>
                            </div>
                        </article>

					<?php endwhile; endif; ?>
            </div>
        </section>
		<?php $lien_boutique = get_field( 'lien_boutique' ) ?>
        <a href="<?= esc_url( $lien_boutique['url'] ); ?>" class="btn"><?= esc_html( $lien_boutique['title'] ); ?></a>
    </div>
</main>

<?php get_footer(); ?>
