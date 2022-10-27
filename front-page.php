<?php get_header();

class Resume_product {
	public $jours;
	public $prix;
	public $titre;
	public $image;
	public $tags;
	public $thematique;
	public $dates;
	public $permalink;
	public $longitude;
	public $latitude;
	public $price;
	public $link;
	public $days;
}

$resume_product_list = [];

$args = array(
	'post_type'      => 'product',
	'posts_per_page' => - 1,
	'orderby'        => 'title',
	'order'          => 'ASC',
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
	while ( $query->have_posts() ) :
		$query->the_post();
		$categories = get_the_terms( $post->ID, 'product_cat' );
		$recommande = get_field( 'produit_recommande' );
		if ( $categories[0]->name !== 'Options' && $recommande == 'Oui' ) :
			$resume_product             = new Resume_product();
			$resume_product->jours      = get_field( 'nombre_de_jours' );
			$resume_product->prix       = get_field( 'price' );
			$resume_product->titre      = get_the_title();
			$resume_product->image      = get_the_post_thumbnail();
			$resume_product->tags       = get_field( 'tag_image' );
			$resume_product->thematique = get_field( 'thematique' );
			if ( have_rows( 'dates_resume' ) ) :
				while ( have_rows( 'dates_resume' ) ) : the_row();
					$resume_product->dates[] = get_sub_field( 'date' );
				endwhile; endif;
			$resume_product->permalink = get_permalink();
			$resume_product->longitude = get_field( 'longitude' );
			$resume_product->latitude  = get_field( 'latitude' );
			$resume_product->price     = get_field( 'price' );
			$resume_product->link      = get_the_permalink();
			$resume_product->tags      = get_field( 'tag_image' );
			$resume_product->days      = get_field( 'nombre_de_jours' );
			$resume_product_list[]     = $resume_product;
		endif;

	endwhile;
	wp_reset_postdata(); endif;
json_encode( $resume_product_list );
?>

<main id="front">
    <section class="hero-banner">
		<?php $haut_page_image = get_field( 'image_haut_page' ); ?>
        <img src="<?= esc_url( $haut_page_image['url'] ) ?>" alt="<?= esc_attr( $haut_page_image['alt'] ); ?>">
        <h1 class="screen-reader-text"><?php the_title(); ?></h1>
    </section>
    <section class="recommanded-travel">
        <div class="container-narrow">
			<?php the_content(); ?>

            <div class="travel__container" v-if="posts">
                <div class="voyages-card" v-for="(voyage, index) in postsRender" :key="index">
                    <div class="voyages-card__thumbnail">
                        <p class="jours">{{voyage.jours}}</p>
                        <p class="prix">{{voyage.prix}}€</p>
                        <a :href="voyage.permalink" :title="`Se rendre sur la page ${voyage.titre}`" class="image" v-html="voyage.image"></a>
                        <div class="icon-container">
                            <img :src="voyage.tags.url" :alt="voyage.tags.alt">
                        </div>
                    </div>
                    <div class="voyages-card__bottom">
                        <h3><a :href="voyage.permalink">{{voyage.titre}}</a></h3>
                        <p class="thematique">{{voyage.thematique}}</p>
                        <div class="prochain-depart">
                            <strong>Prochain(s) départ(s)</strong>
                            <div class="dates">
                                <a :href="voyage.permalink" class="departs" v-for="(date, index) in voyage.dates.slice(0,
                             3)" :key="index">
                                    {{date}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="no-voyage" v-else>
                <h4>Aucun voyage ne semble correspondre à votre recherche pour l'instant</h4>
                <p>N'hésitez pas à modifier votre recherche ou à repassez plus tard !</p>
                <div class="return-clear">
                    <a href="<?= get_home_url( '/' ) ?>">Revenir à l'accueil</a>
                    <button class="clear" @click="resetForm()">Réinitialiser la recherche</button>
                </div>
            </div>
            <div class="voyages-link">
                <?php $voyages_link = get_field('page_nos_voyages', 'options') ?>
                <a href="<?= esc_url($voyages_link['url']); ?>" class="btn voyages-btn"><?= esc_html
                    ($voyages_link['title']); ?></a>
            </div>
        </div>
    </section>
    <section class="map">
        <div class="link-to">
			<?php the_field( 'texte_dessus_carte' ); ?>
			<?php $lien_carte  = get_field( 'lien_vers_carte' );
			$lien_carte_target = $lien_carte['target'] ? $lien_carte['target'] : '_self';
			?>
            <a href="<?= esc_url( $lien_carte['url'] ); ?>" target="<?= esc_attr( $lien_carte_target ); ?>" class="btn
            btn-to-map"><?=
				esc_html
				( $lien_carte['title'] );
				?></a>
        </div>
        <div id="map-container"></div>
    </section>

    <section class="privatiser-area">
        <div class="container-narrow">
            <div class="privatiser__content">
                <strong><?php the_field( 'texte_privatiser' ); ?></strong>
				<?php $lien_privatiser  = get_field( 'lien_privatiser' );
				$lien_privatiser_target = $lien_privatiser['target'] ? $lien_privatiser['target'] : '_self';
				?>
                <a href="<?= esc_url( $lien_privatiser['url'] ); ?>" target="<?= esc_attr( $lien_carte_target ); ?>"><?=
					esc_html
					( $lien_privatiser['title'] );
					?></a>
            </div>
            <div class="randonneur">
                <img src="<?= get_template_directory_uri() ?>/assets/randonneur-black.svg" alt="Petit randonneur">
                <div><?php the_field( 'texte_randonneur' ); ?></div>
                <img src="<?= get_template_directory_uri() ?>/assets/fleche.svg" alt="Flèche en pointillet noir
                pointant vers le haut">
            </div>
        </div>
    </section>

    <section class="directions" v-if="isLoad">
        <div class="container-narrow">
            <h2><?php the_field( 'titre_direction' ); ?></h2>
			<?php if ( have_rows( 'directions' ) ) :
				class Directions {
					public $image;
					public $titre;
					public $texte;
				}

				$direction_array = [];
				?>
                <div class="directions__container">
					<?php while ( have_rows( 'directions' ) ) : the_row();
						$direction        = new Directions();
						$direction->image = get_sub_field( 'image' );
						$direction->titre = get_sub_field( 'titre' );
						$direction->texte = get_sub_field( 'texte' );

						$direction_array[] = $direction;
					endwhile;
					?>
                    <div class="direction" v-for="(direction, index) in directions" :key="index">
                        <img :src="direction.image.url" :alt="direction.image.alt" class="illustration">
                        <h3>{{direction.titre}}</h3>
                        <div class="open">
                            <img src="<?= get_template_directory_uri() ?>/assets/open.svg" alt="Ouvrir le détail"
                                 class="open" @click="toggleElement(index)" v-if="!directionsShow[index].show">
                            <img src="<?= get_template_directory_uri() ?>/assets/close.svg" alt="Fermer le détail"
                                 class="close" @click="toggleElement(index)" v-if="directionsShow[index].show">
                        </div>
                        <div class="texte-direction" v-if="directionsShow[index].show">
                            <p>{{direction.texte}}</p>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
        </div>
    </section>

    <section class="actualites">
        <div class="container-narrow">
            <h2><?php the_field( 'titre_actualites' ); ?></h2>
            <p><?php the_field( 'texte_actualites' ); ?></p>
			<?php
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => 2,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) :
				?>
                <div class="card-container">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <div class="articles__card">
                            <div class="card__thumbnail">
								<?php the_post_thumbnail(); ?>
                            </div>
                            <div class="card__content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>">Lire la suite</a>
                            </div>
                        </div>
					<?php endwhile;
					wp_reset_postdata(); ?>
                </div>
			<?php endif;
			$lien_actu        = get_field( 'page_darticles', 'option' );
			$lien_actu_target = $lien_actu['target'] ? $lien_actu['target'] : '_self';
			?>
            <a href="<?= esc_url( $lien_actu['url'] ); ?>" class="btn btn-actu"
               target="<?= esc_attr( $lien_actu_target ); ?>">Tous nos articles</a>
        </div>
    </section>

	<?php get_template_part( 'parts/instagram' ); ?>

    <section class="avis">
        <div class="container-narrow">
            <h2><?php the_field( 'titre_avis' ); ?></h2>
			<?php if ( have_rows( 'avis' ) ) : ?>
                <div class="avis__container">
					<?php while ( have_rows( 'avis' ) ) : the_row(); ?>
                        <div class="avis-card">
							<?php $image = get_sub_field( 'image' ); ?>
                            <img src="<?= esc_url( $image['url'] ); ?>" alt="<?= esc_attr( $image['alt'] ); ?>">
                        </div>
					<?php endwhile; ?>
                </div>
			<?php endif; ?>
        </div>
    </section>
    <script>

        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    posts: null,
                    map: null,
                    products: null,
                    markerIcon: L.icon( {
                        iconUrl: '<?= get_stylesheet_directory_uri(); ?>/assets/marker.svg',
                        iconSize: [ 38, 57 ],
                        iconAnchor: [ 22, 44 ],
                        popupAnchor: [ -3, -36 ]
                    } ),
                    directions: null,
                    directionsShow: [],
                    isLoad: false,
                    windowWidth: null,
                }
            },
            computed: {
                postsRender() {
                    if ( this.windowWidth >= 1400 ) {
                        return this.posts.slice( 0, 3 );
                    } else {
                        return this.posts.slice( 0, 4 );
                    }
                }
                },
                async mounted () {
                    await this.getPost();
                    await this.getDirections();
                    await this.setDirectionShow();
                    this.windowWidth = window.innerWidth;
                    this.map = L.map( 'map-container', {
                        attributionControl: false, dragging: false,
                        boxZoom: false, scrollWheelZoom: false, tap: false
                    } ).setView( [ 47.393, 2.739 ], 4 );
                    L.tileLayer( 'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    } ).addTo( this.map );
                    this.setMapPoints();
                    this.isLoad = true
                },
                methods: {
                    toggleElement ( index ) {
                        this.directionsShow[ index ].show = !this.directionsShow[ index ].show;
                    },
                    setDirectionShow () {
                        let index = 0;
                        this.directions.forEach( direction => {
                            this.directionsShow.push( {
                                index: index,
                                show: false
                            } );
                            index++;
                        } )
                    },
                    getDirections () {
                        this.directions = <?= json_encode( $direction_array ); ?>;
                    },
                    setMapPoints () {
                        this.posts.forEach( product => {
                            const marker = L.marker( [ Number( product.longitude ).toFixed( 4 ), Number( product.latitude
                            ).toFixed( 4 ) ], { icon: this.markerIcon } ).addTo( this.map );
                            marker.bindPopup( `<div class="marker-map"><div class="upper">${ product
                                .image }<div class="right-marker"><div class="fanion-container"><div
                            class="days-spend">${ product
                                .days }</div><div
                            class="price-marker">${ product.price }€</div></div><div class="theme__container"><div
                            class="image__picto"><img
                            src="${ product.tags[ 'url' ] }"alt="${ product.tags[ 'alt' ] }" title="${ product.title }"
                            /></div><p>${ product.thematique.replace( '- ', '' ) }</p></div></div></div><div
                            class="lower"><h4>${ product.titre }</h4><a href="${ product.link }"
                            target="_blank">Voir les dates</a></div></div>` );
                        } );
                    },
                    getPost () {
                        this.posts = <?= json_encode( $resume_product_list ) ?>;
                    }
                }
            } ).mount( '#front' );
    </script>
</main>

<?php get_footer(); ?>
