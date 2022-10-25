<?php if ( get_field( 'longitude' ) && get_field( 'latitude' ) && get_field( 'zoom' ) && get_field( 'adresse_map' ) ) :
	$longitude   = json_encode( get_field( 'longitude' ) );
	$latitude    = json_encode( get_field( 'latitude' ) );
	$zoom        = json_encode( get_field( 'zoom' ) );
	$address_map = json_encode( get_field( 'adresse_map' ) );
endif;

if ( have_rows( 'gallerie' ) ) :
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
            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/prev-arrow.svg" alt="Image précédente">
        </button>
        <ul class="gallery-container big-one">
            <li v-for="(image, index) in images.slice(sliceBigA, sliceBigB)" :key="index">
                <img :src="image.url" :alt="image.alt">
            </li>
        </ul>
        <ul class="gallery-container little-one">
            <li v-for="(image, index) in handleMiniature.slice(sliceLittleA, sliceLittleB)" :key="index">
                <img :src="image.url" :alt="image.alt">
            </li>
        </ul>
        <button class="next-arrow" @click="handleNext()">
            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/prev-arrow.svg" alt="Image suivante">
        </button>
    </div>
</section>
<section class="return-voyages">
    <a href="#" class="return">&#10094; Retours aux voyages</a>
</section>
<section class="upper">
    <div class="container-narrow">
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
				<?php
				if ( get_field( 'image_intervenant' ) ) :
					$image_intervenant = get_field( 'image_intervenant' ); ?>
                    <img src="<?= esc_url( $image_intervenant['url'] ); ?>"
                         alt="<?= esc_attr( $image_intervenant['alt'] ); ?>">
                    <p><?php the_field( 'nom' ); ?></p>
				<?php endif; ?>
            </li>
        </ul>
        <div class="bonhomme">
            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/randonneur-black.svg"
                 alt="Petit randonneur">
            <p class="moon-flower"><?php the_field( 'texte_bonhomme' ); ?></p>
            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/fleche.svg"
                 alt="Flèche pointant vers le haut">
        </div>
    </div>
