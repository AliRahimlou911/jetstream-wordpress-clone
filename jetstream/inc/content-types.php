<?php
/**
 * Destinations, FAQs, cabins and cruise partners are their own admin menus so
 * the client can add, reorder (Order field) and edit them like posts.
 */

defined( 'ABSPATH' ) || exit;

function jet_types() {
	return array(
		'jet_destination' => array(
			'label'    => 'Destinations',
			'singular' => 'Destination',
			'icon'     => 'dashicons-palmtree',
			'supports' => array( 'title', 'thumbnail', 'page-attributes' ),
			'fields'   => array(
				'code'    => array( 'Three-letter code', 'text' ),
				'tagline' => array( 'Short description', 'textarea' ),
				'season'  => array( 'Season', 'text' ),
				'nights'  => array( 'Length', 'text' ),
			),
		),
		'jet_faq' => array(
			'label'    => 'FAQs',
			'singular' => 'FAQ',
			'icon'     => 'dashicons-editor-help',
			'supports' => array( 'title', 'editor', 'page-attributes' ),
			'note'     => 'The title is the question and the main text is the answer.',
			'fields'   => array(
				'code' => array( 'Topic code (e.g. PSP)', 'text' ),
			),
		),
		'jet_cabin' => array(
			'label'    => 'Cabin types',
			'singular' => 'Cabin type',
			'icon'     => 'dashicons-admin-home',
			'supports' => array( 'title', 'page-attributes' ),
			'fields'   => array(
				'code'        => array( 'Three-letter code', 'text' ),
				'description' => array( 'Description', 'textarea' ),
				'size'        => array( 'Size', 'text' ),
				'best_for'    => array( 'Best for', 'text' ),
				'included'    => array( 'Included amenities', 'checklist' ),
			),
		),
		'jet_partner' => array(
			'label'    => 'Cruise partners',
			'singular' => 'Cruise partner',
			'icon'     => 'dashicons-flag',
			'supports' => array( 'title', 'page-attributes' ),
			'fields'   => array(
				'kind'  => array( 'Type (Ocean, River, Luxury…)', 'text' ),
				'style' => array( 'Lettering style', 'select', array( 'heavy' => 'Bold', 'caps' => 'Spaced capitals', 'serif' => 'Serif', 'italic' => 'Italic serif' ) ),
			),
		),
	);
}

