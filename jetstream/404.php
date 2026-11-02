<?php
get_header();
?>
<section class="mx-auto flex max-w-xl flex-col items-center px-5 py-32 text-center">
	<?php echo jet_icon( 'life-buoy', 'h-14 w-14 text-coral' ); ?>
	<p class="mt-6 font-mono text-sm font-semibold tracking-widest text-sea">ERROR 404</p>
	<h1 class="mt-3 font-display text-5xl font-medium text-ink">Lost at sea</h1>
	<p class="mt-4 text-lg text-ink-soft">This page has drifted off our charts. Let's get you back to port.</p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mt-8 rounded-full bg-sea px-7 py-4 font-semibold text-white transition hover:bg-sea-deep">Back to home</a>
</section>
<?php
get_footer();