</section>
<div class="product-wrapper container-narrow">
    <div class="product-container-narrow">
        <section class="product-content">
			<?php if ( have_rows( 'partager_le_voyage' ) ) : ?>
                <div class="share">
                    <strong>Partager le voyage : </strong>
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
                </div>
			<?php endif; ?>
            <div class="auto-content">
				<?php the_content(); ?>
            </div>
			<?php if ( get_field( 'tout_le_programme' ) ) : ?>
                <div class="programme" v-show="showProgram">
					<?php the_field( 'tout_le_programme' ) ?>
                </div>
                <button id="full-program" @click="handleProgram">{{ buttonText }}</button>
			<?php endif; ?>
        </section>
		<?php if ( get_field( 'nom' ) ) : ?>
            <section class="intervenante">
                <h2>Votre intervenant.e</h2>
                <div class="intervenante-content">
                    <img src="<?= esc_url( $image_intervenant['url'] ); ?>"
                         alt="<?= esc_attr( $image_intervenant['alt'] );
					     ?>" class="intervenante-photo">
                    <article class="inter">
                        <h3><?php the_field( 'nom' ); ?></h3>
                        <p><?php the_field( 'description' ); ?></p>
                        <div class="passions">
                            <h4><?php the_field( 'titre_passion' ); ?></h4>
							<?php if ( have_rows( 'passions' ) ) : ?>
                                <ul>
									<?php while ( have_rows( 'passions' ) ) : the_row(); ?>
                                        <li>
											<?php $passion_image = get_sub_field( 'image' ); ?>
                                            <img src="<?= esc_url( $passion_image['url'] ); ?>"
                                                 alt="<?= esc_attr( $passion_image['alt'] ); ?>">
                                            <p><?php the_sub_field( 'nom_de_la_passion' ); ?></p>
                                        </li>
									<?php endwhile; ?>
                                </ul>
							<?php endif; ?>
                        </div>
						<?php $lien_intervenante = get_field( 'lien_page_lintervenante' ) ?>
                        <a href="<?= esc_url( $lien_intervenante['url'] ) ?>"
                           class="lien_intervenante"><?= esc_html( $lien_intervenante['title'] ) ?></a>
                    </article>
                </div>
            </section>
		<?php endif; ?>
		<?php if ( get_field( 'adresse' ) ) : ?>
            <section class="infos-pratique">
                <h2>Infos pratiques</h2>
                <div class="infos-pratique__content">
                    <aside class="where">
                        <img src="<?= get_stylesheet_directory_uri(); ?>/assets/pin-black.svg"
                             alt="Pin de géolocalisation">
                        <div class="texte">
                            <p>Où</p>
                            <strong><?php the_field( 'adresse' ); ?></strong>
                        </div>
                    </aside>
                    <aside class="time">
                        <img src="<?= get_stylesheet_directory_uri(); ?>/assets/point-to-point.svg"
                             alt="Point à point">
                        <div class="texte">
                            <p><?php the_field( 'a_x_minutes_de' ); ?></p>
                            <strong><?php the_field( 'localite' ); ?></strong>
                        </div>
                    </aside>
                </div>
            </section>
		<?php endif;
		if ( get_field( 'le_lieu' ) ) :
			?>
            <section class="lieu">
				<?php the_field( 'le_lieu' ) ?>
            </section>
		<?php endif;
		if ( get_field( 'comment_sy_rendre' ) ) :
			?>
            <section class="sy-rendre">
				<?php the_field( 'comment_sy_rendre' ); ?>
                <div class="details-rendre">
					<?php if ( have_rows( 'sy_rendre' ) ): ?>
                        <ul>
							<?php while ( have_rows( 'sy_rendre' ) ) : the_row(); ?>
                                <li>
									<?php $image_rendre = get_sub_field( 'image' ); ?>
                                    <img src="<?= esc_url( $image_rendre['url'] ) ?>"
                                         alt="<?= esc_attr( $image_rendre['alt'] );
									     ?>">
                                    <p><?php the_sub_field( 'texte' ); ?></p>
                                </li>
							<?php endwhile; ?>
                        </ul>
					<?php endif; ?>
                </div>
                <div class="sup-info">
					<?php the_field( 'supplement_dinfo' ) ?>
                </div>
                <div class="options-text">
					<?php the_field( 'options' ); ?>
                </div>
            </section>
		<?php endif; ?>
		<?php if ( get_field( 'inclus_dans_le_prix' ) ) : ?>
            <section class="inclus">
                <h2>Ce qui est inclus dans le prix du voyage : </h2>
				<?php the_field( 'inclus_dans_le_prix' ); ?>
            </section>
		<?php endif;
		if ( get_field( 'non_inclus_dans_le_prix' ) ) :
			?>
            <section class="non-inclus">
                <h2>Ce qui n'est pas inclus dans le prix du voyage</h2>
				<?php the_field( 'non_inclus_dans_le_prix' ); ?>
                <p class="preci-bottom"><?php the_field( 'precision_bas' ); ?></p>
                <div class="bonhomme">
                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/randonneur-black.svg"
                         alt="Petit randonneur">
                    <p class="moon-flower"><?php the_field( 'texte_randonneur' ); ?></p>
                    <img src="<?= get_stylesheet_directory_uri(); ?>/assets/fleche.svg"
                         alt="Flèche pointant vers le haut">
                </div>
            </section>
		<?php endif;
		if ( get_field( 'conditions_de_ventes' ) ) :
			?>
            <section class="conditions-vente">
				<?php the_field( 'conditions_de_ventes' ); ?>
            </section>
		<?php endif; ?>
    </div>

    <div class="aside">
        <section class="mon-voyage">
            <h2>
                Réservez mon<br />voyage
                <span class="return" id="back-to-date">Retour aux voyages</span>
            </h2>
            <div class="mon-voyage__content">
				<?php wc_get_template_part( 'content', 'single-product' );
				?>
            </div>
            <div class="reservation">
                <a href="#" id="reverver" @click="handleClick">Je réserve mon voyage</a>
            </div>
        </section>
        <section class="buttons">
			<?php
			$contact    = get_field( 'page_contact', 'option' );
			$gift_card  = get_field( 'page_offre_un_voyage', 'option' );
			$privatiser = get_field( 'page_privatiser_un_voyage', 'option' );
			?>
            <a href="<?= esc_url( $privatiser['url'] ); ?>" class="private-button">Je privatise mon voyage</a>
            <a href="<?= esc_url( $gift_card['url'] ); ?>" class="offer-button">J'offre un voyage</a>
            <a href="<?= esc_url( $contact['url'] ); ?>" class="contact-button">Contactez-nous</a>
        </section>
        <section class="map">
            <div id="map"></div>
        </section>
        <section class="pictures">
			<?php if ( have_rows( 'photo_voyages' ) ) : ?>
				<?php while ( have_rows( 'photo_voyages' ) ) : the_row();
					$photo = get_sub_field( 'image' );
					?>
                    <img src="<?= esc_url( $photo['url'] ); ?>" alt="<?= esc_attr( $photo['alt'] ); ?>">
				<?php endwhile; ?>
			<?php endif; ?>
        </section>
    </div>
