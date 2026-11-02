<?php
/**
 * Every editable site-wide text and image, grouped the way it appears in
 * Appearance > Customize. Defaults match the original site.
 *
 * Wrap a word in *asterisks* in any heading to show it in the italic accent colour.
 */

defined( 'ABSPATH' ) || exit;

function jet_settings() {
	$img = get_template_directory_uri() . '/assets/img/';

	return array(
		'jet_contact' => array(
			'title'  => 'Contact details',
			'fields' => array(
				'phone'        => array( 'Phone', 'text', '(833) 453-8787' ),
				'email'        => array( 'Email', 'text', 'sales@jetstreamvacations.com' ),
				'address'      => array( 'Address', 'text', '14325 Augusta Rd, Orlando, FL 32826' ),
				'hours'        => array( 'Opening hours', 'text', 'Mon – Sat, 9am – 7pm' ),
				'notify_email' => array( 'Send form enquiries to (leave empty for the site admin email)', 'text', '' ),
			),
		),
		'jet_brand' => array(
			'title'  => 'Logo & header',
			'fields' => array(
				'logo'          => array( 'Logo', 'image', $img . 'logo.png' ),
				'brand_name'    => array( 'Brand name (home hero)', 'text', 'Jetstream Vacations' ),
				'brand_tagline' => array( 'Brand tagline (home hero)', 'text', 'Travel Agency' ),
				'cta_label'     => array( 'Header button label', 'text', 'Book a Cruise' ),
				'footer_about'  => array( 'Footer text', 'textarea', 'Cruise specialists for every kind of voyage, from Caribbean island-hops to slow European river journeys.' ),
				'meta_desc'     => array( 'Default search engine description', 'textarea', 'Jetstream Vacations: cruise specialists for Caribbean, Mediterranean, Alaska and European river cruises. Request a booking today.' ),
			),
		),
		'jet_home_hero' => array(
			'title'  => 'Home: hero',
			'fields' => array(
				'hero_image'     => array( 'Background image', 'image', $img . 'hero.webp' ),
				'hero_badge'     => array( 'Badge', 'text', 'Cruise specialists' ),
				'hero_title'     => array( 'Heading', 'text', 'Set sail where the *warm wind* takes you.' ),
				'hero_text'      => array( 'Text', 'textarea', 'Caribbean island-hops, Mediterranean ports, Alaskan glaciers and quiet river journeys. Tell us your dream voyage and our cruise experts plan every detail.' ),
				'hero_btn1'      => array( 'Main button', 'text', 'Start your booking' ),
				'hero_btn2'      => array( 'Second button', 'text', 'Explore destinations' ),
			),
		),
		'jet_home_dest' => array(
			'title'  => 'Home: destinations',
			'fields' => array(
				'dest_eyebrow' => array( 'Small heading', 'text', 'Departures board' ),
				'dest_title'   => array( 'Heading', 'text', 'Four seas, one easy way to get aboard.' ),
				'dest_text'    => array( 'Text', 'textarea', "We book with major ocean and river cruise lines, so you get honest advice instead of a single brand's catalogue." ),
				'dest_button'  => array( 'Card button', 'text', 'Request this voyage' ),
			),
		),
		'jet_home_faq' => array(
			'title'  => 'Home: FAQ',
			'fields' => array(
				'faq_eyebrow' => array( 'Small heading', 'text', 'Before you board' ),
				'faq_title'   => array( 'Heading', 'text', 'Frequently asked *questions*' ),
				'faq_topics'  => array( 'Topics, one per line as "Name | icon" (icons: stamp, wallet, luggage, ship, anchor, compass, map, clock)', 'textarea', "Passports | stamp\nDeposits | wallet\nPacking | luggage" ),
				'faq_more'    => array( 'Text under topics', 'text', 'Still wondering about something?' ),
				'faq_link'    => array( 'Link label', 'text', 'Ask our cruise experts' ),
			),
		),
		'jet_home_steps' => array(
			'title'  => 'Home: three steps',
			'fields' => array(
				'steps_eyebrow' => array( 'Small heading', 'text', 'Your itinerary with us' ),
				'steps_title'   => array( 'Heading', 'text', 'Three ports between dreaming and departing.' ),
				'step1_title'   => array( 'Step 1 title', 'text', 'Share your wish list' ),
				'step1_text'    => array( 'Step 1 text', 'textarea', "Send a booking request with your dates, travellers and the kind of trip you're imagining." ),
				'step2_title'   => array( 'Step 2 title', 'text', 'Get a hand-picked plan' ),
				'step2_text'    => array( 'Step 2 text', 'textarea', 'A Jetstream cruise expert compares lines, ships and cabins, then sends you clear options.' ),
				'step3_title'   => array( 'Step 3 title', 'text', 'Step aboard' ),
				'step3_text'    => array( 'Step 3 text', 'textarea', "We confirm your booking, handle the paperwork and stay on call until you're home again." ),
			),
		),
		'jet_home_cta' => array(
			'title'  => 'Home: call to action',
			'fields' => array(
				'cta_title' => array( 'Heading', 'text', 'Your deck chair is *waiting*.' ),
				'cta_text'  => array( 'Text', 'textarea', "Tell us where and when. We'll come back with options that fit your style and your budget, with no obligation." ),
				'cta_btn1'  => array( 'Main button', 'text', 'Request a booking' ),
				'cta_btn2'  => array( 'Second button', 'text', 'Ask a question' ),
				'cta_image' => array( 'Image', 'image', $img . 'deck.webp' ),
			),
		),
		'jet_about' => array(
			'title'  => 'About page',
			'fields' => array(
				'story_title'      => array( 'Story heading (the story text is the About page content)', 'text', 'Our story' ),
				'about_img1'       => array( 'Story image (large)', 'image', $img . 'mediterranean.webp' ),
				'about_img2'       => array( 'Story image (small)', 'image', $img . 'alaska.webp' ),
				'care_title'       => array( 'Care section heading', 'text', 'How we look after you' ),
				'care1_title'      => array( 'Point 1 title', 'text', 'Independent advice' ),
				'care1_text'       => array( 'Point 1 text', 'textarea', 'We work across ocean and river cruise lines, so our recommendations follow your wish list, not a sales quota.' ),
				'care2_title'      => array( 'Point 2 title', 'text', 'One expert, start to finish' ),
				'care2_text'       => array( 'Point 2 text', 'textarea', 'The agent who plans your trip stays your contact through booking, boarding and the voyage home.' ),
				'care3_title'      => array( 'Point 3 title', 'text', 'On call while you sail' ),
				'care3_text'       => array( 'Point 3 text', 'textarea', 'Missed connection or a change of plans? We sort it out so you can stay on deck.' ),
				'care_button'      => array( 'Care section button', 'text', 'Start planning your cruise' ),
				'partners_eyebrow' => array( 'Partners small heading', 'text', 'Cruise line partners' ),
				'partners_title'   => array( 'Partners heading', 'text', 'One agency, a whole *fleet* of choices.' ),
				'partners_text'    => array( 'Partners text', 'textarea', 'We book sailings with leading ocean, luxury and river cruise lines, so we can match you to the right ship rather than the nearest one.' ),
				'partners_note'    => array( 'Partners note', 'text', "Don't see your favourite line? Ask us. We can book many more." ),
			),
		),
		'jet_contact_page' => array(
			'title'  => 'Contact page',
			'fields' => array(
				'contact_topics'  => array( 'Form topics, one per line', 'textarea', "General question\nExisting booking\nGroup or special occasion\nSomething else" ),
				'contact_success' => array( 'Message after sending', 'text', "Thanks for reaching out. We'll get back to you shortly." ),
				'plan_title'      => array( 'Booking box heading', 'text', 'Ready to plan a trip?' ),
				'plan_text'       => array( 'Booking box text', 'text', 'Our booking request form collects everything we need to find your perfect sailing.' ),
				'plan_link'       => array( 'Booking box link', 'text', 'Go to booking →' ),
			),
		),
		'jet_booking' => array(
			'title'  => 'Booking page',
			'fields' => array(
				'booking_success' => array( 'Message after sending', 'text', 'Thanks! A Jetstream cruise expert will email you within one business day with options.' ),
				'booking_note'    => array( 'Note under the send button', 'text', 'No payment now. An agent replies within 1 business day.' ),
				'opt_cabins'      => array( 'Cabin type options, one per line', 'textarea', "Not sure yet\nInterior\nOcean view\nBalcony\nSuite" ),
				'opt_nights'      => array( 'Trip length options, one per line', 'textarea', "Not sure yet\n3–5 nights\n6–8 nights\n9–12 nights\n13+ nights" ),
				'opt_flex'        => array( 'Date flexibility options, one per line', 'textarea', "Exact dates\nWithin a week\nWithin a month\nFully flexible" ),
				'opt_budget'      => array( 'Budget options, one per line', 'textarea', "Not sure yet\nUnder $1,500 per person\n$1,500 – $3,000 per person\n$3,000 – $6,000 per person\n$6,000+ per person" ),
				'cabins_eyebrow'  => array( 'Cabins small heading', 'text', 'Choosing your cabin' ),
				'cabins_title'    => array( 'Cabins heading', 'text', 'Four ways to *sleep at sea*.' ),
				'cabins_text'     => array( 'Cabins text', 'textarea', "Not sure which fits? Compare the options, then pick a cabin type in the form above. We'll confirm exact details for your ship." ),
				'cabins_note'     => array( 'Cabins note', 'text', 'Sizes and amenities are typical and vary by cruise line and ship.' ),
				'amenities'       => array( 'Cabin amenities to compare, one per line', 'textarea', "Private bathroom\nFlat-screen TV and mini-fridge\nWindow or porthole\nPrivate balcony\nSofa and sitting area\nPriority boarding\nConcierge or butler service" ),
			),
		),
	);
}

