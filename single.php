<?php get_header(); ?>

<main class="single-blog">
    <section class="hero-banner">
        <div class="container-narrow">
            <h2>Les actualités <span>Sens nomades</span></h2>
        </div>
    </section>
    <article>
        <a href="<?= home_url('/template-home.php'); ?>" class="return">&#10094; Retour aux actualités</a>
        <div class="container-narrow">
			<?php $categories = get_the_category(); ?>
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
            <div class="wrapper">
                <section class="content">
					<?php the_content(); ?>
                </section>
				<?php
				$args = array(
					'post_type'      => 'post',
					'posts_per_page' => 5,
					'post__not_in'   => array( $post->ID ),
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) :
					?>
                    <section class="articles">
                        <div class="title__articles">
                            <h2>Les dernières actualités</h2>
                        </div>
                        <div class="loop__articles">
							<?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                <div class="article">
                                    <a href="<?php the_permalink(); ?>">
                                        <p><?php the_title(); ?></p>
                                        <img src="<?= get_template_directory_uri() ?>/assets/open.svg" alt="Se rendre sur
                                     l'article">
                                    </a>
                                </div>
							<?php endwhile; ?>
                        </div>
                    </section>
					<?php wp_reset_postdata(); endif; ?>

            </div>
        </div>
    </article>

	<?php $categories__args = array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => array( $post->ID ),
		'category_name'  => $categories[0]->slug,
	);

	$categories__query = new WP_Query( $categories__args );

	if ( $categories__query->have_posts() ) : ?>
        <section class="same-theme">
            <div class="container-narrow">
                <h2>Sur le même thème</h2>
                <div class="card-container">
					<?php while ( $categories__query->have_posts() ) : $categories__query->the_post(); ?>
                        <div class="article__card">
                            <div class="card__thumbnail">
								<?php the_post_thumbnail('full'); ?>
                                <ul class="categories">
									<?php wp_list_categories( array(
										'orderby'    => 'name',
										'title_li'   => '',
										'show_count' => false,
									) ) ?>
                                </ul>
                            </div>
                            <div class="card__content">
                                <h3><?php the_title(); ?></h3>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>">Lire la suite</a>
                            </div>
                        </div>
					<?php endwhile; ?>
                </div>
            </div>
        </section>
		<?php wp_reset_postdata(); endif; ?>

</main>

<?php get_footer(); ?>
