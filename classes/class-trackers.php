<?php

/**
 * Class ILCC_Trackers
 */
class ILCC_Trackers {

	/**
	 * Any external URLs that load scripts may be whitelisted
	 * when put in the necessary section.
	 *
	 * @var array
	 */
	protected static $necessary = [];

	/**
	 * Add a list of marketing trackers.
	 *
	 * @var array
	 */
	protected static $marketing = [
		'facebook.com',
		'connect.facebook.net',
		'doubleclick.net',
		'hs-scripts.com',
		'linkedin.com',
		'licdn.com',
		'bing.com',
		'googleadservices.com',
	];

	/**
	 * A list of analytics tracking domains.
	 *
	 * @var array
	 */
	protected static $analytics = [
		'google-analytics.com',
		'googletagmanager.com',
		'hotjar.com',
	];

	/**
	 * Get Necessary trackers.
	 *
	 * @return array
	 */
	public static function get_necessary() {
		return apply_filters( 'ilcc_necessary_trackers', self::$necessary );
	}

	/**
	 * Get Marketing Trackers
	 *
	 * @return array
	 */
	public static function get_marketing() {
		return apply_filters( 'ilcc_marketing_trackers', self::$marketing );
	}

	/**
	 * Get analytics trackers.
	 *
	 * @return array
	 */
	public static function get_analytics() {
		return apply_filters( 'ilcc_analytics_trackers', self::$analytics );
	}

	/**
	 * Get all trackers.
	 *
	 * @return array
	 */
	public static function get_all() {
		return array_merge( self::get_marketing(), self::get_analytics() );
	}

	/**
	 * Get Whitelist for use in JavaScript
	 *
	 * @return string
	 */
	public static function get_whitelist_for_js() {
		$whitelist = [];

		foreach ( self::get_necessary() as $domain ) {
			$whitelist[] = '/' . addslashes( $domain ) . '/';
		}

		return implode( ',', $whitelist );
	}

	/**
	 * Get Backlist for use in JavaScript
	 *
	 * @return string
	 */
	public static function get_blacklist_for_js() {

		$blacklist = [];

		foreach ( self::get_all() as $domain ) {
			$blacklist[] = '/' . addslashes( $domain ) . '/';
		}

		return implode( ',', $blacklist );
	}
}
