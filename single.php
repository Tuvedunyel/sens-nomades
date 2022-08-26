<?php get_header(); ?>

<main class="single-blog">
    <section class="hero-banner">
        <div class="container-narrow">
            <h2>Les actualités <span>Sens nomades</span></h2>
        </div>
    </section>
    <article>
        <div class="container-narrow">
            <h1><?php the_title(); ?></h1>
            <ul class="categories">
				<?php wp_list_categories( array(
					'orderby'    => 'name',
					'title_li'   => '',
					'show_count' => false,
				) ) ?>
            </ul>
            <section class="top">
				<?php $image_top = get_field( 'image_haut_de_page' ); ?>
                <img src="<?= esc_url( $image_top['url'] ); ?>" alt="<?= esc_attr( $image_top['alt'] ); ?>">
            </section>
            <section class="content">
                <?php the_content(); ?>
            </section>
        </div>
    </article>
</main>

<?php get_footer(); ?>
