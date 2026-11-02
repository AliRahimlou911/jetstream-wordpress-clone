<?php
get_header();
?>
<section class="mx-auto max-w-3xl px-5 py-20 sm:px-8">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="border-b border-sky/40 py-8">
				<h2 class="font-display text-3xl font-medium text-ink"><a class="hover:text-sea" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="jet-prose mt-3"><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
		<div class="jet-prose mt-8"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p class="text-lg text-ink-soft">Nothing found.</p>
	<?php endif; ?>
</section>
<?php
get_footer();
