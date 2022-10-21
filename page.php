<?php
get_template_part( 'parts/hero-wave' );
?>
    <section class="pages-section">
        <div class="container-narrow pages-container">
            <section class="content">
                <?php $randonneur = get_field( 'randonneur' );
                if ( $randonneur === 'Oui' ) :
                    ?>
                    <div class="randonneur">
                        <img src="<?= get_template_directory_uri(); ?>/assets/fleche.svg" alt="Flèche en pointillet allant vers
                le bas" class="fleche-randonneur__top">
                        <p><?php the_field( 'texte_randonneur' ); ?></p>
                        <img src="<?= get_template_directory_uri(); ?>/assets/randonneur-black.svg" alt="Petit personnage
                marchant avec une canne de marche et un sac de voyage" class="randonneur__top">
                    </div>
                <?php endif; ?>
                <article>
                    <?php the_content(); ?>
                </article>
            </section>

            <?php get_template_part( 'parts/left-part-page' ); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