</div>

<?php
$item = array();
if ( ! WC()->cart->is_empty() ) {
	$cart = WC()->cart->get_cart();

	foreach ( $cart as $cart_item_key => $cart_item ) {
		$item[] = $cart_item;
	}
} ?>

<section class="cart-confirmation" v-if="showNotification && currentCart.length > 0">
    <div class="cart-confirmation__wrapper">
        <img src="<?= get_template_directory_uri() ?>/assets/close.svg" alt="Fermer la fenêtre" class="close__pop-up"
             @click="closeShowNotification">
        <div class="wrapper-content">
            <h2>Votre voyage a été ajouté à votre panier</h2>
            <div class="description">
				<?php the_post_thumbnail(); ?>
                <div class="text__cart-confirmation">
                    <h3><?php the_title(); ?></h3>
                    <p class="dates-texte">{{firstVariation}}</p>
                    <p>Nombre(s) de personne(s) : {{quantity}} - {{secondVariation}}</p>
                    <strong>Prix : {{price}}€</strong>
                </div>
            </div>
            <div class="cart-confirmation__btn-container">
                <a href="<?= home_url(); ?>" class="btn btn-continue">Continuer mes achats</a>
				<?php $cart_page = get_field( 'page_panier', 'option' ) ?>
                <a href="<?= esc_url( $cart_page['url'] ); ?>" class="btn go-to-cart">Commander</a>
            </div>
        </div>
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
                littleImages: [ 'chargement...', 'chargement...' ],
                sliceBigA: 0,
                sliceBigB: 1,
                sliceLittleA: 1,
                sliceLittleB: 5,
                step: 5,
                buttonText: 'Tout le programme',
                showProgram: false,
                longitude: 0,
                latitude: 0,
                zoom: 0,
                map: null,
                marker: null,
                addressMap: null,
                markerIcon: L.icon( {
                    iconUrl: '<?= get_stylesheet_directory_uri(); ?>/assets/marker.svg',
                    iconSize: [ 38, 57 ],
                    iconAnchor: [ 22, 44 ],
                    popupAnchor: [ -3, -36 ]
                } ),
                showNotification: false,
                currentCart: [],
                currentId: null,
                firstVariation: 'Aucun produit actuellement dans votre panier',
                secondVariation: 'Aucun produit actuellement dans votre panier',
                quantity: 0,
                price: 0,
                windowWidth: 1920,
            }
        },
        computed: {
            handleMiniature () {
                return this.littleImages = [
                    ...this.littleImages,
                    ...this.littleImages.slice( 0, this.step - 1 )
                ]
            },

        },
        async mounted () {
            await this.getImages()
            await this.getCoord()
            await this.setShowNotification()
            await this.getPostId();
            await this.getCartInfo();
            this.windowWidth = window.innerWidth;
            if ( this.currentCart.length > 0 ) {
                this.getProductInformation();
            }
            this.littleImages = this.images;
            this.voyage = <?= json_encode( get_the_title() ); ?>;
            if ( this.images.length > 0 ) {
                this.sliceLittleA = 1
            }
            if ( this.windowWidth < 600 ) {
                this.sliceLittleB = 3
            } else {
                if ( this.images.length < 6 ) {
                    this.sliceLittleB = this.images.length
                } else {
                    this.sliceLittleB = 5
                }

            }

            this.map = L.map( 'map', {
                attributionControl: false, dragging: false, zoomControl: false,
                boxZoom: false, doubleClickZoom: false, scrollWheelZoom: false, tap: false, touchZoom: false
            } ).setView( [ this.longitude, this.latitude ], this.zoom );

            L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            } ).addTo( this.map );

            this.marker = L.marker( [ this.longitude, this.latitude ], { icon: this.markerIcon } ).addTo( this
                .map );

            this.marker.bindPopup( this.addressMap ).openPopup();
            this.isLoaded = true
        },
        methods: {
            getProductInformation () {
                this.currentCart.map( item => {
                    if ( item.product_id === this.currentId ) {
                        this.quantity = item.quantity;
                        this.firstVariation = item.variation.attribute_pa_dates;
                        this.secondVariation = item.variation[ 'attribute_pa_type-de-chambre' ];
                        this.price = item.line_total;
                        this.firstVariation = this.firstVariation.replaceAll( '-', ' ' );
                        this.secondVariation = this.secondVariation.replaceAll( '-', ' ' );
                    }
                } )
            },
            getPostId () {
                this.currentId = <?= json_encode( get_the_ID() ); ?>;
            },
            getCartInfo () {
                this.currentCart = <?= json_encode( $item ); ?>;
            },
            closeShowNotification () {
                this.showNotification = false
            },
            setShowNotification () {
                const message = document.querySelector( '.wc-forward' );

                if ( message ) {
                    this.showNotification = true;
                    message.style.display = 'none';
                }
            },
            getImages () {
                this.images = <?php echo $image_export; ?>
            },
            getCoord () {
                this.longitude = <?php echo $longitude; ?>;
                this.longitude = Number( this.longitude ).toFixed( 3 )
                this.latitude = <?php echo $latitude; ?>;
                this.latitude = Number( this.latitude ).toFixed( 3 )
                this.zoom = <?php echo $zoom; ?>;
                this.addressMap = <?php echo $address_map; ?>;
                this.longitude = Number( this.longitude );
                this.latitude = Number( this.latitude );
                this.zoom = Number( this.zoom );
            },
            handleProgram () {
                this.showProgram = !this.showProgram
                if ( this.showProgram ) {
                    this.buttonText = 'Réduire le programme'
                } else {
                    this.buttonText = 'Tout le programme'
                }
            },
            handlePrev () {
                if ( this.sliceBigA > 0 ) {
                    this.sliceBigA--
                    this.sliceBigB--
                } else {
                    this.sliceBigA = this.images.length - 1
                    this.sliceBigB = this.images.length
                }
                if ( this.sliceLittleA === 0 ) {
                    if ( this.windowWidth > 600 ) {
                        this.sliceLittleA = this.step - 1
                        this.sliceLittleB = this.step + ( this.step - 2 );
                    } else {
                        this.sliceLittleA = ( this.step - 1 ) / 2 + 2
                        this.sliceLittleB = ( this.step + this.step - 2 ) / 2 + 2;
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
                    if ( this.windowWidth < 600 ) {
                        this.sliceLittleB = 3
                    } else {
                        this.sliceLittleB = this.step

                    }
                    if ( this.images.length < 6 && this.windowWidth > 600 ) {
                        this.sliceLittleB = this.images.length
                    }
                }
            }
        }
    } ).mount( '#root' );


</script>