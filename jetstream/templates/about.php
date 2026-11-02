<?php
/**
 * Template Name: About
 */
get_header();
the_post();
jet_page_hero();
$jet_styles = array(
	'serif'  => 'font-display text-2xl font-medium tracking-tight',
	'caps'   => 'font-sans text-sm font-bold uppercase tracking-[0.3em]',
	'italic' => 'font-display text-2xl italic',
	'heavy'  => 'font-sans text-xl font-bold tracking-tight',
);
?>
<section class="mx-auto grid max-w-7xl items-center gap-14 px-5 py-20 sm:px-8 md:grid-cols-2 md:py-24">
	<div class="relative">
		<img src="<?php echo esc_url( jet_opt( 'about_img1' ) ); ?>" alt="Cruise ship moored beside a whitewashed Mediterranean village" class="aspect-[4/5] w-full rounded-ticket object-cover" loading="lazy">
		<img src="<?php echo esc_url( jet_opt( 'about_img2' ) ); ?>" alt="Cruise ship sailing past an Alaskan glacier" class="absolute -bottom-8 -right-4 hidden w-2/5 rounded-ticket border-8 border-shell object-cover sm:block md:-right-8" loading="lazy">
	</div>
	<div>
		<h2 class="font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl"><?php echo jet_em( jet_opt( 'story_title' ) ); ?></h2>
		<div class="mt-6 space-y-5 text-lg leading-relaxed text-ink-soft"><?php the_content(); ?></div>
	</div>
</section>

<section class="bg-foam">
	<div class="mx-auto max-w-7xl px-5 py-20 sm:px-8 md:py-24">
		<h2 class="max-w-xl font-display text-4xl font-medium tracking-tight text-ink"><?php echo jet_em( jet_opt( 'care_title' ) ); ?></h2>
		<ul class="mt-12 grid gap-10 md:grid-cols-3">
			<?php foreach ( array( 1 => 'compass', 2 => 'heart-handshake', 3 => 'life-buoy' ) as $n => $icon ) : ?>
				<li class="border-t-2 border-sea pt-6">
					<?php echo jet_icon( $icon, 'h-7 w-7 text-sea' ); ?>
					<h3 class="mt-4 font-display text-2xl font-medium text-ink"><?php echo esc_html( jet_opt( "care{$n}_title" ) ); ?></h3>
					<p class="mt-3 leading-relaxed text-ink-soft"><?php echo esc_html( jet_opt( "care{$n}_text" ) ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
		<a href="<?php echo esc_url( jet_page_url( 'booking' ) ); ?>" class="mt-14 inline-flex rounded-full bg-sun px-7 py-4 font-semibold text-ink shadow-[0_3px_0_var(--color-sun-deep)] transition hover:-translate-y-0.5"><?php echo esc_html( jet_opt( 'care_button' ) ); ?></a>
	</div>
</section>

<section class="mx-auto max-w-7xl px-5 py-20 sm:px-8 md:py-28" aria-labelledby="partners-title">
	<div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
		<div>
			<p class="text-xs font-semibold uppercase tracking-[0.25em] text-sea"><?php echo esc_html( jet_opt( 'partners_eyebrow' ) ); ?></p>
			<h2 id="partners-title" class="mt-3 max-w-xl font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl"><?php echo jet_em( jet_opt( 'partners_title' ) ); ?></h2>
		</div>
		<p class="max-w-sm text-ink-soft"><?php echo esc_html( jet_opt( 'partners_text' ) ); ?></p>
	</div>
	<ul class="mt-14 grid grid-cols-2 gap-px overflow-hidden rounded-ticket border border-sky/70 bg-sky/70 sm:grid-cols-3 lg:grid-cols-4">
		<?php
		foreach ( jet_items( 'jet_partner' ) as $partner ) :
			$style = jet_meta( $partner, 'style' );
			?>
			<li class="group relative flex min-h-36 flex-col items-center justify-center bg-white px-5 py-8 text-center transition-colors duration-300 hover:bg-foam">
				<span class="absolute left-4 top-4 font-mono text-[0.6rem] font-semibold uppercase tracking-[0.25em] text-ink-soft/70 transition-colors group-hover:text-sea"><?php echo esc_html( jet_meta( $partner, 'kind' ) ); ?></span>
				<span class="text-ink-soft transition-colors duration-300 group-hover:text-ink <?php echo esc_attr( isset( $jet_styles[ $style ] ) ? $jet_styles[ $style ] : $jet_styles['serif'] ); ?>"><?php echo esc_html( $partner->post_title ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
	<p class="mt-6 text-sm text-ink-soft"><?php echo esc_html( jet_opt( 'partners_note' ) ); ?></p>
</section>
<?php
get_footer();
