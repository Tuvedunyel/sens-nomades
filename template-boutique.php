<?php
/*
  * Template Name: Boutique
  */
get_header(); ?>

<main id="boutique">
    <section class="hero-banner">
        <div class="container-narrow">
            <div class="hero-banner__content">
                <h1><?php the_title(); ?></h1>
            </div>
            <div class="dynamic-search">
                <div class="arrow-select">
                    <select name="duree" id="duree">
                        <option v-for="(jours, index) in duree" :key="index" :value="jours">{{jours}}</option>
                    </select>
                </div>
                <div class="arrow-select">
                    <select name="style" id="style">
                        <option v-for="(voyage, index) in style" :key="index" :value="voyage">{{voyage}}</option>
                    </select>
                </div>
                <div class="arrow-select">
                    <select name="periode" id="periode">
                        <option v-for="(saison, index) in periode" :key="index" :value="saison">{{saison}}</option>
                    </select>
                </div>
                <button class="reset" v-html="btn"></button>
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

    <script>
        const { createApp } = Vue;

        createApp( {
            data () {
                return {
                    duree: [ 'Durée du voyage' ],
                    style: [ 'Style de voyage' ],
                    periode: [ 'Période' ],
                    btn: 'X'
                }
            }
        } ).mount( '#boutique' );
    </script>
</main>

<?php get_footer(); ?>
