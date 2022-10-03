<?php if ( have_rows( 'posts_instagram', 'option' ) ) : ?>
    <section class="instagram-posts">
        <ul class="instagram-posts__list">
			<?php while ( have_rows( 'posts_instagram', 'option' ) ) : the_row(); ?>
	            <li>
                    <?php the_sub_field('post'); ?>
                </li>
			<?php endwhile; ?>
        </ul>
    </section>
<?php endif; ?>