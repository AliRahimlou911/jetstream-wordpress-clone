<?php
defined( 'ABSPATH' ) || exit;

/** Inline Lucide icon. */
function jet_icon( $name, $class = 'h-5 w-5' ) {
	static $icons = null;
	if ( null === $icons ) {
		$icons = require __DIR__ . '/icons.php';
	}
	if ( empty( $icons[ $name ] ) ) {
		return '';
	}
	return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-' . esc_attr( $name ) . ' ' . esc_attr( $class ) . '" aria-hidden="true">' . $icons[ $name ] . '</svg>';
}

/** Escape text and turn *word* into the italic accent used in headings. */
function jet_em( $text, $class = 'font-normal text-sea' ) {
	$text = esc_html( $text );
	$open = $class ? '<em class="' . esc_attr( $class ) . '">' : '<em>';
	return preg_replace( '/\*(.+?)\*/', $open . '$1</em>', $text );
}

/** Non-empty trimmed lines of a textarea setting. */
function jet_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r?\n/', (string) $text ) ), 'strlen' ) );
}

/** URL of the page that uses a given page template, with a sensible fallback. */
function jet_page_url( $template ) {
	static $cache = array();
	if ( ! isset( $cache[ $template ] ) ) {
		$pages = get_pages( array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'templates/' . $template . '.php',
			'number'     => 1,
		) );
		$cache[ $template ] = $pages ? get_permalink( $pages[0] ) : home_url( '/' . $template . '/' );
	}
	return $cache[ $template ];
}

/** Ticket-style dashed divider with punched notches. */
function jet_ticket_divider( $notch = 'bg-shell', $vertical = false ) {
	if ( $vertical ) {
		return '<div class="relative hidden w-0 lg:block" aria-hidden="true">'
			. '<span class="absolute -left-3.5 -top-3.5 h-7 w-7 rounded-full ' . $notch . '"></span>'
			. '<span class="absolute inset-y-6 left-0 border-l-2 border-dashed border-sky"></span>'
			. '<span class="absolute -bottom-3.5 -left-3.5 h-7 w-7 rounded-full ' . $notch . '"></span></div>';
	}
	return '<div class="relative h-6" aria-hidden="true">'
		. '<span class="absolute -left-3 top-0 h-6 w-6 rounded-full ' . $notch . '"></span>'
		. '<span class="absolute inset-x-5 top-1/2 border-t-2 border-dashed border-sky"></span>'
		. '<span class="absolute -right-3 top-0 h-6 w-6 rounded-full ' . $notch . '"></span></div>';
}

/** Wave shape at the bottom of hero sections. */
function jet_wave( $class ) {
	return '<svg class="block w-full ' . esc_attr( $class ) . '" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true"><path fill="currentColor" d="M0 48c120-20 240-32 360-24s240 36 360 36 240-28 360-36 240 4 360 20v36H0z"></path></svg>';
}

function jet_logo( $light = false ) {
	$size = $light ? 'h-20' : 'h-[4.75rem]';
	printf(
		'<a class="group inline-flex items-center %s" aria-label="%s" href="%s"><img src="%s" alt="%s" class="w-auto object-contain transition-transform duration-500 group-hover:scale-[1.03] %s" width="300" height="300"></a>',
		$light ? 'rounded-2xl bg-white px-3 py-2' : '',
		esc_attr( get_bloginfo( 'name' ) . ' home' ),
		esc_url( home_url( '/' ) ),
		esc_url( jet_opt( 'logo' ) ),
		esc_attr( get_bloginfo( 'name' ) ),
		$size
	);
}

/** Inner-page hero. Fields come from the "Page hero" box on each page. */
function jet_page_hero( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$eyebrow = get_post_meta( $post_id, 'jet_eyebrow', true );
	$title   = get_post_meta( $post_id, 'jet_hero_title', true );
	$intro   = get_post_meta( $post_id, 'jet_intro', true );
	$image   = get_the_post_thumbnail_url( $post_id, 'full' );
	?>
	<section class="relative isolate overflow-hidden bg-foam">
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover" fetchpriority="high">
			<div class="absolute inset-0 -z-10 bg-gradient-to-r from-foam via-foam/85 to-foam/30"></div>
		<?php endif; ?>
		<div class="mx-auto max-w-7xl px-5 pb-24 pt-16 sm:px-8 md:pb-32 md:pt-24">
			<p class="animate-rise text-xs font-semibold uppercase tracking-[0.25em] text-sea"><?php echo esc_html( $eyebrow ? $eyebrow : get_the_title( $post_id ) ); ?></p>
			<h1 class="animate-rise mt-4 max-w-3xl font-display text-5xl font-medium leading-[1.05] tracking-tight text-ink [animation-delay:80ms] sm:text-6xl"><?php echo jet_em( $title ? $title : get_the_title( $post_id ) ); ?></h1>
			<?php if ( $intro ) : ?>
				<p class="animate-rise mt-5 max-w-xl text-lg leading-relaxed text-ink-soft [animation-delay:160ms]"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</div>
		<div class="absolute inset-x-0 bottom-0"><?php echo jet_wave( 'h-10 text-shell md:h-16' ); ?></div>
	</section>
	<?php
}

/** Shared form field wrapper. */
function jet_field( $label, $for, $control, $class = '' ) {
	printf(
		'<div class="%s"><label for="%s" class="text-xs font-semibold uppercase tracking-[0.18em] text-ink-soft">%s</label>%s</div>',
		esc_attr( $class ),
		esc_attr( $for ),
		esc_html( $label ),
		$control
	);
}

function jet_input_class() {
	return 'mt-2 w-full rounded-xl border-2 border-sky/70 bg-white px-4 py-3 text-ink placeholder:text-ink-soft/60 transition focus:border-sea focus:outline-none focus-visible:outline-none focus:ring-4 focus:ring-sea/15';
}

function jet_options( $list, $selected = null ) {
	$html = '';
	foreach ( $list as $item ) {
		$html .= '<option' . selected( $item, $selected, false ) . '>' . esc_html( $item ) . '</option>';
	}
	return $html;
}

/** Success and error notices shown after a form is sent (toggled by main.js). */
function jet_form_status( $success, $class = '' ) {
	?>
	<div data-status-box hidden class="<?php echo esc_attr( $class ); ?>">
	<p role="status" data-status="success" hidden class="animate-rise flex items-start gap-3 rounded-xl bg-success/10 p-4 text-success">
		<?php echo jet_icon( 'circle-check', 'mt-0.5 h-5 w-5 shrink-0' ); ?>
		<span><strong>Sent.</strong> <?php echo esc_html( $success ); ?></span>
	</p>
	<p role="alert" data-status="error" hidden class="animate-rise flex items-start gap-3 rounded-xl bg-danger/10 p-4 text-danger">
		<?php echo jet_icon( 'circle-alert', 'mt-0.5 h-5 w-5 shrink-0' ); ?>
		<span><strong>Something went wrong.</strong> Please try again, or call us directly.</span>
	</p>
	</div>
	<?php
}

/** Hidden anti-spam fields included in both forms. */
function jet_form_guard( $type ) {
	printf(
		'<input type="hidden" name="action" value="jet_enquiry"><input type="hidden" name="form" value="%s"><input type="hidden" name="ts" value="%d"><div aria-hidden="true" style="position:absolute;left:-9999px"><label>Leave empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>',
		esc_attr( $type ),
		time()
	);
}
