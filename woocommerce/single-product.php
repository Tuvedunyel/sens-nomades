<?php
get_header(); ?>

    <main class="product" id="root">
		<?php while ( have_posts() ) :
			the_post();
			$longitude   = json_encode( get_field( 'longitude' ) );
			$latitude    = json_encode( get_field( 'latitude' ) );
			$zoom        = json_encode( get_field( 'zoom' ) );
			$address_map = json_encode( get_field( 'adresse_map' ) );

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
							<?php $image_intervenant = get_field( 'image_intervenant' ); ?>
                            <img src="<?= esc_url( $image_intervenant['url'] ); ?>"
                                 alt="<?= esc_attr( $image_intervenant['alt'] ); ?>">
                            <p><?php the_field( 'nom' ); ?></p>
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
<!--                                <a href="--><?//= esc_url( $lien_intervenante['url'] ) ?><!--"-->
<!--                                   class="lien_intervenante">--><?//= esc_html
//									( $lien_intervenante['title'] ) ?><!--</a>-->
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
                    <section class="lieu">
						<?php the_field( 'le_lieu' ) ?>
                    </section>
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
                    <section class="inclus">
                        <h2>Ce qui est inclus dans le prix du voyage : </h2>
						<?php the_field( 'inclus_dans_le_prix' ); ?>
                    </section>
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
                    <section class="conditions-vente">
						<?php the_field( 'conditions_de_ventes' ); ?>
                    </section>
                </div>

                <div class="aside">
                    <section class="mon-voyage">
                        <h2>Mon voyage</h2>
                        <div class="mon-voyage__content">
                            <!--							--><?php //wc_get_template_part( 'content', 'single-product' );
							?>
                            <p class="product-date__item">
                                Du <?php the_field( 'date_de_depart' ); ?> au <?php the_field( 'date_de_retour' ); ?>
                            </p>
                            <div class="details-temp-product">
								<?php if ( have_rows( 'type_de_chambre' ) ) :
									$chambre = [];
									$price   = [];
									while ( have_rows( 'type_de_chambre' ) ) : the_row();
										$chambre[] = get_sub_field( 'chambre' );
										$price[]   = get_sub_field( 'prix' );
									endwhile;
								endif; ?>
								<?php if ( have_rows( 'en_option' ) ):
									$option      = [];
									$priceOption = [];
									while ( have_rows( 'en_option' ) ) : the_row();
										$option[]       = get_sub_field( 'option' );
										$price_option[] = get_sub_field( 'prix' );
									endwhile; endif; ?>
                                <div class="temp__type-chambre">
                                    <select name="chambre" id="chambre" @change="handleChamberPrice($event)"
                                            v-model="chambreSelect">
                                        <option value="" selected="selected" disabled>{{ chambreSelect }}</option>
                                        <option v-for="(chambre, index) in typeChamber.chambre" :key="index"
                                                :value="chambre">{{ chambre }}
                                        </option>
                                    </select>
                                </div>
                                <div class="participant__temp">
                                    <label for="participants">Nombre de participant.e.s : </label>
                                    <input type="number" name="participants" id="participants" min="0"
                                           v-model="numberParticipant">
                                </div>

                                <div class="temp__option">
                                    <p class="option-title">En option :</p>
                                    <div class="options-container">
                                        <div v-for="(option, index) in options.option">
                                            <input type="number" name="quantity" :id="index" min="0"
                                                   v-model="options.quantity[index]" @change="handleOptionPrice(index)">
                                            <p>{{ option }} - <span class="bold-option">{{ options.price[index] }}
                                                    €</span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="temp-price">
                                    <p class="price-temp">Tarifs :</p>
                                    <h5>{{totalPrice}} €</h5>
                                </div>

                            </div>
                        </div>
                        <div class="reservation">
                            <a href="#" id="reverver" @click="handleClick">Je réserve mon voyage</a>
                        </div>
                    </section>
