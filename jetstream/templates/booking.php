<?php
/**
 * Template Name: Booking
 */
get_header();
the_post();
jet_page_hero();

$jet_in    = jet_input_class();
$jet_dests = jet_items( 'jet_destination' );
$jet_pick  = isset( $_GET['destination'] ) ? sanitize_title( wp_unslash( $_GET['destination'] ) ) : '';
if ( ! in_array( $jet_pick, wp_list_pluck( $jet_dests, 'post_name' ), true ) ) {
	$jet_pick = '';
}
$jet_amenities = jet_lines( jet_opt( 'amenities' ) );
?>
<section class="mx-auto -mt-6 max-w-6xl px-5 pb-24 sm:px-8">
	<form data-jet-form data-booking method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" class="grid overflow-hidden rounded-ticket bg-white shadow-[0_30px_60px_-30px_oklch(0.42_0.12_240/0.5)] lg:grid-cols-[1fr_0_360px]">
		<?php jet_form_guard( 'booking' ); ?>
		<div class="p-7 sm:p-10 lg:p-12">
			<div class="space-y-12">
			<fieldset>
				<legend class="font-display text-2xl font-medium text-ink">Who's travelling</legend>
				<div class="mt-6 grid gap-5 sm:grid-cols-2">
					<?php
					jet_field( 'Full name', 'name', '<input id="name" name="name" required autocomplete="name" class="' . $jet_in . '" placeholder="Jordan Rivera">', 'sm:col-span-2' );
					jet_field( 'Email', 'email', '<input id="email" name="email" type="email" required autocomplete="email" class="' . $jet_in . '" placeholder="you@example.com">' );
					jet_field( 'Phone (optional)', 'phone', '<input id="phone" name="phone" type="tel" autocomplete="tel" class="' . $jet_in . '" placeholder="(555) 123-4567">' );
					jet_field( 'Adults', 'adults', '<input id="adults" name="adults" type="number" min="1" max="20" required value="2" class="' . $jet_in . '">' );
					jet_field( 'Children (under 18)', 'children', '<input id="children" name="children" type="number" min="0" max="20" value="0" class="' . $jet_in . '">' );
					?>
				</div>
			</fieldset>
			<fieldset>
				<legend class="font-display text-2xl font-medium text-ink">Your voyage</legend>
				<div class="mt-6 grid gap-5 sm:grid-cols-2">
					<?php
					$opts = '<option value="" disabled' . ( $jet_pick ? '' : ' selected' ) . '>Choose a destination</option>';
					foreach ( $jet_dests as $d ) {
						$opts .= sprintf( '<option value="%s" data-code="%s"%s>%s</option>', esc_attr( $d->post_name ), esc_attr( jet_meta( $d, 'code' ) ), selected( $jet_pick, $d->post_name, false ), esc_html( $d->post_title ) );
					}
					$opts .= '<option value="other">Somewhere else / help me decide</option>';
					jet_field( 'Destination', 'destination', '<select id="destination" name="destination" required class="' . $jet_in . '">' . $opts . '</select>', 'sm:col-span-2' );
					jet_field( 'Preferred sailing month', 'month', '<input id="month" name="month" type="month" min="' . esc_attr( gmdate( 'Y-m' ) ) . '" required class="' . $jet_in . '">' );
					jet_field( 'Date flexibility', 'flexibility', '<select id="flexibility" name="flexibility" class="' . $jet_in . '">' . jet_options( jet_lines( jet_opt( 'opt_flex' ) ), 'Within a month' ) . '</select>' );
					jet_field( 'Trip length', 'nights', '<select id="nights" name="nights" class="' . $jet_in . '">' . jet_options( jet_lines( jet_opt( 'opt_nights' ) ) ) . '</select>' );
					jet_field( 'Cabin type', 'cabin', '<select id="cabin" name="cabin" class="' . $jet_in . '">' . jet_options( jet_lines( jet_opt( 'opt_cabins' ) ) ) . '</select>' );
					jet_field( 'Budget', 'budget', '<select id="budget" name="budget" class="' . $jet_in . '">' . jet_options( jet_lines( jet_opt( 'opt_budget' ) ) ) . '</select>', 'sm:col-span-2' );
					jet_field( 'Anything else we should know?', 'notes', '<textarea id="notes" name="notes" rows="4" class="' . $jet_in . '" placeholder="Celebrations, accessibility needs, favourite cruise lines, ports you&#039;d love to see…"></textarea>', 'sm:col-span-2' );
					?>
				</div>
			</fieldset>
			</div>
			<?php jet_form_status( jet_opt( 'booking_success' ), 'mt-12' ); ?>
		</div>
		<?php echo jet_ticket_divider( 'bg-shell', true ); ?>
		<div class="lg:hidden"><?php echo jet_ticket_divider(); ?></div>
		<aside class="flex flex-col bg-ink p-7 text-white sm:p-9 lg:rounded-r-ticket" aria-label="Booking summary">
			<p class="text-[0.65rem] font-semibold uppercase tracking-[0.3em] text-sun">Boarding pass</p>
			<p class="mt-6 font-mono text-6xl font-semibold tracking-tight" aria-live="polite" data-sum="code">???</p>
			<p class="mt-1 text-sky" data-sum="dest">Choose a destination</p>
			<dl class="mt-8 grid grid-cols-2 gap-x-4 gap-y-5 text-sm">
				<?php foreach ( array( 'name' => 'Passenger', 'month' => 'Sailing', 'guests' => 'Guests', 'nights' => 'Length', 'cabin' => 'Cabin' ) as $key => $label ) : ?>
					<div<?php echo 'name' === $key ? ' class="col-span-2"' : ''; ?>>
						<div>
							<dt class="text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-sky"><?php echo esc_html( $label ); ?></dt>
							<dd class="mt-1 truncate font-semibold text-white" data-sum="<?php echo esc_attr( $key ); ?>">—</dd>
						</div>
					</div>
				<?php endforeach; ?>
			</dl>
			<div class="mt-auto pt-10">
				<button type="submit" class="flex w-full items-center justify-center gap-2 rounded-full bg-sun px-6 py-4 font-semibold text-ink transition hover:bg-white disabled:cursor-wait disabled:opacity-80">
					<span data-idle class="inline-flex items-center gap-2"><?php echo jet_icon( 'send', 'h-5 w-5' ); ?>Send booking request</span>
					<span data-busy hidden class="inline-flex items-center gap-2"><?php echo jet_icon( 'loader-circle', 'h-5 w-5 animate-spin' ); ?>Sending request…</span>
				</button>
				<p class="mt-3 text-center text-xs text-sky"><?php echo esc_html( jet_opt( 'booking_note' ) ); ?></p>
			</div>
		</aside>
	</form>
