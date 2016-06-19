<?php
/**
 * Plugin Name: The Events Calendar — [Snippet Title, *Same as the snippet post article title*]
 * Description: [description]
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

function tribe_add_start_time_to_month_view_event_title( $post_title, $post_id ) {

	if ( ! tribe_is_event( $post_id ) || ! tribe_is_month() ) {
		return $post_title;
	}
	
	$event_start_time = tribe_get_start_time( $post_id );

	if ( ! empty( $event_start_time ) ) {
		$post_title = $event_start_time . ' — ' . $post_title;
	}

	return $post_title;
}

add_filter( 'the_title', 'tribe_add_start_time_to_month_view_event_title', 100, 2 );
