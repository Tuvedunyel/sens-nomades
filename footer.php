<footer>
    <section class="footer-container">
        <div class="container-narrow">
			<?php $logo_blanc = get_field( 'logo_blanc', 'option' ); ?>
            <a href="<?= home_url( $path = '/', $scheme = 'https' ); ?>" title="Retour à l'accueil" class="footer-home">
                <img src="<?= esc_url( $logo_blanc['url'] ); ?>" alt="<?= esc_attr( $logo_blanc['alt'] ); ?>">
            </a>
            <div class="left">
                <h4><?php the_field( 'titre_un', 'option' ); ?></h4>
                <p><?php the_field( 'texte', 'option' ); ?></p>
            </div>
            <div class="middle">
                <h4><?php the_field( 'titre_deux', 'option' ); ?></h4>
				<?php wp_nav_menu( array(
					'theme_location' => 'footer-main',
					'container'      => 'nav',
					'menu_id'        => 'footer-menu',
					'fallback_cb'    => false,
				) ); ?>
            </div>
            <div class="right">
                <h4><?php the_field( 'titre_trois', 'option' ); ?></h4>
				<?php if ( have_rows( 'reseaux_sociaux', 'option' ) ) : ?>
                    <ul class="socials-network">
						<?php while ( have_rows( 'reseaux_sociaux', 'option' ) ) : the_row(); ?>
                            <li>
								<?php $link = get_sub_field( 'lien' ); ?>
                                <a href="<?= esc_url( $link['url'] ); ?>" title="<?= esc_html( $link['title'] ); ?>"
                                   target="<?= esc_attr( $link['target'] ); ?>">
									<?php $rs_image = get_sub_field( 'image' ) ?>
                                    <img src="<?= esc_url( $rs_image['url'] ); ?>" alt="<?= esc_attr(
										$rs_image['alt'] );
									?>">
                                </a>
                            </li>
						<?php endwhile; ?>
                    </ul>
                    <aside>
                        <a href="<?php the_field( 'lien_contact', 'option' ); ?>" class="contact__image">
							<?php $contact_image = get_field( 'contact_image', 'option' ); ?>
                            <img src="<?= esc_url( $contact_image['url'] ); ?>"
                                 alt="<?= esc_attr( $contact_image['alt'] );
							     ?>">
                        </a>
                        <a href="<?php the_field( 'lien_contact', 'option' ); ?>" class="contact_texte">
							<?php the_field( 'texte_contact', 'option' ); ?>
                        </a>

                        <div class="vignettes">
							<?php if ( have_rows( 'vignettes', 'option' ) ) : ?>
                                <ul class="vignettes__container">
									<?php while ( have_rows( 'vignettes', 'option' ) ) : the_row(); ?>
                                        <li>
											<?php $vignettes = get_sub_field( 'image' ); ?>
                                            <img src="<?= esc_url( $vignettes['url'] ) ?>"
                                                 alt="<?= esc_attr( $vignettes['alt'] );
											     ?>">
                                        </li>
									<?php endwhile; ?>
                                </ul>
							<?php endif; ?>
                            <div class="immatriculation"><?php the_field('immatriculation', 'option'); ?></div>
                        </div>
                    </aside>
				<?php endif; ?>
            </div>
        </div>
    </section>
    <section class="legals">
        <div class="container-narrow">
	        <?php wp_nav_menu( array(
		        'theme_location' => 'legals',
		        'container'      => 'nav',
		        'menu_id'        => 'legals-menu',
		        'fallback_cb'    => false,
	        ) ); ?>
            <aside class="realiser">
                <p>Site réalisé par : <a href="https://www.btg-communication.fr" target="_blank">btg
                        communication</a></p>
            </aside>
        </div>
    </section>
</footer>
<?php wp_footer(); ?>
</body>
</html>