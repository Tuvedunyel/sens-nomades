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
				<h1 class="account-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>
