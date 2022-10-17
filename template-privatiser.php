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
                    <div class="raisons__wrapper">
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
								<?php
								$info_bulle = get_sub_field( 'info_bulle' );
								if ( $info_bulle === 'Oui' ) :
									?>
                                    <div class="info-bulle">
                                        <p><?php the_sub_field( 'texte' ); ?></p>
										<?php
										$close = get_template_directory_uri() . '/assets/close.svg';
										$open  = get_template_directory_uri() . '/assets/open.svg';
										?>
                                        <img :src=" infoBulle ? close : open " :alt="infoBulle ? closeInfo : openInfo"
                                             class="open-close" @click="toggleInfoBulle">
                                        <div class="info-bulle__content" v-show="infoBulle">
                                            <p><?php the_sub_field( 'info_bulle_texte' ); ?></p>
                                        </div>
                                    </div>
								<?php else : ?>
                                    <p><?php the_sub_field( 'texte' ); ?></p>
								<?php endif; ?>
								<?php if ( $image_chemin ) : ?>
                                    <img src="<?= esc_url( $image_chemin['url'] ); ?>" alt="<?= esc_attr
									( $image_chemin['alt'] ); ?>" class="chemin">
								<?php endif; ?>
                            </div>
						<?php endwhile; ?>
                    </div>
                    <div class="randonneur">
                        <img src=" <?= get_template_directory_uri() ?>/assets/fleche.svg"
                             alt="Flèche pointant vers le haut">
                        <p class="moon-flower"><?php the_field( 'randonneur_texte' ); ?></p>
                        <img src="<?= get_template_directory_uri() ?>/assets/randonneur-black.svg" alt="Petit
                            randonneur">
                    </div>
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
                                <h3><?php the_sub_field( 'titre' ); ?></h3>
                                <div class="texte__arguments">
									<?php the_sub_field( 'texte' ); ?>
                                </div>
                            </div>
						<?php endwhile; ?>
					<?php endif; ?>
                    <div class="form-container">
						<?= do_shortcode( '[contact-form-7 id="650" title="Particulier"]' ) ?>
                    </div>
                </div>
            </div>

            <div class="particulier entreprise" v-if="!particulier && entreprise">
                <div class="particulier__container">
					<?php if ( have_rows( 'arguments_entreprise' ) ) : ?>
						<?php while ( have_rows( 'arguments_entreprise' ) ) : the_row(); ?>
                            <div class="arguments">
                                <h3><?php the_sub_field( 'titre' ); ?></h3>
                                <div class="texte__arguments">
									<?php the_sub_field( 'texte' ); ?>
                                </div>
                            </div>
						<?php endwhile; ?>
					<?php endif; ?>
                    <div class="form-container">
						<?= do_shortcode( '[contact-form-7 id="656" title="Entreprise"]' ) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<?php if ( have_rows( 'ils_parlent_de_nous' ) ) :
		$lien_reviews = [];
		$image_reviews = [];
		?>
        <section class="reviews" v-if="particulier || entreprise">
            <div class="container-narrow">
                <h2 class="title__reviews">Ils nous font confiances :</h2>
                <div class="reviews__contianer">
					<?php while ( have_rows( 'ils_parlent_de_nous' ) ) : the_row();
						$lien            = get_sub_field( 'lien' );
						$image           = get_sub_field( 'image' );
						$lien_reviews[]  = array_push( $lien_reviews, $lien );
						$image_reviews[] = array_push( $image_reviews, $image );
					endwhile; ?>
                    <a v-for="(link, index) in slideLink" :key="index" :href="link" target="_blank"
                       class="lien__reviews">
                        <img :src="image[index]['url']" :alt="image[index]['alt']">
                    </a>
                </div>
            </div>
        </section>
	<?php endif; ?>

    <section class="response-form" v-if="sent">
        <div class="container-center">
            <h2 class="terracota">Merci pour votre message !</h2>
            <strong>Nous vous répondrons dans les plus brefs délais.</strong>
            <div class="btn__container">
                <a href="<?= home_url(); ?>" class="btn home-btn">Revenir à l'accueil</a>
                <button class="btn close-btn" @click="closeSent">Fermer cette fenêtre</button>
            </div>
        </div>
    </section>

    <script>
        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    particulier: false,
                    entreprise: false,
                    image: null,
                    lien: null,
                    sliceA: 0,
                    sliceB: 1,
                    infoBulle: false,
                    close: null,
                    open: null,
                    closeInfo: 'Fermer l\'info bulle',
                    openInfo: 'Ouvrir l\'info bulle',
                    sent: false,
                }
            },
            computed: {
                slideLink () {
                    return this.lien.slice( this.sliceA, this.sliceB );
                }
            },
            async mounted () {
                await this.isSent();
                this.getReviewsInfo();
                this.windowWidth = window.innerWidth;
                this.sliceB = this.lien.length;
            },
            methods: {
                closeSent() {
                    this.sent = false;
                },
                isSent () {
                    const formUrl = window.location;
                    if( formUrl.hash ) {
                        this.sent = true;
                    }
                },
                getReviewsInfo () {
                    this.image = <?= json_encode( $image_reviews ); ?>;
                    this.lien = <?= json_encode( $lien_reviews ); ?>;
                    this.close = <?= json_encode( $close ); ?>;
                    this.open = <?= json_encode( $open ); ?>;
                    this.lien = this.lien.filter( function ( item ) {
                        return typeof item !== 'number';
                    } );
                    this.image = this.image.filter( function ( item ) {
                        return typeof item !== 'number';
                    } );
                },
                toggleForm ( e ) {
                    if ( e.target.innerText.includes( 'PARTICULIER' ) ) {
                        console.log( e.target.innerText )
                        this.toggleParticulier();
                    } else if ( e.target.innerText.includes( 'ENTREPRISE' ) ) {
                        this.toggleEntreprise();
                    }
                },
                toggleParticulier () {
                    this.particulier = true;
                    this.entreprise = !this.particulier
                },
                toggleEntreprise () {
                    this.entreprise = true;
                    this.particulier = !this.entreprise
                },
                toggleInfoBulle () {
                    this.infoBulle = !this.infoBulle;
                }
            },
        } ).mount( '#root' )
    </script>
</main>

<?php get_footer(); ?>
