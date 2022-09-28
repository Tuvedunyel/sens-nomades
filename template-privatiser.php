<?php
/*
 * Template Name: Privatiser
 */
get_header(); ?>

<main class="private" id="root">
    <div class="container-narrow">
        <h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
    </div>

    <article class="road">
        <div class="container-narrow">
            <h3><?php the_field( 'titre_partie_sable' ); ?></h3>
			<?php if ( have_rows( 'raisons' ) ) : ?>
                <div class="raisons">
					<?php while ( have_rows( 'raisons' ) ) : the_row();
						$pictogramme  = get_sub_field( 'pictogramme' );
						$image_chemin = get_sub_field( 'image_chemin' );
						?>
                        <div class="raison">
                            <div class="circle">
                                <img src="<?= esc_url( $pictogramme['url'] ) ?>"
                                     alt="<?= esc_attr( $pictogramme['alt'] );
								     ?>">
                            </div>
                            <p><?php the_sub_field( 'texte' ); ?></p>
							<?php if ( $image_chemin ) : ?>
                                <img src="<?= esc_url( $image_chemin['url'] ); ?>" alt="<?= esc_attr
								( $image_chemin['alt'] ); ?>" class="chemin">
							<?php endif; ?>
                        </div>
					<?php endwhile; ?>
                </div>
			<?php endif; ?>
        </div>
    </article>
    <section class="choose">
        <div class="container-narrow">
            <h2 :class="particulier || entreprise ? 'terracota' : ''"><?php the_field( 'titre_vous_etes' ); ?></h2>
			<?php if ( have_rows( 'boutons' ) ) : ?>
                <div class="button-container">
					<?php while ( have_rows( 'boutons' ) ) : the_row(); ?>
                        <button class="choose__btn" @click="toggleForm($event)"><?php the_sub_field( 'texte' );
                        ?></button>
					<?php endwhile; ?>
                </div>
			<?php endif; ?>

            <div class="particulier" v-if="particulier && !entreprise">
                <div class="particulier__container">
                    <strong><?php the_field( 'texte_gras' ); ?></strong>
					<?php if ( have_rows( 'arguments' ) ) : ?>
						<?php while ( have_rows( 'arguments' ) ) : the_row(); ?>
                            <div class="arguments">
                                <h3><?php the_sub_field('titre'); ?></h3>
                                <div class="texte__arguments">
                                    <?php the_sub_field('texte'); ?>
                                </div>
                            </div>
						<?php endwhile; ?>
					<?php endif; ?>
                    <div class="form-container">
                        <?= do_shortcode('[contact-form-7 id="650" title="Particulier"]') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    particulier: false,
                    entreprise: false
                }
            },
            methods: {
                toggleForm(e) {
                    if (e.target.innerText.includes('PARTICULIER')) {
                        console.log(e.target.innerText)
                        this.toggleParticulier();
                    } else if ( e.target.innerText.includes('ENTREPRISE') ) {
                        this.toggleEntreprise();
                    }
                },
                toggleParticulier() {
                    this.particulier = !this.particulier;
                    this.entreprise = !this.particulier
                },
                toggleEntreprise () {
                    this.entreprise = !this.entreprise;
                    this.particulier = !this.entreprise
                }
            }
        }).mount('#root')
    </script>
</main>

<?php get_footer(); ?>
