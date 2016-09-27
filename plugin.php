<?php
/**
 * Plugin Name: The Events Calendar Extension: Add Start Time to Event Title in Month View
 * Description: Adds an event's start time (if it has one) its Month View title.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Add_Start_Time_to_Event_Title_in_Month_View {

	/**
	 * The semantic version number of this extension; should always match the plugin header.
	 */
	const VERSION = '1.0.0';

	/**
	 * Each plugin required by this extension
	 *
	 * @var array Plugins are listed in 'main class' => 'minimum version #' format
	 */
	public $plugins_required = array(
		'Tribe__Events__Main' => '4.2'
	);

	/**
	 * The constructor; delays initializing the extension until all other plugins are loaded.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
	}

	/**
	 * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
	 */
	public function init() {

		// Exit early if our framework is saying this extension should not run.
		if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
		    return;
		}

		add_filter( 'the_title', array( $this, 'tribe_add_start_time_to_month_view_event_title' ), 100, 2 );
	}

	/**
	 * Add start time to titles in the Month View.
	 *
	 * @param string $post_title
	 * @param int $post_id
	 * @return string
	 */
	public function tribe_add_start_time_to_month_view_event_title( $post_title, $post_id ) {
	
		if ( ! tribe_is_event( $post_id ) || ! tribe_is_month() ) {
			return $post_title;
		}
		
		$event_start_time = tribe_get_start_time( $post_id );
		
		if ( ! empty( $event_start_time ) ) {
			$post_title = $event_start_time . ' — ' . $post_title;
		}
		
		return $post_title;
	}
}

new Tribe__Extension__Add_Start_Time_to_Event_Title_in_Month_View();
