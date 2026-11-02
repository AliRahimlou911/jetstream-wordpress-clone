<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="flex min-h-screen flex-col">
	<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-full focus:bg-sun focus:px-4 focus:py-2">Skip to content</a>
	<?php
	$jet_nav     = jet_menu( 'primary' );
	$jet_booking = jet_page_url( 'booking' );
	?>
	<header class="sticky top-0 z-50 border-b border-sky/40 bg-shell/85 backdrop-blur-md">
		<div class="mx-auto flex h-20 max-w-7xl items-center justify-end px-5 sm:px-8">
			<nav aria-label="Main" class="hidden items-center gap-9 md:flex">
				<?php foreach ( $jet_nav as $item ) : ?>
					<a href="<?php echo esc_url( $item[0] ); ?>" <?php echo $item[2] ? 'aria-current="page"' : ''; ?> class="relative py-2 text-[0.95rem] font-medium transition-colors after:absolute after:inset-x-0 after:-bottom-0.5 after:h-0.5 after:origin-left after:rounded-full after:bg-sea after:transition-transform <?php echo $item[2] ? 'text-sea after:scale-x-100' : 'text-ink hover:text-sea after:scale-x-0 hover:after:scale-x-100'; ?>"><?php echo esc_html( $item[1] ); ?></a>
				<?php endforeach; ?>
				<a href="<?php echo esc_url( $jet_booking ); ?>" class="inline-flex items-center gap-2 rounded-full bg-sun px-5 py-2.5 text-[0.95rem] font-semibold text-ink shadow-[0_3px_0_var(--color-sun-deep)] transition hover:-translate-y-0.5 hover:shadow-[0_5px_0_var(--color-sun-deep)]"><?php echo jet_icon( 'ship', 'h-4 w-4' ); ?><?php echo esc_html( jet_opt( 'cta_label' ) ); ?></a>
			</nav>
			<button type="button" data-menu-toggle class="rounded-full p-2.5 text-ink hover:bg-foam md:hidden" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu">
				<span data-icon-open><?php echo jet_icon( 'menu', 'h-6 w-6' ); ?></span>
				<span data-icon-close hidden><?php echo jet_icon( 'x', 'h-6 w-6' ); ?></span>
			</button>
		</div>
		<nav id="mobile-nav" aria-label="Mobile" hidden class="animate-rise border-t border-sky/40 px-5 pb-6 pt-2 md:hidden">
			<?php
			$jet_mobile   = $jet_nav;
			$jet_mobile[] = array( $jet_booking, 'Booking', is_page_template( 'templates/booking.php' ) );
			foreach ( $jet_mobile as $item ) :
				?>
				<a href="<?php echo esc_url( $item[0] ); ?>" class="block border-b border-sky/30 py-4 font-display text-2xl <?php echo $item[2] ? 'text-sea' : 'text-ink'; ?>"><?php echo esc_html( $item[1] ); ?></a>
			<?php endforeach; ?>
		</nav>
	</header>
	<main id="main" class="flex-1">
