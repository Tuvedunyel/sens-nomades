<?php get_header(); ?>

    <div class="container-narrow search-page">
		<?php
		$s    = get_search_query();
		$args = array(
			's' => $s
		);
		// The Query
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			_e( "<h2 class='result'>Résultat de votre recherche :  " . get_query_var( 's' ) . "</h2>" ); ?>
            <ul class="results-container">
				<?php while ( $the_query->have_posts() ) {
					$the_query->the_post();
					?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
					<?php
				} ?>
            </ul>

		<?php else :
			?>
            <h2 class="result no-result">Aucun résultat</h2>
            <div class="alert alert-info">
                <p>Désolé, rien ne semble correspondre à votre recherche, essayez avec d'autres mots-clés</p>
				<a href="<?= home_url(); ?>" class="btn home-btn">Retour à l'accueil</a>
            </div>
		<?php endif; ?>
    </div>

<?php get_footer(); ?>