</section>

<section id="cabins" class="scroll-mt-24 bg-foam" aria-labelledby="cabins-title">
	<div class="mx-auto max-w-7xl px-5 py-20 sm:px-8 md:py-28">
		<div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.25em] text-sea"><?php echo esc_html( jet_opt( 'cabins_eyebrow' ) ); ?></p>
				<h2 id="cabins-title" class="mt-3 max-w-xl font-display text-4xl font-medium tracking-tight text-ink sm:text-5xl"><?php echo jet_em( jet_opt( 'cabins_title' ) ); ?></h2>
			</div>
			<p class="max-w-sm text-ink-soft"><?php echo esc_html( jet_opt( 'cabins_text' ) ); ?></p>
		</div>
		<div class="mt-14 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
			<?php
			foreach ( jet_items( 'jet_cabin' ) as $cabin ) :
				$has = (array) jet_meta( $cabin, 'included' );
				?>
				<article class="flex flex-col overflow-hidden rounded-ticket bg-white shadow-[0_1px_0_var(--color-sky),0_18px_40px_-24px_oklch(0.42_0.12_240/0.45)]">
					<div class="flex-1 p-6 pb-4">
						<span class="rounded-full bg-foam px-3 py-1 font-mono text-xs font-semibold tracking-widest text-sea"><?php echo esc_html( jet_meta( $cabin, 'code' ) ); ?></span>
						<h3 class="mt-4 font-display text-3xl font-medium text-ink"><?php echo esc_html( $cabin->post_title ); ?></h3>
						<p class="mt-3 leading-relaxed text-ink-soft"><?php echo esc_html( jet_meta( $cabin, 'description' ) ); ?></p>
						<p class="mt-4 flex items-center gap-2 text-sm font-semibold text-ink"><?php echo jet_icon( 'ruler', 'h-4 w-4 text-sea' ); ?><?php echo esc_html( jet_meta( $cabin, 'size' ) ); ?></p>
						<p class="mt-3 text-sm text-ink-soft"><span class="font-semibold text-ink">Best for: </span><?php echo esc_html( jet_meta( $cabin, 'best_for' ) ); ?></p>
					</div>
					<?php echo jet_ticket_divider( 'bg-foam' ); ?>
					<ul class="space-y-3 p-6 pt-4" aria-label="<?php echo esc_attr( $cabin->post_title ); ?> amenities">
						<?php foreach ( $jet_amenities as $item ) : $yes = in_array( $item, $has, true ); ?>
							<li class="flex items-center gap-3 text-sm <?php echo $yes ? 'text-ink' : 'text-ink-soft/60'; ?>">
								<?php echo $yes ? jet_icon( 'check', 'h-4 w-4 shrink-0 text-success' ) : jet_icon( 'minus', 'h-4 w-4 shrink-0' ); ?>
								<span><?php echo esc_html( $item ); ?><?php echo $yes ? '' : '<span class="sr-only"> (not included)</span>'; ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endforeach; ?>
		</div>
		<p class="mt-8 text-sm text-ink-soft"><?php echo esc_html( jet_opt( 'cabins_note' ) ); ?></p>
	</div>
</section>
<?php
get_footer();
