<?php
/**
 * One-time content import when the theme is first activated: pages, menus,
 * destinations, FAQs, cabins, partners and their images.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_switch_theme', 'jet_install' );

function jet_install() {
	if ( get_option( 'jet_installed' ) ) {
		return;
	}
	update_option( 'jet_installed', 1 );

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$img = array(
		'hero'          => jet_import_image( 'hero.webp', 'White cruise ship sailing across turquoise water on a sunny morning' ),
		'deck'          => jet_import_image( 'deck.webp', 'Sunny cruise ship pool deck with lounge chairs facing the open ocean' ),
		'caribbean'     => jet_import_image( 'caribbean.webp', 'Cruise ship in the Caribbean' ),
		'mediterranean' => jet_import_image( 'mediterranean.webp', 'Cruise ship moored beside a whitewashed Mediterranean village' ),
		'alaska'        => jet_import_image( 'alaska.webp', 'Cruise ship sailing past an Alaskan glacier' ),
		'river'         => jet_import_image( 'river.webp', 'Cruise ship in the European Rivers' ),
		'logo'          => jet_import_image( 'logo.png', 'Jetstream Vacations' ),
	);

	// Point Customizer images at the media library copies so they are swappable there.
	$mods = array( 'logo' => 'logo', 'hero_image' => 'hero', 'cta_image' => 'deck', 'about_img1' => 'mediterranean', 'about_img2' => 'alaska' );
	foreach ( $mods as $mod => $key ) {
		if ( $img[ $key ] ) {
			set_theme_mod( 'jet_' . $mod, wp_get_attachment_url( $img[ $key ] ) );
		}
	}
	if ( $img['logo'] && ! get_option( 'site_icon' ) ) {
		update_option( 'site_icon', $img['logo'] );
	}

	update_option( 'blogname', 'Jetstream Vacations' );
	update_option( 'blogdescription', 'Cruise Travel Agency' );
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	$p = function ( $text ) {
		return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
	};

	$pages = array(
		'home'    => array( 'Home', '', null, array() ),
		'about'   => array( 'About Us', 'about', $img['deck'], array(
			'About us',
			'Cruise people, *through and through*.',
			'Jetstream Vacations is a cruise travel agency built around one idea: the best voyage is the one planned around you.',
		), implode( "\n\n", array(
			$p( 'We started Jetstream because we kept watching friends get lost in endless ship comparisons, cabin categories and fine print. Cruising should feel easy from the very first question.' ),
			$p( "Today our team plans sailings of every kind: lively Caribbean weeks for families, Mediterranean port-hopping for couples, Alaskan wildlife voyages and slow river journeys through Europe's old towns." ),
			$p( "Whatever the itinerary, we treat every booking like we're the ones sailing." ),
		) ) ),
		'contact' => array( 'Contact Us', 'contact', null, array(
			'Contact us',
			'Drop us a line from *any shore*.',
			'Questions about a sailing, an existing reservation or a group trip? Our cruise experts are happy to help.',
		) ),
		'booking' => array( 'Booking', 'booking', $img['hero'], array(
			'Booking',
			'Request your *cruise*',
			"Fill in your boarding pass with as much or as little detail as you like. A cruise expert will reply with hand-picked sailings and prices, and you're under no obligation.",
		) ),
	);

	$ids = array();
	foreach ( $pages as $slug => $page ) {
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $page[0],
			'post_name'    => $slug,
			'post_content' => isset( $page[4] ) ? $page[4] : '',
		) );
		$ids[ $slug ] = $id;
		if ( $page[1] ) {
			update_post_meta( $id, '_wp_page_template', 'templates/' . $page[1] . '.php' );
		}
		if ( $page[2] ) {
			set_post_thumbnail( $id, $page[2] );
		}
		if ( $page[3] ) {
			update_post_meta( $id, 'jet_eyebrow', $page[3][0] );
			update_post_meta( $id, 'jet_hero_title', $page[3][1] );
			update_post_meta( $id, 'jet_intro', $page[3][2] );
		}
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['home'] );

	// Remove WordPress sample content.
	foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
		$sample = get_page_by_path( $slug, OBJECT, $type );
		if ( $sample ) {
			wp_delete_post( $sample->ID, true );
		}
	}

	$menus = array(
		'primary' => array( 'Main menu', array( 'home', 'about', 'contact' ) ),
		'footer'  => array( 'Footer menu', array( 'home', 'about', 'contact', 'booking' ) ),
	);
	$locations = array();
	foreach ( $menus as $location => $menu ) {
		$menu_id = wp_create_nav_menu( $menu[0] );
		if ( is_wp_error( $menu_id ) ) {
			continue;
		}
		foreach ( $menu[1] as $slug ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-object-id' => $ids[ $slug ],
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-title'     => 'home' === $slug ? 'Home' : get_the_title( $ids[ $slug ] ),
				'menu-item-status'    => 'publish',
			) );
		}
		$locations[ $location ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $locations );

	$destinations = array(
		array( 'caribbean', 'Caribbean', 'CRB', 'Turquoise bays, white-sand stops and warm trade winds.', 'Year-round', '3–14 nights' ),
		array( 'mediterranean', 'Mediterranean', 'MED', 'Cliffside villages, ancient ports and long golden evenings.', 'Apr – Oct', '7–12 nights' ),
		array( 'alaska', 'Alaska', 'ALK', 'Glacier fjords, whale sightings and crisp northern light.', 'May – Sep', '7–14 nights' ),
		array( 'river', 'European Rivers', 'RVR', 'Slow mornings past vineyards, castles and old-town quays.', 'Mar – Dec', '7–15 nights' ),
	);
	foreach ( $destinations as $i => $d ) {
		$id = jet_insert( 'jet_destination', $d[1], $i, array( 'code' => $d[2], 'tagline' => $d[3], 'season' => $d[4], 'nights' => $d[5] ), '', $d[0] );
		if ( $img[ $d[0] ] ) {
			set_post_thumbnail( $id, $img[ $d[0] ] );
		}
	}

	$faqs = array(
		array( 'PSP', 'Do I need a passport to go on a cruise?', array( 'For most international itineraries, yes. Some round-trip sailings that start and end at the same U.S. port (called closed-loop cruises) let U.S. citizens board with a birth certificate plus a government-issued photo ID.', "We still strongly recommend a passport. If you ever have to fly home from a foreign port mid-trip, you'll need one." ) ),
		array( 'PSP', 'How long does my passport need to be valid?', array( 'Many countries require your passport to be valid for at least six months after your trip ends, with blank pages for stamps. Some ports also need a visa in advance.', 'When you book, we check the entry requirements for every port on your itinerary and tell you exactly what each traveller needs.' ) ),
		array( 'DEP', 'How much is the deposit, and when is final payment due?', array( 'Sending a booking request with us is free. Once you choose a sailing, the cruise line usually asks for a deposit per person to hold your cabin. The amount depends on the line, the trip length and the cabin type.', "Final payment is typically due between 60 and 120 days before departure. We'll give you the exact amounts and dates in writing before you commit." ) ),
		array( 'DEP', 'Can I get my deposit back if my plans change?', array( 'Many fares come with a refundable deposit up until final payment, while some promotional fares are non-refundable or only allow you to move the deposit to a future cruise as credit.', 'We always explain the cancellation terms of your fare up front, and we recommend travel insurance for extra peace of mind.' ) ),
		array( 'PCK', 'What should I keep in my carry-on for boarding day?', array( 'Your checked luggage can take a few hours to reach your cabin, so keep the essentials with you: travel documents, medication, chargers, sunscreen, a swimsuit and a change of clothes.', 'Pack one smart outfit too. Many ships hold an elegant evening early in the voyage.' ) ),
		array( 'PCK', "Is there anything I can't bring on board?", array( 'Most cruise lines prohibit irons and steamers, candles, surge-protected power strips, drones and weapons. Many also limit how much alcohol you can bring.', "Rules vary between cruise lines, so we'll send you a packing checklist for your specific ship before you sail." ) ),
	);
	foreach ( $faqs as $i => $f ) {
		jet_insert( 'jet_faq', $f[1], $i, array( 'code' => $f[0] ), implode( "\n\n", array_map( $p, $f[2] ) ) );
	}

	$amenities = jet_lines( jet_opt( 'amenities' ) );
	$cabins    = array(
		array( 'Interior', 'INT', '150 – 185 sq ft', 'Budget-minded travellers who mostly use the cabin to sleep', 'A cosy, well-designed stateroom with no window. The best value on board, and blackout-dark for great sleep.', 2 ),
		array( 'Ocean view', 'OCV', '160 – 200 sq ft', 'Travellers who want natural light and a view without a big price jump', 'The same comfortable layout as an interior cabin, with a window or porthole so you can watch ports and sunrises roll by.', 3 ),
		array( 'Balcony', 'BLC', '180 – 250 sq ft', 'Couples and families who love morning coffee with an ocean view', 'Step outside from your own private terrace with seating. Floor-to-ceiling glass makes the room feel open and bright.', 5 ),
		array( 'Suite', 'STE', '280 – 600+ sq ft', 'Special occasions and travellers who want space and VIP treatment', 'A spacious suite with a separate living area, a larger balcony and extra perks that start before you even step aboard.', 7 ),
	);
	foreach ( $cabins as $i => $c ) {
		jet_insert( 'jet_cabin', $c[0], $i, array(
			'code'        => $c[1],
			'size'        => $c[2],
			'best_for'    => $c[3],
			'description' => $c[4],
			'included'    => array_slice( $amenities, 0, $c[5] ),
		) );
	}

	$partners = array(
		array( 'Royal Caribbean', 'Ocean', 'heavy' ), array( 'Celebrity Cruises', 'Ocean', 'caps' ),
		array( 'Norwegian Cruise Line', 'Ocean', 'serif' ), array( 'Princess Cruises', 'Ocean', 'italic' ),
		array( 'Holland America Line', 'Ocean', 'caps' ), array( 'MSC Cruises', 'Ocean', 'heavy' ),
		array( 'Carnival', 'Ocean', 'italic' ), array( 'Disney Cruise Line', 'Ocean', 'serif' ),
		array( 'Virgin Voyages', 'Ocean', 'heavy' ), array( 'Cunard', 'Luxury', 'caps' ),
		array( 'Viking', 'River', 'caps' ), array( 'AmaWaterways', 'River', 'italic' ),
	);
	foreach ( $partners as $i => $c ) {
		jet_insert( 'jet_partner', $c[0], $i, array( 'kind' => $c[1], 'style' => $c[2] ) );
	}

	flush_rewrite_rules();
}

function jet_insert( $type, $title, $order, $meta, $content = '', $slug = '' ) {
	$id = wp_insert_post( array(
		'post_type'    => $type,
		'post_status'  => 'publish',
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'menu_order'   => $order,
	) );
	foreach ( $meta as $key => $value ) {
		update_post_meta( $id, 'jet_' . $key, $value );
	}
	return $id;
}

/** Copy a bundled theme image into the media library. */
function jet_import_image( $file, $alt ) {
	$src = get_template_directory() . '/assets/img/' . $file;
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	$tmp = wp_tempnam( $file );
	copy( $src, $tmp );
	$id = media_handle_sideload( array( 'name' => 'jetstream-' . $file, 'tmp_name' => $tmp ), 0, $alt );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp );
		return 0;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	return $id;
}
