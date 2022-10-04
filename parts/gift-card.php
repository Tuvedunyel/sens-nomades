<?php if ( have_rows( 'gallerie' ) ) :
	$image_array = array();
	while ( have_rows( 'gallerie' ) ) : the_row();
		$image         = get_sub_field( 'image' );
		$image_array[] = $image;
	endwhile;
	$image_export = json_encode( $image_array );
endif; ?>

<section class="hero-wave-banner" v-if="isLoaded" id="gift-hero">
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
<section class="return-voyages">
    <a href="#" class="return">&#10094; Retours au voyages</a>
</section>

<section id="gift-card__page">
    <div class="container-narrow">
        <div class="randonneur">
            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/fleche.svg" alt="Fleche pointer vers le bas"
                 class="arrow-bottom">
            <p class="moon-flower"><?php the_field( 'randonneur_carte_cadeau' ); ?></p>
            <img src="<?= get_template_directory_uri(); ?>/assets/randonneur-black.svg" alt="Randonneur">

        </div>
        <div class="content__gift-card">
			<?php the_content(); ?>
			<?php wc_get_template_part( 'content', 'single-product' ); ?>
        </div>
    </div>
</section>

<section id="chemin-gift">
    <div class="container-narrow">
        <div class="top-chemin">
            <?php the_field('premier_point'); ?>
            <img src="<?= get_template_directory_uri(); ?>/assets/trace-gift-top.svg" alt="Chemin allant vers le bas">
        </div>
        <div class="middle-chemin">
            <?php the_field('second_point'); ?>
        </div>
        <div class="bottom-chemin">
            <?php the_field('troisieme_point'); ?>
            <img src="<?= get_template_directory_uri(); ?>/assets/trace-gift-bottom.svg" alt="Chemin allant vers le haut">
        </div>
    </div>
</section>

<section id="get-gift">
    <div class="container-narrow">
        <?php the_field('avoir_une_carte'); ?>
    </div>
</section>

<script>
    const { createApp } = Vue

    createApp( {
        data () {
            return {
                isLoaded: false,
                images: [ 'chargement...' ],
                littleImages: [ 'chargement...', 'chargement...' ],
                sliceBigA: 0,
                sliceBigB: 1,
                sliceLittleA: 1,
                sliceLittleB: 5,
            }
        },
        async mounted () {
            await this.getImages()
            this.littleImages = this.images;
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
            }
        }
    } ).mount( '#root' );


</script>
