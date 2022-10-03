<?php
get_header(); ?>

    <main class="product" id="root">
		<?php while ( have_posts() ) :
			the_post();
            $template = get_field('template_produit');

            if ( $template !== 'Gift Card' ) {
                get_template_part( 'parts/basic-product' );
            } else {
                get_template_part( 'parts/gift-card' );
            }

		endwhile; // end of the loop. ?>
    </main>

<?php get_footer(); ?>