/** Flat map of setting id => default. */
function jet_defaults() {
	static $defaults = null;
	if ( null === $defaults ) {
		$defaults = array();
		foreach ( jet_settings() as $section ) {
			foreach ( $section['fields'] as $id => $field ) {
				$defaults[ $id ] = $field[2];
			}
		}
	}
	return $defaults;
}

function jet_opt( $id ) {
	$defaults = jet_defaults();
	return get_theme_mod( 'jet_' . $id, isset( $defaults[ $id ] ) ? $defaults[ $id ] : '' );
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_panel( 'jetstream', array(
		'title'    => 'Jetstream site content',
		'priority' => 1,
	) );

	foreach ( jet_settings() as $section_id => $section ) {
		$wp_customize->add_section( $section_id, array(
			'title' => $section['title'],
			'panel' => 'jetstream',
		) );

		foreach ( $section['fields'] as $id => $field ) {
			list( $label, $type, $default ) = $field;
			$setting = 'jet_' . $id;

			$wp_customize->add_setting( $setting, array(
				'default'           => $default,
				'sanitize_callback' => 'image' === $type ? 'esc_url_raw' : ( 'textarea' === $type ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
			) );

			if ( 'image' === $type ) {
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting, array(
					'label'   => $label,
					'section' => $section_id,
				) ) );
			} else {
				$wp_customize->add_control( $setting, array(
					'label'   => $label,
					'section' => $section_id,
					'type'    => $type,
				) );
			}
		}
	}
} );