<!--                    <section class="buttons">-->
<!--                        <a href="#" class="private-button">Je privatise mon voyage</a>-->
<!--                        <a href="#" class="offer-button">J'offre un voyage</a>-->
<!--                        <a href="#" class="contact-button">Contactez-nous</a>-->
<!--                    </section>-->
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

            <section class="temp-form" v-if="showTempForm" >
                <div class="close" @click="closePopUp">
                    <img src="<?= get_template_directory_uri() ?>/assets/close.svg" alt="Fermer la popup">
                </div>
                <div class="container-narrow" @click="stayPopUp">
                    <h2>Récapitulatif de votre voyage</h2>
                    <div class="info-voyage">
						<?php $image_temp = get_field( 'image_voyage_form' ); ?>
                        <img src="<?= esc_url( $image_temp['url'] ) ?>" alt="<?= esc_attr( $image_temp['alt'] ); ?>">
                        <div class="temp__info-voyage">
                            <h3><?php the_title(); ?></h3>
                            <p class="temp__info-title">
                                Du <?php the_field( 'date_de_depart' ); ?> au <?php the_field( 'date_de_retour' ); ?>
                            </p>
                            <p>Nombre(s) de personne(s): {{`${numberParticipant} - ${chambreSelect}`}}</p>
                            <div class="options__form">
                                <p class="options__form-title">En option :</p>
                                <p><i>selon disponibilités au moment de la réservation</i></p>
                                <p v-for="(option, index) in selectedOptions" :key="index">{{ `${option.name} -
                                    Nombre de personnes : ${option.quantity}` }}</p>
                            </div>
                            <div class="form__price">
                                <p>Prix : {{totalPrice}}€</p>
                            </div>
                        </div>
                    </div>
                    <div class="form_confirm">
                        <h2 v-if="sentResa">{{response}}</h2>
                        <form action="" v-if="!sentResa">
                            <label for="name">
                                Votre nom*
                                <input type="text" name="name" id="name" placeholder="Nomades" required
                                       v-model="name">
                            </label>
                            <label for="prenom">
                                Votre prénom*
                                <input type="text" name="prenom" id="prenom" placeholder="Marie" v-model="prenom"
                                       required>
                            </label>
                            <label for="phone">
                                Votre numéro de téléphone*
                                <input type="tel" name="phone" id="phone" placeholder="06 00 00 00 00" v-model="phone"
                                       required>
                            </label>
                            <label for="mail">
                                Votre adresse mail
                                <input type="email" name="mail" id="mail" placeholder="nomades-marie@sens-nomades.com"
                                       v-model="mail"
                                       required>
                            </label>
                            <label for="naissance">
                                Votre date de naissance*
                                <input type="date" name="naissance" id="naissance" v-model="naissance" required>
                            </label>
                            <label for="adresse">
                                Votre adresse *
                                <input type="text" name="adresse" id="adresse" placeholder="1 rue des nomades"v-model="adresse"required>
                            </label>
                            <label for="ville">
                                Votre ville *
                                <input type="text" name="ville" id="ville" placeholder="Paris" v-model="ville" required>
                            </label>
                            <label for="postale">
                                Code postal *
                                <input type="text" name="postale" id="postale" placeholder="75000" v-model="postale" required>
                            </label>
                            <label for="regime">
                                Avez-vous un régime alimentaire particulier ?
                                <input type="text" name="regime" id="regime" placeholder="Végétarien" v-model="regime">
                            </label>
                            <label for="allergie">
                                Il y a t-il des éléments que nous devons connaître : allergies ? etc... C'est le moment de tout nous dire :)
                                <input type="text" name="allergie" id="allergie" placeholder="Aucune" v-model="allergie">
                            </label>
                            <label for="assurance">
                                Souhaitez vous souscrire à l'assurance voyages Chapka ? *
                                <input type="text" name="assurance" id="assurance" placeholder="Oui"
                                       v-model="assurance" required>
                            </label>
                            <button class="form-btn" @click="submitForm($event)">Envoyer ma réservation</button>
                        </form>
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
                            typeChamber: {
                                chambre: [],
                                price: [],
                            },
                            options: {
                                option: [],
                                price: [],
                                quantity: [],
                                currentPrice: [],
                            },
                            numberParticipant: 1,
                            chamberPrice: 0,
                            totalChamberPrice: 0,
                            totalPrice: 0,
                            optionsPrice: 0,
                            showTempForm: false,
                            chambreSelect: null,
                            selectedOptions: [{ name: 'aucune', quantity: 0 }],
                            name: null,
                            prenom: null,
                            phone: null,
                            mail: null,
                            error: null,
                            response: null,
                            voyage: null,
                            sentResa: false,
                            adresse: null,
                            postale: null,
                            ville: null,
                            naissance: null,
                            regime: null,
                            allergie: null,
                        }
                    },
                    async mounted () {
                        await this.getImages()
                        await this.getCoord()
                        await this.tempFunction()
                        this.littleImages = this.images;
                        this.voyage = <?= json_encode(get_the_title()); ?>;
                        if ( this.images.length > 0 ) {
                            this.sliceLittleA = 1
                        }
                        if ( this.images.length < 6 ) {
                            this.sliceLittleB = this.images.length
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
                        closePopUp () {
                            this.showTempForm = false
                        },
                        submitForm (e) {
                            e.preventDefault();
                            this.errors = [];
                            this.checkForm();
                            if ( !this.errors.length ) {
                                const bodyFormData = new FormData();
                                bodyFormData.set("nom", this.name);
                                bodyFormData.set("prenom", this.prenom);
                                bodyFormData.set("tel", this.phone);
                                bodyFormData.set("mail", this.mail);
                                bodyFormData.set("voyage", this.voyage);
                                bodyFormData.set("participants", this.numberParticipant);
                                bodyFormData.set("chambre", this.chambreSelect);
                                bodyFormData.set("options", JSON.stringify(this.selectedOptions));
                                bodyFormData.set("prix-estime", this.totalPrice);
                                bodyFormData.set("adresse", this.adresse);
                                bodyFormData.set("ville", this.ville);
                                bodyFormData.set("postal", this.postale);
                                bodyFormData.set("regime", this.regime);
                                bodyFormData.set("allergie", this.allergie);
                                bodyFormData.set("assurance", this.assurance);
                                bodyFormData.set("naissance", this.naissance);

                                axios( {
                                    method: "post",
                                    url: "https://www.sens-nomades.com/wp-json/contact-form-7/v1/contact-forms/582/feedback",
                                    data: bodyFormData,
                                    config: { headers: { "Content-Type": "multipart/form-data" } },
                                } ).then( response => {
                                    console.log( response )
                                    this.response = response.data.message;
                                    this.sentResa = true;
                                    this.name = null;
                                    this.prenom = null;
                                    this.mail = null;
                                    this.phone = "";
                                    return true;
                                } ).catch( error => console.log( error ) );
                            }
                        },
                        checkForm() {
                            if (this.name === null) {
                                this.errors.push('Le nom est requis.');
                            }
                            if (this.prenom === null) {
                                this.errors.push('Le prénom est requis.');
                            }
                            if (this.phone === null) {
                                this.errors.push('Le numéro de téléphone est requis.');
                            }
                            if (this.mail === null) {
                                this.errors.push('L\'adresse mail est requise.');
                            } else if (!this.validEmail(this.mail)) {
                                this.errors.push('L\'adresse mail n\'est pas valide.');
                            }
                            if (this.chambreSelect === null) {
                                this.errors.push('La chambre est requise.');
                            }
                            if (this.selectedOptions.length === 0) {
                                this.errors.push('Les options sont requises.');
                            }
                            if (this.adresse === null) {
                                this.errors.push('L\'adresse est requise.');
                            }
                            if (this.postale === null) {
                                this.errors.push('Le code postal est requis.');
                            }
                            if (this.ville === null) {
                                this.errors.push('La ville est requise.');
                            }
                            if (this.naissance === null) {
                                this.errors.push('La date de naissance est requise.');
                            }
                            if (this.assurance === null) {
                                this.errors.push("Nous avons besoin de savoir si vous souhaitez l'assurance.");
                            }
                            if (this.errors.length > 0) {
                                return false;
                            }
                            return true;
                        },
                        validEmail ( email ) {
                            const re =
                                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            return re.test( email );
                        },
                        handleClick () {
                            for ( let i = 0; i < this.options.option.length; i++ ) {
                                if ( this.options.quantity[ i ] > 0 ) {
                                    this.selectedOptions.push( {
                                        name: this.options.option[ i ], quantity: this
                                            .options.quantity[ i ]
                                    } )
                                }
                            }
                            this.showTempForm = !this.showTempForm
                        },
                        tempFunction () {
                            this.typeChamber.chambre = <?= json_encode( $chambre ); ?>;
                            this.typeChamber.price = <?= json_encode( $price ); ?>;
                            this.options.option = <?= json_encode( $option ); ?>;
                            this.options.price = <?= json_encode( $price_option ); ?>;
                            this.options.option.forEach( option => {
                                this.options.quantity.push( 0 );
                            } )
                            for ( let i = 0; i < this.options.option.length; i++ ) {
                                this.options.currentPrice.push( this.options.quantity[ i ] * this.options.price[ i ] );
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
                        },
                        handleChamberPrice ( e ) {
                            this.typeChamber.chambre.forEach( chambre => {
                                if ( chambre === e.target.value ) {
                                    this.chamberPrice = this.typeChamber.price[ this.typeChamber.chambre.indexOf(
                                        chambre ) ]
                                    this.totalChamberPrice = this.chamberPrice
                                }
                            } )
                        },
                        handleOptionPrice ( index ) {
                            this.options.currentPrice[ index ] = this.options.quantity[ index ] * this.options.price[ index ]
                            this.optionsPrice = 0;
                            this.options.currentPrice.forEach( price => {
                                this.optionsPrice += Number( price )
                            } )
                        }
                    },
                    watch: {
                        numberParticipant ( val ) {
                            this.totalChamberPrice = Number( this.chamberPrice ) * Number( val )
                        },
                        optionsPrice ( val ) {
                            this.totalPrice = Number( this.totalChamberPrice ) + Number( val )
                        },
                        totalChamberPrice ( val ) {
                            this.totalPrice = Number( val ) + Number( this.optionsPrice )
                        }
                    }
                } ).mount( '#root' );


            </script>

		<?php endwhile; // end of the loop. ?>
    </main>

<?php get_footer(); ?>