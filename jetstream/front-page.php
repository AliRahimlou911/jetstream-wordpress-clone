<?php
get_header();
$jet_booking = jet_page_url( 'booking' );
?>
<section class="relative isolate overflow-hidden">
	<img src="<?php echo esc_url( jet_opt( 'hero_image' ) ); ?>" alt="White cruise ship sailing across turquoise water on a sunny morning" class="absolute inset-0 -z-20 h-full w-full object-cover" fetchpriority="high">
	<div class="absolute inset-0 -z-10 bg-gradient-to-r from-shell/95 via-shell/70 to-transparent"></div>
	<div class="mx-auto max-w-7xl px-5 pb-36 pt-20 sm:px-8 md:pb-48 md:pt-28">
		<div class="animate-rise mb-6 flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:gap-6">
			<img src="<?php echo esc_url( jet_opt( 'logo' ) ); ?>" alt="<?php echo esc_attr( jet_opt( 'brand_name' ) ); ?> logo" width="300" height="300" class="h-40 w-40 shrink-0 object-contain sm:h-[300px] sm:w-[300px]">
			<div>
				<p class="font-display text-3xl font-semibold tracking-tight text-ink sm:text-4xl"><?php echo esc_html( jet_opt( 'brand_name' ) ); ?></p>
				<p class="mt-1 text-sm font-semibold uppercase tracking-[0.3em] text-sea sm:text-base"><?php echo esc_html( jet_opt( 'brand_tagline' ) ); ?></p>
			</div>
		</div>
		<p class="animate-rise inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.25em] text-sea"><span class="h-2 w-2 rounded-full bg-sun" aria-hidden="true"></span><?php echo esc_html( jet_opt( 'hero_badge' ) ); ?></p>
		<h1 class="animate-rise mt-6 max-w-2xl font-display text-5xl font-medium leading-[1.02] tracking-tight text-ink [animation-delay:100ms] sm:text-6xl lg:text-7xl"><?php echo jet_em( jet_opt( 'hero_title' ) ); ?></h1>
		<p class="animate-rise mt-6 max-w-lg text-lg leading-relaxed text-ink-soft [animation-delay:200ms]"><?php echo esc_html( jet_opt( 'hero_text' ) ); ?></p>
		<div class="animate-rise mt-9 flex flex-wrap gap-4 [animation-delay:300ms]">
			<a href="<?php echo esc_url( $jet_booking ); ?>" class="group inline-flex items-center gap-2 rounded-full bg-sea px-7 py-4 font-semibold text-white shadow-lg shadow-sea/25 transition hover:bg-sea-deep"><?php echo esc_html( jet_opt( 'hero_btn1' ) ); ?><?php echo jet_icon( 'arrow-right', 'h-5 w-5 transition-transform group-hover:translate-x-1' ); ?></a>
			<a href="#destinations" class="inline-flex items-center rounded-full border-2 border-ink/15 bg-white/70 px-7 py-4 font-semibold text-ink transition hover:border-sea hover:text-sea"><?php echo esc_html( jet_opt( 'hero_btn2' ) ); ?></a>
		</div>
	</div>
	<div class="absolute inset-x-0 bottom-0"><?php echo jet_wave( 'h-12 text-shell md:h-20' ); ?></div>
</section>

