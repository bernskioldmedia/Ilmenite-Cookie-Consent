<?php

class ILCC_Consent {

	/**
	 * Check if preferences have been set.
	 *
	 * @return bool
	 */
	public static function has_set_preferences() {

		if ( ! isset( $_COOKIE[ Ilmenite_Cookie_Consent::get_preferences_cookie_name() ] ) ) {
			return false;
		}

		return $_COOKIE[ Ilmenite_Cookie_Consent::get_preferences_cookie_name() ] ? true : false;
	}

	/**
	 * Check if we have full consent to all categories.
	 *
	 * @return bool
	 */
	public static function has_full_consent() {
		return self::has_consented_to( 'analytics' ) && self::has_consented_to( 'marketing' );
	}

	/**
	 * Check if we have consent for a specific category.
	 *
	 * @param  string  $category
	 *
	 * @return bool
	 */
	public static function has_consented_to( $category ) {

		$categories = self::get_consented_list();

		if ( ! $categories ) {
			return false;
		}

		return in_array( $category, $categories, true );

	}

	protected static function get_consented_list() {

		if ( isset( $_COOKIE[ Ilmenite_Cookie_Consent::get_categories_cookie_name() ] ) ) {
			$value = $_COOKIE[ Ilmenite_Cookie_Consent::get_categories_cookie_name() ];
			$value = stripslashes( $value );

			return json_decode( $value );
		}

		return [];
	}

}
