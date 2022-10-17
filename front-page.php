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
                <div class="voyages-card" v-for="(voyage, index) in posts.slice(0, 3)" :key="index">
                    <div class="voyages-card__thumbnail">
                        <p class="jours">{{voyage.jours}}</p>
                        <p class="prix">{{voyage.prix}}€</p>
                        <a :href="voyage.permalink" class="image" v-html="voyage.image"></a>
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
        </div>
    </section>
    <script>

        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    posts: null
                }
            },
            async mounted () {
                await this.getPost();
            },
            methods: {
                getPost () {
                    this.posts = <?= json_encode( $resume_product_list ) ?>;
                }
            }
        } ).mount( '#front' );
    </script>
</main>

<?php get_footer(); ?>
