<?php
$args = array(
	'post_type'      => 'post',
	'posts_per_page' => 5,
	'post__not_in'   => array( $post->ID ),
);

$query = new WP_Query( $args ); ?>

<div class="right-side">
	<?php if ( $query->have_posts() ) :
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
	<div class="bottom">
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
		</ul>
		<div class="bottom-wrapper">
			<h2>Pour aller plus loin</h2>
			<?php if ( have_rows( 'pour_aller_plus_loin' ) ) : ?>
				<ul class="lien">
					<?php while ( have_rows( 'pour_aller_plus_loin' ) ) : the_row(); ?>
						<?php $lien = get_sub_field( 'lien' ); ?>
						<li>
							<a href="<?= esc_url( $lien['url'] ); ?>"
							   target="<?= esc_attr( $lien['target'] );
							   ?>">
								<?= esc_html( $lien['title'] ); ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</div>
        <?php $encadrer_bas = get_field('encadrer_partie_gauche')
            if ( $encadrer_bas === 'Oui' ) : ?>
            <aside class="optionnal-rs">
                <h4><?php the_field('titre_un'); ?></h4>
                <h4><?php the_field('titre_deux'); ?></h4>
            </aside>
        <?php endif; ?>
	</div>
</div>