<section id="destinations" class="mx-auto max-w-7xl scroll-mt-24 px-5 py-20 sm:px-8 md:py-28">
	<div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
		<div>
			<p class="text-xs font-semibold uppercase tracking-[0.25em] text-sea"><?php echo esc_html( jet_opt( 'dest_eyebrow' ) ); ?></p>
			<h2 class="mt-3 max-w-xl font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl"><?php echo jet_em( jet_opt( 'dest_title' ) ); ?></h2>
		</div>
		<p class="max-w-sm text-ink-soft"><?php echo esc_html( jet_opt( 'dest_text' ) ); ?></p>
	</div>
	<div class="mt-14 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
		<?php foreach ( jet_items( 'jet_destination' ) as $d ) : ?>
			<article class="group flex flex-col overflow-hidden rounded-ticket bg-white shadow-[0_1px_0_var(--color-sky),0_18px_40px_-24px_oklch(0.42_0.12_240/0.45)] transition duration-500 hover:-translate-y-1.5">
				<div class="relative aspect-[4/5] overflow-hidden">
					<?php
					echo get_the_post_thumbnail( $d, 'large', array(
						'class'   => 'h-full w-full object-cover transition duration-700 group-hover:scale-105',
						'loading' => 'lazy',
						'alt'     => 'Cruise ship in the ' . $d->post_title,
						'sizes'   => '(min-width: 1024px) 300px, (min-width: 640px) 50vw, 100vw',
					) );
					?>
					<span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 font-mono text-xs font-semibold tracking-widest text-sea"><?php echo esc_html( jet_meta( $d, 'code' ) ); ?></span>
				</div>
				<?php echo jet_ticket_divider(); ?>
				<div class="flex flex-1 flex-col px-6 pb-6">
					<h3 class="font-display text-2xl font-medium text-ink"><?php echo esc_html( $d->post_title ); ?></h3>
					<p class="mt-2 flex-1 text-[0.95rem] leading-relaxed text-ink-soft"><?php echo esc_html( jet_meta( $d, 'tagline' ) ); ?></p>
					<dl class="mt-5 grid grid-cols-2 gap-3 text-sm">
						<div>
							<dt class="flex items-center gap-1.5 text-xs uppercase tracking-wider text-ink-soft"><?php echo jet_icon( 'calendar-days', 'h-3.5 w-3.5' ); ?>Season</dt>
							<dd class="mt-1 font-semibold text-ink"><?php echo esc_html( jet_meta( $d, 'season' ) ); ?></dd>
						</div>
						<div>
							<dt class="flex items-center gap-1.5 text-xs uppercase tracking-wider text-ink-soft"><?php echo jet_icon( 'moon', 'h-3.5 w-3.5' ); ?>Length</dt>
							<dd class="mt-1 font-semibold text-ink"><?php echo esc_html( jet_meta( $d, 'nights' ) ); ?></dd>
						</div>
					</dl>
					<a href="<?php echo esc_url( add_query_arg( 'destination', $d->post_name, $jet_booking ) ); ?>" class="mt-6 inline-flex items-center justify-between rounded-full bg-foam px-5 py-3 font-semibold text-sea transition group-hover:bg-sea group-hover:text-white"><?php echo esc_html( jet_opt( 'dest_button' ) ); ?><?php echo jet_icon( 'arrow-up-right', 'h-5 w-5' ); ?></a>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section id="faq" class="mx-auto max-w-7xl scroll-mt-24 px-5 pb-20 sm:px-8 md:pb-28" aria-labelledby="faq-title">
	<div class="grid gap-12 border-t-2 border-dashed border-sky pt-16 md:pt-20 lg:grid-cols-[1fr_1.6fr] lg:gap-16">
		<div class="lg:sticky lg:top-28 lg:self-start">
			<p class="text-xs font-semibold uppercase tracking-[0.25em] text-sea"><?php echo esc_html( jet_opt( 'faq_eyebrow' ) ); ?></p>
			<h2 id="faq-title" class="mt-3 font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl"><?php echo jet_em( jet_opt( 'faq_title' ) ); ?></h2>
			<ul class="mt-8 space-y-3">
				<?php
				foreach ( jet_lines( jet_opt( 'faq_topics' ) ) as $line ) :
					$parts = array_map( 'trim', explode( '|', $line ) );
					?>
					<li class="flex items-center gap-3 text-ink">
						<span class="flex h-10 w-10 items-center justify-center rounded-full bg-foam text-sea"><?php echo jet_icon( isset( $parts[1] ) ? $parts[1] : 'anchor', 'h-5 w-5' ); ?></span>
						<span class="font-medium"><?php echo esc_html( $parts[0] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<p class="mt-8 max-w-xs text-ink-soft"><?php echo esc_html( jet_opt( 'faq_more' ) ); ?> <a href="<?php echo esc_url( jet_page_url( 'contact' ) ); ?>" class="font-semibold text-sea underline-offset-4 hover:underline"><?php echo esc_html( jet_opt( 'faq_link' ) ); ?></a>.</p>
		</div>
		<ul class="space-y-4" data-faq>
			<?php foreach ( jet_items( 'jet_faq' ) as $i => $faq ) : $open = 0 === $i; ?>
				<li class="rounded-ticket border-2 bg-white transition-colors duration-300 <?php echo $open ? 'border-sea' : 'border-sky/60 hover:border-sky'; ?>">
					<h3>
						<button type="button" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="faq-<?php echo (int) $i; ?>-panel" id="faq-<?php echo (int) $i; ?>-button" class="flex w-full items-center gap-4 rounded-ticket px-5 py-5 text-left sm:px-6">
							<span data-code class="shrink-0 rounded-full px-2.5 py-1 font-mono text-[0.65rem] font-semibold tracking-widest transition-colors <?php echo $open ? 'bg-sea text-white' : 'bg-foam text-sea'; ?>"><?php echo esc_html( jet_meta( $faq, 'code' ) ); ?></span>
							<span class="flex-1 font-display text-lg font-medium text-ink sm:text-xl"><?php echo esc_html( $faq->post_title ); ?></span>
							<?php echo jet_icon( 'plus', 'h-5 w-5 shrink-0 text-sea transition-transform duration-300' . ( $open ? ' rotate-45' : '' ) ); ?>
						</button>
					</h3>
					<div id="faq-<?php echo (int) $i; ?>-panel" role="region" aria-labelledby="faq-<?php echo (int) $i; ?>-button" class="grid transition-[grid-template-rows] duration-300 ease-out <?php echo $open ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'; ?>">
						<div class="overflow-hidden" <?php echo $open ? '' : 'inert'; ?>>
							<div class="space-y-3 border-t-2 border-dashed border-sky/60 px-5 pb-6 pt-4 leading-relaxed text-ink-soft sm:px-6 sm:pl-[5.25rem]"><?php echo wp_kses_post( apply_filters( 'the_content', $faq->post_content ) ); ?></div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="bg-foam">
	<div class="mx-auto max-w-7xl px-5 py-20 sm:px-8 md:py-28">
		<p class="text-xs font-semibold uppercase tracking-[0.25em] text-sea"><?php echo esc_html( jet_opt( 'steps_eyebrow' ) ); ?></p>
		<h2 class="mt-3 max-w-xl font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl"><?php echo jet_em( jet_opt( 'steps_title' ) ); ?></h2>
		<ol class="relative mt-16 grid gap-12 md:grid-cols-3 md:gap-8">
			<span class="absolute left-7 top-7 hidden h-0.5 w-[calc(100%-3.5rem)] border-t-2 border-dashed border-sea/40 md:block" aria-hidden="true"></span>
			<?php foreach ( array( 1 => 'message-square-text', 2 => 'map', 3 => 'anchor' ) as $n => $icon ) : ?>
				<li class="relative">
					<span class="relative flex h-14 w-14 items-center justify-center rounded-full bg-white text-sea ring-4 ring-foam"><?php echo jet_icon( $icon, 'h-6 w-6' ); ?></span>
					<p class="mt-6 font-mono text-xs font-semibold uppercase tracking-widest text-coral">Port 0<?php echo (int) $n; ?></p>
					<h3 class="mt-2 font-display text-2xl font-medium text-ink"><?php echo esc_html( jet_opt( "step{$n}_title" ) ); ?></h3>
					<p class="mt-3 max-w-xs leading-relaxed text-ink-soft"><?php echo esc_html( jet_opt( "step{$n}_text" ) ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="mx-auto max-w-7xl px-5 py-20 sm:px-8 md:py-28">
	<div class="grid items-center gap-10 overflow-hidden rounded-[2rem] bg-sea text-white md:grid-cols-2">
		<div class="p-8 sm:p-12 lg:p-16">
			<h2 class="font-display text-4xl font-medium leading-tight tracking-tight sm:text-5xl"><?php echo jet_em( jet_opt( 'cta_title' ), 'text-sun' ); ?></h2>
			<p class="mt-5 max-w-md text-lg leading-relaxed text-white/90"><?php echo esc_html( jet_opt( 'cta_text' ) ); ?></p>
			<div class="mt-8 flex flex-wrap gap-4">
				<a href="<?php echo esc_url( $jet_booking ); ?>" class="rounded-full bg-sun px-7 py-4 font-semibold text-ink transition hover:bg-white"><?php echo esc_html( jet_opt( 'cta_btn1' ) ); ?></a>
				<a href="<?php echo esc_url( jet_page_url( 'contact' ) ); ?>" class="rounded-full border-2 border-white/40 px-7 py-4 font-semibold transition hover:border-white"><?php echo esc_html( jet_opt( 'cta_btn2' ) ); ?></a>
			</div>
		</div>
		<img src="<?php echo esc_url( jet_opt( 'cta_image' ) ); ?>" alt="Sunny cruise ship pool deck with lounge chairs facing the open ocean" loading="lazy" class="h-full min-h-72 w-full object-cover">
	</div>
</section>
<?php
get_footer();
