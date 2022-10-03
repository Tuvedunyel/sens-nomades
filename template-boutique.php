<?php
/*
  * Template Name: Boutique
  */
get_header();

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
		if ( $categories[0]->name !== 'Options' ) :
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
			$resume_product_list[] = $resume_product;
		endif;

	endwhile;
	wp_reset_postdata(); endif;
json_encode( $resume_product_list );


?>

<main id="boutique">
    <section class="hero-banner">
        <div class="container-narrow">
            <div class="hero-banner__content">
                <h1><?php the_title(); ?></h1>
            </div>
            <div class="dynamic-search">
                <div class="arrow-select">
                    <select name="duree" id="duree" v-model="selectedDuree">
                        <option v-for="(jours, index) in duree" :key="index" :value="jours">{{jours}}</option>
                    </select>
                </div>
                <div class="arrow-select">
                    <select name="style" id="style" v-model="selectedStyle">
                        <option v-for="(voyage, index) in style" :key="index" :value="voyage">{{voyage}}</option>
                    </select>
                </div>
                <div class="arrow-select">
                    <select name="periode" id="periode" v-model="selectedPeriode">
                        <option v-for="(saison, index) in periode" :key="index" :value="saison">{{saison}}</option>
                    </select>
                </div>
                <button class="reset" @click="resetForm()" v-html="btn"></button>
            </div>
        </div>
    </section>
    <article>
        <div class="container-narrow">
            <div class="randonneur moon-flower">
                <img src="<?= get_template_directory_uri() ?>/assets/randonneur-black.svg" alt="Petit randonneur">
                <p><?php the_field( 'texte_randonneur' ); ?></p>
                <img src="<?= get_template_directory_uri() ?>/assets/fleche.svg" alt="Flèche pointant vers le haut">
            </div>
			<?php the_content(); ?>
        </div>
    </article>
    <section class="nos-voyages" v-if="data">
        <div class="container-narrow">
            <div class="voyages-card" v-for="(voyage, index) in data" :key="index">
                <div class="voyages-card__thumbnail">
                    <p class="jours">{{voyage.jours}}</p>
                    <p class="prix">{{voyage.prix}}€</p>
                    <div class="image" v-html="voyage.image"></div>
                </div>
                <div class="voyages-card__bottom">
                    <div class="icon-container">
                        <img :src="voyage.tags.url" :alt="voyage.tags.alt">
                    </div>
                    <h3>{{voyage.titre}}</h3>
                    <p class="thematique">{{voyage.thematique}}</p>
                    <div class="prochain-depart">
                        <strong>Prochain(s) départ(s)</strong>
                        <div class="dates">
                            <a :href="voyage.permalink" class="departs" v-for="(date, index) in voyage.dates"
                               :key="index">
                                {{date}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    data: null,
                    duree: [ 'Durée du voyage' ],
                    style: [ 'Style de voyage' ],
                    periode: [ 'Période', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août',
                        'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
                    btn: 'X',
                    selectedDuree: 'Duréee du voyage',
                    selectedStyle: 'Style de voyage',
                    selectedPeriode: 'Période',
                }
            },
            mounted () {
                this.getData();
                this.splitData();
                this.selectDuree = this.duree[ 0 ];
                this.selectedStyle = this.style[ 0 ];
                this.selectedPeriode = this.periode[ 0 ];
            },
            methods: {
                getData () {
                    this.data = <?= json_encode( $resume_product_list ); ?>;
                },
                splitData () {
                    this.data.forEach( ( item ) => {
                        if ( !this.duree.includes( item.jours ) ) {
                            this.duree.push( item.jours );
                        }
                        if ( !this.style.includes( item.thematique ) ) {
                            this.style.push( item.thematique );
                        }
                    } );
                },
                resetForm() {
                    this.selectedDuree = 'Durée du voyage';
                    this.selectedStyle = 'Style de voyage';
                    this.selectedPeriode = 'Période';
                }
            }
        } ).mount( '#boutique' );
    </script>
</main>

<?php get_footer(); ?>
