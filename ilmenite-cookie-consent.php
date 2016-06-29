<?php
/*
 *	Plugin Name: Ilmenite Cookie Consent
 *	Plugin URI: https://github.com/bernskioldmedia/Ilmenite-Cookie-Consent
 *	Description: A simple, developer-friendly WordPress plugin that lets visitors know that the site is using cookies.
 *	Author: Bernskiold Media
 *	Version: 1.1.0
 *	Author URI: http://www.bernskioldmedia.com/
 *	Text Domain: ilmenite-cookie-consent
 *	Domain Path: /languages
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

class Ilmenite_Cookie_Consent {

	/**
	 * The Plugin Path
	 * @var string
	 */
	public $plugin_path;

	/**
	 * The Plugin URL
	 * @var string
	 */
	public $plugin_url;

	/**
	 * The Plugin Version
	 * @var string
	 */
	public $plugin_version;

	/**
	* @var The single instance of the class
	*/
	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {

		// Set Developer Mode Constant
		if ( ! defined( 'ILCC_DEV_MODE' ) ) {
			define( 'ILCC_DEV_MODE', false );
		}

		// Set the plugin path
		$this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );

		// Set the plugin URL
		$this->plugin_url = untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) );

		// Set the plugin version
		$this->plugin_version = '0.2.9';

		// Add Scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// Add Styles
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );

		// Register Settings Fields
		add_filter( 'admin_init', array( $this, 'settings_fields' ) );

		// Add Translation Loading
		add_action( 'plugins_loaded', array( $this, 'add_textdomain' ) );

	}

	/**
	 * Load the Translations
	 */
	public function add_textdomain() {
		$domain = 'ilmenite-cookie-consent';

		// Let users specify their own translations under WP_LANG_DIR
		load_plugin_textdomain( $domain ) || load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Enqueue Scripts
	 */
	public function scripts() {

		// WP Enqueue Script
		wp_enqueue_script( 'jquery' );

		// Register Scripts
		wp_register_script( 'ilmenite-cookie-consent', $this->plugin_url . '/assets/js/cookie-banner.min.js', array( 'jquery' ), $this->plugin_version, true );

		// Localize the script
		wp_localize_script( 'ilmenite-cookie-consent', 'ilcc', array(
			'cookieConsentText' => sprintf( apply_filters( 'ilcc_consent_text', __( '<span>This website uses cookies to enhance the browsing experience. </span>By continuing you give us permission to deploy cookies as per our <a href="%s" rel="nofollow">privacy and cookies policy</a>.', 'ilmenite-cookie-consent' ) ), get_option( 'ilcc_policy_url' ) ),
			'acceptText'		=> apply_filters( 'ilcc_accept_text', __( 'I Understand', 'ilmenite-cookie-consent' ) ),
		) );

		// Load script if the consent cookie isn't set
		if ( ! isset ( $_COOKIE['EUCookieConsent'] ) ) {
			wp_enqueue_script( 'ilmenite-cookie-consent' );
		}

	}

	/**
	 * Enqueue Styles
	 */
	public function styles() {

		// Register them...
		wp_register_style( 'ilmenite-cookie-consent', $this->plugin_url . '/assets/css/cookie-banner.min.css', false, $this->plugin_version, 'all' );

		// Enqueue if developer mode isn't turned on
		// also don't enqueue if consent cookie is set
		if ( false == ILCC_DEV_MODE && ! isset ( $_COOKIE['EUCookieConsent'] ) ) {
			wp_enqueue_style( 'ilmenite-cookie-consent' );
		}

	}

	/**
	 * Admin Settings Fields
	 */
	public function settings_fields() {
		$option_group = 'reading';

		// Policy URL
		register_setting( $option_group, 'ilcc_policy_url', 'esc_attr' );
        add_settings_field( 'ilcc_policy_url', '<label for="ilcc_policy_url">' . __( 'Privacy and Cookie Policy URL' , 'ilmenite-cookie-consent' ) . '</label>' , array( $this, 'settings_fields_html' ) , $option_group );

	}

	function settings_fields_html() {
        $value = get_option( 'ilcc_policy_url', '' );
        echo '<input type="url" class="regular-text code" id="ilcc_policy_url" name="ilcc_policy_url" value="' . $value . '" />';
        echo '<p class="description">' . __( 'Enter a link to your privacy and cookie policy where you outline the use of cookies. This link will be used in the cookie consent banner.', 'ilmenite-cookie-consent' ) . '</p>';
    }

}

function IlmeniteCookieConsent() {
    return Ilmenite_Cookie_Consent::instance();
}

// Initialize the class instance only once
IlmeniteCookieConsent();