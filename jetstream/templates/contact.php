<?php
/**
 * Template Name: Contact
 */
get_header();
the_post();
jet_page_hero();
$jet_in = jet_input_class();
?>
<section class="mx-auto grid max-w-7xl gap-12 px-5 pb-24 pt-4 sm:px-8 lg:grid-cols-[1fr_1.4fr]">
	<div>
		<ul class="space-y-6">
			<?php
			$jet_rows = array(
				array( 'phone', 'Call us', jet_opt( 'phone' ) ),
				array( 'mail', 'Email', jet_opt( 'email' ) ),
				array( 'map-pin', 'Visit', jet_opt( 'address' ) ),
				array( 'clock', 'Hours', jet_opt( 'hours' ) ),
			);
			foreach ( $jet_rows as $row ) :
				?>
				<li class="flex items-start gap-4">
					<span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-foam text-sea"><?php echo jet_icon( $row[0], 'h-5 w-5' ); ?></span>
					<div>
						<p class="text-xs font-semibold uppercase tracking-[0.2em] text-ink-soft"><?php echo esc_html( $row[1] ); ?></p>
						<p class="mt-1 text-lg font-medium text-ink"><?php echo esc_html( $row[2] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="mt-10 rounded-ticket border-2 border-dashed border-sky p-6">
			<p class="font-display text-xl text-ink"><?php echo esc_html( jet_opt( 'plan_title' ) ); ?></p>
			<p class="mt-2 text-ink-soft"><?php echo esc_html( jet_opt( 'plan_text' ) ); ?></p>
			<a href="<?php echo esc_url( jet_page_url( 'booking' ) ); ?>" class="mt-4 inline-block font-semibold text-sea underline-offset-4 hover:underline"><?php echo esc_html( jet_opt( 'plan_link' ) ); ?></a>
		</div>
		<?php if ( trim( get_the_content() ) ) : ?>
			<div class="jet-prose mt-10"><?php the_content(); ?></div>
		<?php endif; ?>
	</div>

	<form data-jet-form data-reset="message" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" class="space-y-5 rounded-ticket bg-white p-7 shadow-[0_30px_60px_-30px_oklch(0.42_0.12_240/0.45)] sm:p-10">
		<?php jet_form_guard( 'contact' ); ?>
		<div class="grid gap-5 sm:grid-cols-2">
			<?php
			jet_field( 'Your name', 'c-name', '<input id="c-name" name="name" required autocomplete="name" class="' . $jet_in . '">' );
			jet_field( 'Email', 'c-email', '<input id="c-email" name="email" type="email" required autocomplete="email" class="' . $jet_in . '">' );
			?>
		</div>
		<?php
		jet_field( 'Topic', 'c-subject', '<select id="c-subject" name="subject" class="' . $jet_in . '">' . jet_options( jet_lines( jet_opt( 'contact_topics' ) ) ) . '</select>' );
		jet_field( 'Message', 'c-message', '<textarea id="c-message" name="message" required rows="6" class="' . $jet_in . '" placeholder="How can we help?"></textarea>' );
		jet_form_status( jet_opt( 'contact_success' ) );
		?>
		<button type="submit" class="inline-flex items-center gap-2 rounded-full bg-sea px-7 py-4 font-semibold text-white transition hover:bg-sea-deep disabled:cursor-wait disabled:opacity-80">
			<span data-idle class="inline-flex items-center gap-2"><?php echo jet_icon( 'send', 'h-5 w-5' ); ?>Send message</span>
			<span data-busy hidden class="inline-flex items-center gap-2"><?php echo jet_icon( 'loader-circle', 'h-5 w-5 animate-spin' ); ?>Sending…</span>
		</button>
	</form>
</section>
<?php
get_footer();
