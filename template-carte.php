<?php
/*
 * Template Name: Carte
 */
get_header(); ?>

<main id="carte-page">
	<?php

	class Product {
		public $longitude;
		public $latitude;
		public $title;
		public $price;
		public $image;
		public $link;
		public $tags;
		public $days;
		public $thematique;
	}

	$product_list = [];

	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => - 1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) :
		while ( $loop->have_posts() ) : $loop->the_post();
			$categories = get_the_terms( $post->ID, 'product_cat' );
			if ( $categories[0]->name !== 'Options' ) :
				$product             = new Product();
				$product->longitude  = get_field( 'longitude' );
				$product->latitude   = get_field( 'latitude' );
				$product->title      = get_the_title();
				$product->price      = get_field( 'price' );
				$product->image      = get_the_post_thumbnail();
				$product->link       = get_the_permalink();
				$product->tags       = get_field( 'tag_image' );
				$product->days       = get_field( 'nombre_de_jours' );
				$product->thematique = get_field( 'thematique' );
				array_push( $product_list, $product );
			endif; endwhile; endif;
	$product_list = json_encode( $product_list );
	?>
    <span class="screen-reader-text"><?php the_title(); ?></span>
    <div id="map-container"></div>

    <script>
        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    map: null,
                    products: null,
                    markerIcon: L.icon( {
                        iconUrl: '<?= get_stylesheet_directory_uri(); ?>/assets/marker.svg',
                        iconSize: [ 38, 57 ],
                        iconAnchor: [ 22, 44 ],
                        popupAnchor: [ -3, -36 ]
                    } ),
                }
            },
            mounted () {
                this.getProducts();
                this.map = L.map( 'map-container' ).setView( [ 47.393, 2.739 ], 7 );
                L.tileLayer( 'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                } ).addTo( this.map );
                this.setMapPoints();
            },
            methods: {
                getProducts () {
                    this.products = <?php echo $product_list; ?>;
                },
                setMapPoints () {
                    this.products.forEach( product => {
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
                            class="lower"><h4>${ product.title }</h4><a href="${ product.link }"
                            target="_blank">Voir les dates</a></div></div>` );
                    } );
                }
            }
        } ).mount( '#carte-page' );

    </script>
</main>

<?php get_footer(); ?>
