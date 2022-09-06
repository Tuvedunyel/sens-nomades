<?php
get_header();
?>
<main class="product" id="root">
	<?php if ( have_rows( 'gallerie' ) ) :
		$image_array = array();
		while ( have_rows( 'gallerie' ) ) : the_row();
			$image         = get_sub_field( 'image' );
			$image_array[] = $image;
		endwhile;
		$image_export = json_encode( $image_array );
	endif; ?>
    <section class="hero-wave-banner" v-if="isLoaded">
        <div class="wave"></div>
        <div class="container-narrow gallery">
            <button class="prev-arrow" @click="handlePrev()">
                <img src="<?= get_template_directory_uri(); ?>/assets/prev-arrow.svg" alt="Image précédente">
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
                <img src="<?= get_template_directory_uri(); ?>/assets/prev-arrow.svg" alt="Image suivante">
            </button>
        </div>
    </section>

    <div class="container-narrow">
        <section class="upper">
            <h1 class="product-title"><?php the_title(); ?></h1>
            <ul class="attributs">
				<?php if ( have_rows( 'attributs' ) ) : ?>
					<?php while ( have_rows( 'attributs' ) ) : the_row();
						$attribut_img = get_sub_field( 'image' );
						?>
                        <li>
                            <img src="<?= esc_url( $attribut_img['url'] ); ?>"
                                 alt="<?= esc_attr( $attribut_img['alt'] ); ?>">
                            <p><?php the_sub_field( 'texte' ); ?></p>
                        </li>
					<?php endwhile; ?>
				<?php endif; ?>
                <li class="intervenant-mini">
					<?php $image_intervenant = get_field( 'image_intervenant' ); ?>
                    <img src="<?= esc_url( $image_intervenant['url'] ); ?>"
                         alt="<?= esc_attr( $image_intervenant['alt'] ); ?>">
                    <p><?php the_field( 'nom' ); ?></p>
                </li>
            </ul>
            <div class="bonhomme">
                <img src="<?= get_template_directory_uri(); ?>/assets/randonneur-black.svg" alt="Petit randonneur">
                <p class="moon-flower"><?php the_field( 'texte_bonhomme' ); ?></p>
                <img src="<?= get_template_directory_uri(); ?>/assets/fleche.svg" alt="Flèche pointant vers le haut">
            </div>

        </section>

        <section class="product-content">
            <div class="share">
                <strong>Partager le voyage : </strong>
				<?php if ( have_rows( 'partager_le_voyage' ) ) : ?>
                    <ul class="share-content">
						<?php while ( have_rows( 'partager_le_voyage' ) ) : the_row();
							$share_image = get_sub_field( 'image' );
							$share_link  = get_sub_field( 'lien' );
							?>
                            <li>
                                <a href="<?= esc_url( $share_link['url'] ); ?>">
                                    <img src="<?= esc_url( $share_image['url'] ); ?>"
                                         alt="<?= esc_attr( $share_image['alt'] ); ?>">
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
				<?php the_field( 'tout_le_programme' ) ?>
            </div>
            <button id="full-program" @click="handleProgram">{{ buttonText }}</button>
        </section>
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
</main>

<?php get_footer(); ?>
