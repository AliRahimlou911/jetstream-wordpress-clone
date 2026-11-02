<?php
/**
 * Contact and booking forms post here (admin-ajax). Each enquiry is saved under
 * Enquiries in the admin and emailed to the address set in the Customizer.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_ajax_jet_enquiry', 'jet_handle_enquiry' );
add_action( 'wp_ajax_nopriv_jet_enquiry', 'jet_handle_enquiry' );

function jet_handle_enquiry() {
	$p = wp_unslash( $_POST );

	// Bots fill the hidden field or submit instantly.
	if ( ! empty( $p['website'] ) || ( time() - (int) ( isset( $p['ts'] ) ? $p['ts'] : 0 ) ) < 3 ) {
		wp_send_json_error( array( 'message' => 'Rejected' ), 400 );
	}

	$ip   = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : '';
	$key  = 'jet_rate_' . md5( $ip );
	$hits = (int) get_transient( $key );
	if ( $hits >= 10 ) {
		wp_send_json_error( array( 'message' => 'Too many requests' ), 429 );
	}
	set_transient( $key, $hits + 1, HOUR_IN_SECONDS );

	$form  = isset( $p['form'] ) && 'booking' === $p['form'] ? 'booking' : 'contact';
	$name  = sanitize_text_field( isset( $p['name'] ) ? $p['name'] : '' );
	$email = sanitize_email( isset( $p['email'] ) ? $p['email'] : '' );
	$f     = function ( $k, $fallback = '' ) use ( $p ) {
		$v = isset( $p[ $k ] ) ? sanitize_textarea_field( $p[ $k ] ) : '';
		return '' === $v ? $fallback : $v;
	};

	if ( ! $name || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => 'Name and a valid email are required' ), 422 );
	}

	if ( 'booking' === $form ) {
		$dest = $f( 'destination' );
		$post = $dest ? get_page_by_path( $dest, OBJECT, 'jet_destination' ) : null;
		$month = $f( 'month' );
		$month = preg_match( '/^(\d{4})-(\d{2})$/', $month, $m ) ? date( 'M Y', mktime( 0, 0, 0, (int) $m[2], 1, (int) $m[1] ) ) : $month;

		$message = implode( "\n", array(
			'NEW CRUISE BOOKING REQUEST',
			'Destination: ' . ( $post ? $post->post_title : 'Somewhere else / help me decide' ),
			'Preferred sailing: ' . $month . ' (' . $f( 'flexibility' ) . ')',
			'Trip length: ' . $f( 'nights' ),
			'Guests: ' . (int) $f( 'adults' ) . ' adult(s), ' . (int) $f( 'children' ) . ' child(ren)',
			'Cabin: ' . $f( 'cabin' ),
			'Budget: ' . $f( 'budget' ),
			'Phone: ' . $f( 'phone', 'Not provided' ),
			'Notes: ' . $f( 'notes', 'None' ),
		) );
		$subject = 'Booking request from ' . $name;
	} else {
		if ( '' === $f( 'message' ) ) {
			wp_send_json_error( array( 'message' => 'Message is required' ), 422 );
		}
		$message = 'Topic: ' . $f( 'subject' ) . "\n\n" . $f( 'message' );
		$subject = 'Website message from ' . $name;
	}

	$id = wp_insert_post( array(
		'post_type'    => 'jet_enquiry',
		'post_status'  => 'private',
		'post_title'   => $subject,
		'post_content' => $message,
	) );
	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, 'jet_form', ucfirst( $form ) );
		update_post_meta( $id, 'jet_name', $name );
		update_post_meta( $id, 'jet_email', $email );
	}

	$to = jet_opt( 'notify_email' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );
	wp_mail(
		$to,
		'[' . get_bloginfo( 'name' ) . '] ' . $subject,
		"Name: $name\nEmail: $email\n\n$message",
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);

	// The enquiry is stored even if the host cannot send mail, so it is never lost.
	wp_send_json_success();
}
