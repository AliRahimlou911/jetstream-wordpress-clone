<?php
defined( 'ABSPATH' ) || exit;

define( 'JET_VERSION', '1.0.0' );

require __DIR__ . '/inc/helpers.php';
require __DIR__ . '/inc/settings.php';
require __DIR__ . '/inc/content-types.php';
require __DIR__ . '/inc/forms.php';
require __DIR__ . '/inc/setup.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	register_nav_menus( array(
		'primary' => 'Header menu',
		'footer'  => 'Footer "Explore" menu',
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	$uri = get_template_directory_uri();
	wp_enqueue_style( 'jet-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400;1,9..144,500&family=Figtree:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'jet-site', $uri . '/assets/css/site.css', array(), JET_VERSION );
	wp_enqueue_style( 'jet-wp', $uri . '/assets/css/wp.css', array( 'jet-site' ), JET_VERSION );
	wp_enqueue_script( 'jet-main', $uri . '/assets/js/main.js', array(), JET_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	wp_localize_script( 'jet-main', 'jetstream', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );

	// The custom templates do not use blocks, so skip the block CSS there.
	if ( is_front_page() || is_page_template() || is_404() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}, 20 );

add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

	if ( is_front_page() ) {
		echo '<link rel="preload" as="image" href="' . esc_url( jet_opt( 'hero_image' ) ) . '" fetchpriority="high">' . "\n";
	}

	if ( ! has_site_icon() ) {
		echo '<link rel="icon" type="image/png" href="' . esc_url( jet_opt( 'logo' ) ) . '">' . "\n";
	}

	// Basic SEO tags; skipped when an SEO plugin is active so they never duplicate.
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'AIOSEO\Plugin\AIOSEO' ) ) {
		return;
	}
	$desc = '';
	if ( is_singular() && ! is_front_page() ) {
		$desc = get_post_meta( get_the_ID(), 'jet_intro', true );
	}
	$desc  = $desc ? $desc : jet_opt( 'meta_desc' );
	$title = wp_get_document_title();
	$image = is_singular() && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : jet_opt( 'hero_image' );
	$url   = is_front_page() ? home_url( '/' ) : ( is_singular() ? get_permalink() : '' );

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	if ( $url ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
	}
	printf( '<meta property="og:type" content="website"><meta property="og:site_name" content="%s"><meta property="og:title" content="%s"><meta property="og:description" content="%s"><meta property="og:image" content="%s">' . "\n",
		esc_attr( get_bloginfo( 'name' ) ), esc_attr( $title ), esc_attr( $desc ), esc_url( $image ) );
	if ( $url ) {
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

	if ( is_front_page() ) {
		$schema = array(
			'@context'  => 'https://schema.org',
			'@type'     => 'TravelAgency',
			'name'      => get_bloginfo( 'name' ),
			'url'       => home_url( '/' ),
			'logo'      => jet_opt( 'logo' ),
			'image'     => jet_opt( 'hero_image' ),
			'telephone' => jet_opt( 'phone' ),
			'email'     => jet_opt( 'email' ),
			'address'   => jet_opt( 'address' ),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
}, 1 );

// "Home | Site" style titles matching the original ("Jetstream Vacations | Cruise Travel Agency").
add_filter( 'document_title_separator', function () {
	return '|';
} );

// Lean front end: no emoji script, no oEmbed discovery or generator tags.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'rel_canonical' );

/**
 * Header/footer menu items as [url, label, active]. Falls back to the default
 * pages if no menu is assigned yet.
 */
function jet_menu( $location ) {
	$items     = array();
	$locations = get_nav_menu_locations();
	$current   = is_front_page() ? (int) get_option( 'page_on_front' ) : get_queried_object_id();

	if ( ! empty( $locations[ $location ] ) ) {
		foreach ( (array) wp_get_nav_menu_items( $locations[ $location ] ) as $item ) {
			if ( $item->menu_item_parent ) {
				continue;
			}
			$active  = ( 'post_type' === $item->type && (int) $item->object_id === $current )
				|| untrailingslashit( $item->url ) === untrailingslashit( home_url( add_query_arg( array() ) ) );
			$items[] = array( $item->url, $item->title, $active );
		}
		return $items;
	}

	$fallback = array( array( home_url( '/' ), 'Home', is_front_page() ) );
	foreach ( array( 'about' => 'About Us', 'contact' => 'Contact Us' ) as $tpl => $label ) {
		$fallback[] = array( jet_page_url( $tpl ), $label, is_page_template( 'templates/' . $tpl . '.php' ) );
	}
	if ( 'footer' === $location ) {
		$fallback[] = array( jet_page_url( 'booking' ), 'Booking', is_page_template( 'templates/booking.php' ) );
	}
	return $fallback;
}
