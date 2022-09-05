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
                <li v-for="(image, index) in images.slice(sliceLittleA, sliceLittleB)" :key="index">
                    <img :src="image.url" :alt="image.alt">
                </li>
            </ul>
            <button class="next-arrow" @click="handleNext()">
                <img src="<?= get_template_directory_uri(); ?>/assets/prev-arrow.svg" alt="Image suivante">
            </button>
        </div>
    </section>


    <script>
        const { createApp } = Vue

        createApp( {
            data () {
                return {
                    message: 'toto',
                    isLoaded: false,
                    images: [ 'chargement...' ],
                    sliceBigA: 0,
                    sliceBigB: 1,
                    sliceLittleA: 1,
                    sliceLittleB: 5,
                }
            },
            async mounted () {
                await this.getImages()
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
                    if ( this.sliceLittleA > 0 ) {
                        this.sliceLittleA--
                        this.sliceLittleB--
                    } else {
                        this.sliceLittleA = 0
                        this.sliceLittleB = 4
                        if ( this.images.length < 6 ) {
                            this.sliceLittleB = this.images.length - 1
                        }
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