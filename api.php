<?php
/**
 * Simple API.
 *
 * @package Email_Catcher
 */

// Load WordPress.
require dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/wp-load.php';

$user     = wp_get_current_user();
$user_can = apply_filters( 'emc_can_use_api', user_can( $user, 'manage_options' ), $user );

$request = isset( $_GET['request'] ) ? $_GET['request'] : null;
$post_id = isset( $_GET['post_id'] ) ? $_GET['post_id'] : null;
$post_id = (int) $post_id;

$can_call = is_callable( 'emc_get_' . $request );

// Check for cheaters.
if ( ! $user_can || ! $can_call || ! $post_id ) {
	wp_die( __( 'Cheatin&#8217; uh?', 'email-catcher' ) );
}

// Print the request data.
echo call_user_func( 'emc_get_' . $request, $post_id );
die;