add_action( 'init', function () {
	foreach ( jet_types() as $type => $cfg ) {
		register_post_type( $type, array(
			'labels'        => array(
				'name'          => $cfg['label'],
				'singular_name' => $cfg['singular'],
				'add_new_item'  => 'Add ' . strtolower( $cfg['singular'] ),
				'edit_item'     => 'Edit ' . strtolower( $cfg['singular'] ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_rest'  => in_array( 'editor', $cfg['supports'], true ),
			'menu_icon'     => $cfg['icon'],
			'menu_position' => 21,
			'supports'      => $cfg['supports'],
		) );
	}

	register_post_type( 'jet_enquiry', array(
		'labels'       => array(
			'name'          => 'Enquiries',
			'singular_name' => 'Enquiry',
			'edit_item'     => 'Enquiry',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-email-alt',
		'menu_position' => 3,
		'supports'     => array( 'title' ),
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap' => true,
	) );

	foreach ( array( 'jet_eyebrow', 'jet_hero_title', 'jet_intro' ) as $key ) {
		register_post_meta( 'page', $key, array( 'type' => 'string', 'single' => true, 'show_in_rest' => true ) );
	}
} );

/** Items of a content type in admin order. */
function jet_items( $type ) {
	return get_posts( array(
		'post_type'      => $type,
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
	) );
}

function jet_meta( $post, $key ) {
	return get_post_meta( is_object( $post ) ? $post->ID : $post, 'jet_' . $key, true );
}

add_action( 'add_meta_boxes', function () {
	foreach ( jet_types() as $type => $cfg ) {
		add_meta_box( 'jet_fields', $cfg['singular'] . ' details', 'jet_render_fields', $type, 'normal', 'high', $cfg );
	}
	add_meta_box( 'jet_page_hero', 'Page hero', 'jet_render_page_hero', 'page', 'normal', 'high' );
	add_meta_box( 'jet_enquiry', 'Enquiry', 'jet_render_enquiry', 'jet_enquiry', 'normal', 'high' );
} );

function jet_render_fields( $post, $box ) {
	$cfg = $box['args'];
	wp_nonce_field( 'jet_fields', 'jet_fields_nonce' );
	if ( ! empty( $cfg['note'] ) ) {
		echo '<p><em>' . esc_html( $cfg['note'] ) . '</em></p>';
	}
	if ( 'jet_destination' === $post->post_type ) {
		echo '<p><em>Set the card photo with "Featured image". The URL slug is used in booking links (e.g. ?destination=caribbean).</em></p>';
	}
	echo '<table class="form-table">';
	foreach ( $cfg['fields'] as $key => $field ) {
		$name  = 'jet_' . $key;
		$value = get_post_meta( $post->ID, $name, true );
		echo '<tr><th><label for="' . esc_attr( $name ) . '">' . esc_html( $field[0] ) . '</label></th><td>';
		switch ( $field[1] ) {
			case 'textarea':
				echo '<textarea class="large-text" rows="3" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
				break;
			case 'select':
				echo '<select id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">';
				foreach ( $field[2] as $opt => $label ) {
					echo '<option value="' . esc_attr( $opt ) . '"' . selected( $value, $opt, false ) . '>' . esc_html( $label ) . '</option>';
				}
				echo '</select>';
				break;
			case 'checklist':
				$value = (array) $value;
				foreach ( jet_lines( jet_opt( 'amenities' ) ) as $item ) {
					echo '<label style="display:block;margin-bottom:4px"><input type="checkbox" name="' . esc_attr( $name ) . '[]" value="' . esc_attr( $item ) . '"' . checked( in_array( $item, $value, true ), true, false ) . '> ' . esc_html( $item ) . '</label>';
				}
				echo '<p class="description">The list itself is edited in Appearance &gt; Customize &gt; Jetstream site content &gt; Booking page.</p>';
				break;
			default:
				echo '<input class="regular-text" type="text" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

function jet_render_page_hero( $post ) {
	wp_nonce_field( 'jet_fields', 'jet_fields_nonce' );
	$fields = array(
		'jet_eyebrow'    => 'Small heading above the title',
		'jet_hero_title' => 'Big heading (wrap words in *asterisks* for the italic accent)',
		'jet_intro'      => 'Intro text',
	);
	echo '<p><em>The background image is the page\'s "Featured image". Not used on the home page, which is edited in Appearance &gt; Customize.</em></p><table class="form-table">';
	foreach ( $fields as $name => $label ) {
		$value = get_post_meta( $post->ID, $name, true );
		echo '<tr><th><label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label></th><td>';
		if ( 'jet_intro' === $name ) {
			echo '<textarea class="large-text" rows="3" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input class="large-text" type="text" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

function jet_render_enquiry( $post ) {
	$rows = array(
		'Form'     => get_post_meta( $post->ID, 'jet_form', true ),
		'Name'     => get_post_meta( $post->ID, 'jet_name', true ),
		'Email'    => get_post_meta( $post->ID, 'jet_email', true ),
		'Received' => get_the_date( 'j M Y, g:i a', $post ),
	);
	echo '<table class="form-table">';
	foreach ( $rows as $label => $value ) {
		echo '<tr><th>' . esc_html( $label ) . '</th><td>' . esc_html( $value ) . '</td></tr>';
	}
	echo '<tr><th>Message</th><td><pre style="white-space:pre-wrap;font:inherit;margin:0">' . esc_html( $post->post_content ) . '</pre></td></tr></table>';
}

add_action( 'save_post', function ( $post_id, $post ) {
	if ( ! isset( $_POST['jet_fields_nonce'] ) || ! wp_verify_nonce( $_POST['jet_fields_nonce'], 'jet_fields' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( 'page' === $post->post_type ) {
		$keys = array( 'jet_eyebrow' => 'text', 'jet_hero_title' => 'text', 'jet_intro' => 'textarea' );
	} else {
		$types = jet_types();
		if ( empty( $types[ $post->post_type ] ) ) {
			return;
		}
		$keys = array();
		foreach ( $types[ $post->post_type ]['fields'] as $key => $field ) {
			$keys[ 'jet_' . $key ] = $field[1];
		}
	}

	foreach ( $keys as $name => $type ) {
		$raw = isset( $_POST[ $name ] ) ? wp_unslash( $_POST[ $name ] ) : '';
		if ( 'checklist' === $type ) {
			$value = array_map( 'sanitize_text_field', (array) $raw );
		} elseif ( 'textarea' === $type ) {
			$value = sanitize_textarea_field( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}
		update_post_meta( $post_id, $name, $value );
	}
}, 10, 2 );

// Enquiry list columns.
add_filter( 'manage_jet_enquiry_posts_columns', function () {
	return array(
		'cb'        => '<input type="checkbox">',
		'title'     => 'Enquiry',
		'jet_email' => 'Email',
		'jet_form'  => 'Form',
		'date'      => 'Received',
	);
} );
add_action( 'manage_jet_enquiry_posts_custom_column', function ( $column, $post_id ) {
	echo esc_html( get_post_meta( $post_id, $column, true ) );
}, 10, 2 );

// Show the Order column on the sortable content types.
foreach ( array_keys( jet_types() ) as $jet_type ) {
	add_filter( "manage_{$jet_type}_posts_columns", function ( $cols ) {
		$cols['menu_order'] = 'Order';
		return $cols;
	} );
	add_action( "manage_{$jet_type}_posts_custom_column", function ( $column, $post_id ) {
		if ( 'menu_order' === $column ) {
			echo (int) get_post_field( 'menu_order', $post_id );
		}
	}, 10, 2 );
}
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() && $q->is_main_query() && array_key_exists( $q->get( 'post_type' ), jet_types() ) && ! $q->get( 'orderby' ) ) {
		$q->set( 'orderby', array( 'menu_order' => 'ASC', 'ID' => 'ASC' ) );
	}
} );
