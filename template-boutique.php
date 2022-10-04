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
			$resume_product_list[]     = $resume_product;
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
        <div :class="filteredData.length > 0 ? 'container-narrow' : 'no-answer container-narrow'">
            <div class="voyages-card" v-for="(voyage, index) in filteredData.slice(sliceA, sliceB)" :key="index">
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
                            <a :href="voyage.permalink" class="departs" v-for="(date, index) in voyage.dates.slice(0,
                             3)" :key="index">
                                {{date}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="no-voyage" v-if="filteredData.length == 0">
                <h4>Aucun voyage ne semble correspondre à votre recherche pour l'instant</h4>
                <p>N'hésitez pas à modifier votre recherche ou à repassez plus tard !</p>
                <div class="return-clear">
                    <a href="<?= get_home_url( '/' ) ?>">Revenir à l'accueil</a>
                    <button class="clear" @click="resetForm()">Réinitialiser la recherche</button>
                </div>
            </div>

            <div class="pagination" v-if="data">
                <ul>
                    <li class="prev" @click="handlePrev()">
                        <span class="screen-reader-text">Précédent</span>
                    </li>
                    <li v-for="pageNumber in pagination" :key="pageNumber" :class=" pageNumber === currentPage ?
                    'page-number current' : 'page-number'" @click="handlePageClick($event)">{{pageNumber}}
                    </li>
                    <li class="next" @click="handleNext">
                        <span class="screen-reader-text">Suivant</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="gift-card">
        <div class="container-narrow">
            <div class="gift-card__container">
                <div class="bleu-glacie__bg"></div>
                <ul class="bg">
                    <li>
                        <img src="<?= get_template_directory_uri(); ?>/assets/creer-du-lien-social.svg" alt="Mains
                                levées avec un coeur à l'intérieur">
                    </li>
                    <li>
                        <img src="<?= get_template_directory_uri(); ?>/assets/acteurs-locaux.svg" alt="Illustration
                                d'un sac à dos">
                    </li>
                    <li>
                        <img src="<?= get_template_directory_uri(); ?>/assets/ressourcer.svg" alt="Illustration
                                d'arbre">
                    </li>
                    <li>
                        <img src="<?= get_template_directory_uri(); ?>/assets/repondre-aux-challenges-de-la-vie.svg"
                             alt="Illustration d'une montagne">
                    </li>
                    <li>
                        <img src="<?= get_template_directory_uri(); ?>/assets/decouverte-monde.svg" alt="Illustration
                                 d'une paire de jumelle">
                    </li>
                    <li>
                        <img src="<?= get_template_directory_uri(); ?>/assets/societe-ethique.svg" alt="Illustration
                                de la planète terre">
                    </li>

                    <li class="unused">
                        <img src="<?= get_template_directory_uri(); ?>/assets/creer-du-lien-social.svg" alt="Mains
                                levées avec un coeur à l'intérieur">
                    </li>
                    <li class="unused">
                        <img src="<?= get_template_directory_uri(); ?>/assets/acteurs-locaux.svg" alt="Illustration
                                d'un sac à dos">
                    </li>
                    <li class="unused">
                        <img src="<?= get_template_directory_uri(); ?>/assets/ressourcer.svg" alt="Illustration
                                d'arbre">
                    </li>
                    <li class="unused">
                        <img src="<?= get_template_directory_uri(); ?>/assets/repondre-aux-challenges-de-la-vie.svg"
                             alt="Illustration d'une montagne">
                    </li>
                    <li class="unused">
                        <img src="<?= get_template_directory_uri(); ?>/assets/decouverte-monde.svg" alt="Illustration
                                 d'une paire de jumelle">
                    </li>
                    <li class="unused">
                        <img src="<?= get_template_directory_uri(); ?>/assets/societe-ethique.svg" alt="Illustration
                                de la planète terre">
                    </li>
                </ul>
                <div class="content">
                    <h3>Carte cadeau</h3>
                    <p><?php the_field( 'carte_cadeau_texte' ); ?></p>
					<?php
					if ( get_field( 'carte_cadeau_lien' ) ) :
						$link = get_field( 'carte_cadeau_lien' );
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
                        <a href="<?= esc_url( $link['url'] ); ?>"
                           target="<?= esc_attr( $link_target ) ?>"><?= esc_html( $link['title'] );
							?></a>
					<?php endif; ?>
                </div>
            </div>
            <div class="arrow-up">
                <p class="moon-flower">Ca c'est gentil</p>
                <img src="<?= get_template_directory_uri() ?>/assets/fleche.svg" alt="Flèche pointant vers le haut">
            </div>
        </div>
    </section>
	<?php get_template_part( 'parts/instagram' ); ?>

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
                    selectedDuree: 'Durée du voyage',
                    selectedStyle: 'Style de voyage',
                    selectedPeriode: 'Période',
                    pagination: [],
                    currentPage: 1,
                    sliceA: 0,
                    sliceB: 9,
                    step: 9,
                }
            },
            computed: {
                filteredData () {
                    let duration;
                    let style;
                    let period;
                    if ( this.selectedDuree === 'Durée du voyage' ) {
                        duration = '';
                    } else {
                        duration = this.selectedDuree;
                    }
                    if ( this.selectedStyle === 'Style de voyage' ) {
                        style = ''
                    } else {
                        style = this.selectedStyle;
                    }
                    if ( this.selectedPeriode === 'Période' ) {
                        period = '';
                    } else {
                        period = this.selectedPeriode;
                    }
                    return this.data.filter( ( voyage ) => {
                        return voyage.jours.toLowerCase().includes( duration.toLowerCase() ) && voyage.thematique
                            .toLowerCase().includes( style.toLowerCase() ) && voyage.dates[ 0 ]?.toLowerCase().includes
                        ( period.toLowerCase() ) || voyage.jours.toLowerCase().includes( duration.toLowerCase() ) && voyage.thematique
                            .toLowerCase().includes( style.toLowerCase() ) && voyage.dates[ 1 ]?.toLowerCase().includes
                        ( period.toLowerCase() ) || voyage.jours.toLowerCase().includes( duration.toLowerCase() ) && voyage.thematique
                            .toLowerCase().includes( style.toLowerCase() ) && voyage.dates[ 2 ]?.toLowerCase().includes
                        ( period.toLowerCase() )
                    } );
                }
            },
            async mounted () {
                await this.getData();
                await this.splitData();
                await this.setPagination();
                this.selectDuree = this.duree[ 0 ];
                this.selectedStyle = this.style[ 0 ];
                this.selectedPeriode = this.periode[ 0 ];
            },
            methods: {
                handlePrev () {
                    if ( this.sliceA > 0 ) {
                        this.currentPage--;
                        this.sliceA -= this.step;
                        this.sliceB -= this.step;
                    }
                },
                handlePageClick (event) {
                    this.currentPage = event.target.innerText;
                    this.sliceA = ( this.currentPage - 1 ) * this.step;
                    this.sliceB = this.currentPage * this.step;
                },
                handleNext () {
                    if ( this.sliceB < this.data.length ) {
                        this.currentPage++;
                        this.sliceA += this.step;
                        this.sliceB += this.step;
                    }
                },
                setPagination () {
                    let pagination = [];
                    let pages = Math.ceil( this.filteredData.length / this.step );
                    for ( let i = 1; i <= pages; i++ ) {
                        pagination.push( i );
                    }
                    this.pagination = pagination;
                },
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
                resetForm () {
                    this.selectedDuree = 'Durée du voyage';
                    this.selectedStyle = 'Style de voyage';
                    this.selectedPeriode = 'Période';
                }
            }
        } ).mount( '#boutique' );
    </script>
</main>

<?php get_footer(); ?>
