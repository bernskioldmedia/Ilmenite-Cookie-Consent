<?php

/**
 * Class ILCC_Trackers
 */
class ILCC_Trackers {

	protected static $necessary = [];

	/**
	 * Add a list of marketing trackers.
	 *
	 * @var array
	 */
	protected static $marketing = [
		// Facebook Pixel
		// Google Ads
		// LinkedIn Pixel
	];

	/**
	 * A list of analytics tracking domains.
	 *
	 * @var array
	 */
	protected static $analytics = [
		'google-analytics.com',
		'googletagmanager.com',
		// Hotjar
	];

	public static function get_necessary() {
		return self::$necessary;
	}

	public static function get_marketing() {
		return self::$marketing;
	}

	public static function get_analytics() {
		return self::$analytics;
	}

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
