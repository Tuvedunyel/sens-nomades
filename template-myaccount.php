<?php
/*
 * Template Name: My Account
 */
get_header();
?>
<main class="pages">
    <section class="pages-section" id="account">
        <div class="container-narrow pages-container">
            <section class="content">
				<?php the_content(); ?>
            </section>
			<?php get_template_part( 'parts/left-part-page' ); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
