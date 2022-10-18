<?php get_header(); ?>

    <main id="not-found">
        <div class="container-narrow">
            <h1>Page non trouvée - erreur 404 Pffff !</h1>
            <div class="randonneur">
                <img src="<?= get_template_directory_uri() ?>/assets/randonneur-black.svg" alt="Petit randonneur">
                <p>Ah... C'est embêtant !</p>
                <img src="<?= get_template_directory_uri() ?>/assets/fleche.svg" alt="Flèche pointant vers le haut">
            </div>
            <strong>Oups... La page que vous cherchez n'existe plus ou n'a jamais existé.</strong>
            <div class="btn__container">
                <a href="<?= home_url(); ?>" class="btn home-btn">Revenir à l'accueil</a>
				<?php $link = get_field('page_nos_voyages'); ?>
                <a href="<?= esc_url($link['url']); ?>" class="btn voyages-btn">Je veux voyager</a>
            </div>
        </div>
    </main>

<?php get_footer(); ?>