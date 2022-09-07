<?php
get_header(); ?>

    <main class="product" id="root">
	    <?php while ( have_posts() ) : ?>
		    <?php the_post(); ?>
		<?php if (have_rows('gallerie')) :
			$image_array = array();
			while (have_rows('gallerie')) : the_row();
				$image = get_sub_field('image');
				$image_array[] = $image;
			endwhile;
			$image_export = json_encode($image_array);
		endif; ?>
        <section class="hero-wave-banner" v-if="isLoaded">
            <div class="wave"></div>
            <div class="container-narrow gallery">
                <button class="prev-arrow" @click="handlePrev()">
                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/prev-arrow.svg" alt="Image précédente">
                </button>
                <ul class="gallery-container big-one">
                    <li v-for="(image, index) in images.slice(sliceBigA, sliceBigB)" :key="index">
                        <img :src="image.url" :alt="image.alt">
                    </li>
                </ul>
                <ul class="gallery-container little-one">
                    <li v-for="(image, index) in littleImages.slice(sliceLittleA, sliceLittleB)" :key="index">
                        <img :src="image.url" :alt="image.alt">
                    </li>
                </ul>
                <button class="next-arrow" @click="handleNext()">
                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/prev-arrow.svg" alt="Image suivante">
                </button>
            </div>
        </section>
        <section class="upper">
            <div class="container-narrow">
                <h1 class="product-title"><?php the_title(); ?></h1>
                <ul class="attributs">
					<?php if (have_rows('attributs')) : ?>
						<?php while (have_rows('attributs')) : the_row();
							$attribut_img = get_sub_field('image');
							?>
                            <li>
                                <img src="<?= esc_url($attribut_img['url']); ?>"
                                     alt="<?= esc_attr($attribut_img['alt']); ?>">
                                <p><?php the_sub_field('texte'); ?></p>
                            </li>
						<?php endwhile; ?>
					<?php endif; ?>
                    <li class="intervenant-mini">
						<?php $image_intervenant = get_field('image_intervenant'); ?>
                        <img src="<?= esc_url($image_intervenant['url']); ?>"
                             alt="<?= esc_attr($image_intervenant['alt']); ?>">
                        <p><?php the_field('nom'); ?></p>
                    </li>
                </ul>
                <div class="bonhomme">
                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/randonneur-black.svg" alt="Petit randonneur">
                    <p class="moon-flower"><?php the_field('texte_bonhomme'); ?></p>
                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/fleche.svg"
                         alt="Flèche pointant vers le haut">
                </div>
            </div>
        </section>
        <div class="product-wrapper">
            <div class="container-narrow product-container-narrow">
                <section class="product-content">
                    <div class="share">
                        <strong>Partager le voyage : </strong>
						<?php if (have_rows('partager_le_voyage')) : ?>
                            <ul class="share-content">
								<?php while (have_rows('partager_le_voyage')) : the_row();
									$share_image = get_sub_field('image');
									$share_link = get_sub_field('lien');
									?>
                                    <li>
                                        <a href="<?= esc_url($share_link['url']); ?>">
                                            <img src="<?= esc_url($share_image['url']); ?>"
                                                 alt="<?= esc_attr($share_image['alt']); ?>">
                                        </a>
                                    </li>
								<?php endwhile; ?>
                            </ul>
						<?php endif; ?>
                    </div>
                    <div class="auto-content">
						<?php the_content(); ?>
                    </div>
                    <div class="programme" v-show="showProgram">
						<?php the_field('tout_le_programme') ?>
                    </div>
                    <button id="full-program" @click="handleProgram">{{ buttonText }}</button>
                </section>

                <section class="intervenante">
                    <h2>Votre intervenant.e</h2>
                    <div class="intervenante-content">
                        <img src="<?= esc_url($image_intervenant['url']); ?>"
                             alt="<?= esc_attr($image_intervenant['alt']);
						     ?>" class="intervenante-photo">
                        <article class="inter">
                            <h3><?php the_field('nom'); ?></h3>
                            <p><?php the_field('description'); ?></p>
                            <div class="passions">
                                <h4><?php the_field('titre_passion'); ?></h4>
								<?php if (have_rows('passions')) : ?>
                                    <ul>
										<?php while (have_rows('passions')) : the_row(); ?>
                                            <li>
												<?php $passion_image = get_sub_field('image'); ?>
                                                <img src="<?= esc_url($passion_image['url']); ?>"
                                                     alt="<?= esc_attr($passion_image['alt']); ?>">
                                                <p><?php the_sub_field('nom_de_la_passion'); ?></p>
                                            </li>
										<?php endwhile; ?>
                                    </ul>
								<?php endif; ?>
                            </div>
							<?php $lien_intervenante = get_field('lien_page_lintervenante') ?>
                            <a href="<?= esc_url($lien_intervenante['url']) ?>" class="lien_intervenante"><?= esc_html
								($lien_intervenante['title']) ?></a>
                        </article>
                    </div>
                </section>
                <section class="infos-pratique">
                    <h2>Infos pratiques</h2>
                    <div class="infos-pratique__content">
                        <aside class="where">
                            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/pin-black.svg"
                                 alt="Pin de géolocalisation">
                            <div class="texte">
                                <p>Où</p>
                                <strong><?php the_field('adresse'); ?></strong>
                            </div>
                        </aside>
                        <aside class="time">
                            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/point-to-point.svg"
                                 alt="Point à point">
                            <div class="texte">
                                <p><?php the_field('a_x_minutes_de'); ?></p>
                                <strong><?php the_field('localite'); ?></strong>
                            </div>
                        </aside>
                    </div>
                </section>
                <section class="lieu">
					<?php the_field('le_lieu') ?>
                </section>
                <section class="sy-rendre">
					<?php the_field('comment_sy_rendre'); ?>
                    <div class="details-rendre">
						<?php if (have_rows('sy_rendre')): ?>
                            <ul>
								<?php while (have_rows('sy_rendre')) : the_row(); ?>
                                    <li>
										<?php $image_rendre = get_sub_field('image'); ?>
                                        <img src="<?= esc_url($image_rendre['url']) ?>"
                                             alt="<?= esc_attr($image_rendre['alt']);
										     ?>">
                                        <p><?php the_sub_field('texte'); ?></p>
                                    </li>
								<?php endwhile; ?>
                            </ul>
						<?php endif; ?>
                    </div>
                    <div class="sup-info">
						<?php the_field('supplement_dinfo') ?>
                    </div>
                </section>
                <section class="inclus">
                    <h2>Ce qui est inclus dans le prix du voyage : </h2>
					<?php the_field('inclus_dans_le_prix'); ?>
                </section>
                <section class="non-inclus">
                    <h2>Ce qui n'est pas inclus dans le prix du voyages</h2>
					<?php the_field('non_inclus_dans_le_prix'); ?>
                    <p class="preci-bottom"><?php the_field('precision_bas'); ?></p>
                    <div class="bonhomme">
                        <img src="<?= get_stylesheet_directory_uri(); ?>/assets/randonneur-black.svg"
                             alt="Petit randonneur">
                        <p class="moon-flower"><?php the_field('texte_randonneur'); ?></p>
                        <img src="<?= get_stylesheet_directory_uri(); ?>/assets/fleche.svg"
                             alt="Flèche pointant vers le haut">
                    </div>
                </section>
                <section class="conditions-vente">
					<?php the_field('conditions_de_ventes'); ?>
                </section>
            </div>

            <div class="aside">
                <section class="mon-voyage">
                    <h2>Mon voyage</h2>
                    <div class="mon-voyage__content">
                        <h3>Zen avant les fêtes</h3>



		                    <?php wc_get_template_part( 'content', 'single-product' ); ?>


                    </div>
                    <div class="reservation">
                        <a href="#">Je réserve mon voyage</a>
                    </div>
                </section>
                <section class="buttons">
                    <a class="private-button">Je privatise mon voyage</a>
                    <a class="offer-button">J'offre un voyage</a>
                    <a class="contact-button">Contactez-nous</a>
                </section>
            </div>
        </div>

        <script>
            const { createApp } = Vue

            createApp( {
                data () {
                    return {
                        message: 'toto',
                        isLoaded: false,
                        images: [ 'chargement...' ],
                        littleImages: [ 'chargement...', 'chargement...' ],
                        sliceBigA: 0,
                        sliceBigB: 1,
                        sliceLittleA: 1,
                        sliceLittleB: 5,
                        buttonText: 'Tout le programme',
                        showProgram: false,
                    }
                },
                async mounted () {
                    await this.getImages()
                    this.littleImages = this.images
                    if ( this.images.length > 0 ) {
                        this.sliceLittleA = 1
                    }
                    if ( this.images.length < 6 ) {
                        this.sliceLittleB = this.images.length
                    }
                    this.isLoaded = true
                },
                methods: {
                    getImages () {
                        this.images = <?php echo $image_export; ?>
                    },
                    handlePrev () {
                        if ( this.sliceBigA > 0 ) {
                            this.sliceBigA--
                            this.sliceBigB--
                        } else {
                            this.sliceBigA = this.images.length - 1
                            this.sliceBigB = this.images.length
                        }
                        if ( this.sliceLittleA === -1 ) {
                            this.sliceLittleA = -5
                            if ( this.littleImages.length < 6 ) {
                                this.sliceLittleA = -this.littleImages.length
                            }
                            this.sliceLittleB = -1
                        } else if ( this.sliceLittleA === -14 ) {
                            this.sliceLittleA = 0
                            this.sliceLittleB = 4
                            if ( this.littleImages.length < 6 ) {
                                this.sliceLittleB = this.littleImages.length - 1;
                            }
                        } else {
                            this.sliceLittleA--
                            this.sliceLittleB--
                        }
                    },
                    handleNext () {
                        if ( this.sliceBigB < this.images.length ) {
                            this.sliceBigA++
                            this.sliceBigB++
                        } else {
                            this.sliceBigA = 0
                            this.sliceBigB = 1
                        }
                        if ( this.sliceLittleA < this.images.length ) {
                            this.sliceLittleA = this.sliceLittleA + 1
                            this.sliceLittleB = this.sliceLittleB + 1
                        } else {
                            this.sliceLittleA = 1
                            this.sliceLittleB = 5
                            if ( this.images.length < 6 ) {
                                this.sliceLittleB = this.images.length
                            }
                        }
                    },
                    handleProgram () {
                        this.showProgram = !this.showProgram
                        if ( this.showProgram ) {
                            this.buttonText = 'Réduire le programme'
                        } else {
                            this.buttonText = 'Tout le programme'
                        }
                    }
                }
            } ).mount( '#root' );


        </script>

	    <?php endwhile; // end of the loop. ?>
    </main>

<?php get_footer(); ?>