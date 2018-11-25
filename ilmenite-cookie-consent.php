<?php
/*
 *	Plugin Name: 	Ilmenite Cookie Consent
 *	Plugin URI: 	https://github.com/bernskioldmedia/Ilmenite-Cookie-Consent
 *	Description: 	A simple, developer-friendly WordPress plugin that lets visitors know that the site is using cookies.
 *	Author: 		Bernskiold Media
 *	Version: 		1.2.0
 *	Author URI: 	http://www.bernskioldmedia.com/
 *	Text Domain: 	ilmenite-cookie-consent
 *	Domain Path: 	/languages
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
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ilmenite Cookie Consent
 */
class Ilmenite_Cookie_Consent {

	/**
	 * The Plugin Path
	 * 
	 * @var string
	 */
	public $plugin_path;

	/**
	 * The Plugin URL
	 * 
	 * @var string
	 */
	public $plugin_url;

	/**
	 * The Plugin Version
	 * 
	 * @var string
	 */
	public $version = '1.2.0';

	/**
	 * The single instance of the class
	 *
	 * @var Ilmenite_Cookie_Consent|null
	 */
	protected static $_instance = null;

	/**
	 * Instance
	 *
	 * @return Ilmenite_Cookie_Consent
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Set Developer Mode Constant.
		if ( ! defined( 'ILCC_DEV_MODE' ) ) {
			define( 'ILCC_DEV_MODE', apply_filters( 'ilcc_dev_mode', false ) );
		}

		// Set the plugin path.
		$this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );

		// Set the plugin URL.
		$this->plugin_url = untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) );

		// Hooks to run on plugin init.
		$this->init_hooks()();

		do_action( 'ilcc_loaded' );

	}

	/**
	 * Hooks into various necessary hooks
	 * at the init time.
	 *
	 * @return void
	 */
	public function init_hooks() {

		do_action( 'before_ilcc_init' );

		// Add Scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// Add Styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );

		// Register customizer fields.
		add_action( 'customize_register', array( $this, 'customizer_settings' ) );

		// Add Translation Loading.
		add_action( 'plugins_loaded', array( $this, 'load_languages' ) );

		do_action( 'ilcc_init' );

	}

	/**
	 * Load translations in the right order.
	 */
	public function load_languages() {

		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'ilmenite-cookie-consent' );

		unload_textdomain( 'ilmenite-cookie-consent' );

		// Start checking in the main language dir.
		load_textdomain( 'ilmenite-cookie-consent', WP_LANG_DIR . '/ilmenite-cookie-consent/ilmenite-cookie-consent-' . $locale . '.mo' );

		// Otherwise, load from the plugin.
		load_plugin_textdomain( 'ilmenite-cookie-consent', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

	/**
	 * Load necessary scripts for the plugin.
	 */
	public function scripts() {

		/**
		 * Don't load anything if the user has
		 * already consented to cookies.
		 */
		if ( $this->has_user_consented() ) {
			return;
		}

		/**
		 * We need jQuery for this plugin.
		 */
		wp_enqueue_script( 'jquery' );

		/**
		 * Register the cookie consent JS that's responsible
		 * for most of the work. For debug purposes, we
		 * register a non-minified version if asked by WordPress.
		 */
		if ( SCRIPTS_DEBUG ) {
			$js_path = $this->plugin_url . '/assets/js/dist/cookie-banner.js';
		} else {
			$js_path = $this->plugin_url . '/assets/js/dist/cookie-banner.min.js';
		}

		wp_register_script( 'ilmenite-cookie-consent', $js_path, array( 'jquery' ), $this->version, true );

		/**
		 * We localize the script to add our texts.
		 * These are changeable by filters. See the functions
		 * that get the texts below.
		 */
		wp_localize_script( 'ilmenite-cookie-consent', 'ilcc', array(
			'cookieConsentText' => $this->get_consent_text(),
			'acceptText'		=> $this->get_accept_text(),
		) );

		// Finally, enqueue!
		wp_enqueue_script( 'ilmenite-cookie-consent' );

	}

	/**
	 * Load the built-in styles for the plugin.
	 */
	public function styles() {

		/**
		 * Don't load anything if the user has
		 * already consented to cookies.
		 */
		if ( $this->has_user_consented() ) {
			return;
		}

		/**
		 * Don't load anything if we are asked not
		 * to load the stylesheet.
		 */
		if( false === apply_filters( 'ilcc_load_stylesheet', true ) || true === ILCC_DEV_MODE ) {
			return;
		}

		/**
		 * Register the main stylesheet.
		 */
		wp_register_style( 'ilmenite-cookie-consent', $this->plugin_url . '/assets/css/cookie-banner.min.css', false, $this->version, 'all' );

		// Finally, enqueue!
		wp_enqueue_style( 'ilmenite-cookie-consent' );

	}

	/**
	 * Add settings in the customer.
	 *
	 * @return void
	 */
	public function customizer_settings() {

		// Register new settings to the WP database
		$wp_customize->add_setting( 'ilcc_policy_url', array(
			'type' 			=> 'option',
			'capability' 	=> apply_filter( 'ilcc_edit_policy_url_capability', 'edit_theme_options' ),
		) );

		// Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_policy_url', array(
			'label'    		=> __( 'Cookie Policy Link', 'skr-master-plugin' ),
			'description' 	=> __( 'Enter a link to your privacy and cookie policy where you outline the use of cookies. This link will be used in the cookie consent banner.', 'ilmenite-cookie-consent' ),
			'settings' 		=> 'ilcc_policy_url',
			'section'  		=> 'title_tagline',
		) ) );

	}

	/**
	 * Get the Policy URL from the settings.
	 *
	 * @return string
	 */
	public function get_policy_url() {
		return apply_filters( 'ilcc_policy_url', get_option( 'ilcc_policy_url', '#' ) );
	}

	/**
	 * Get the informational consent text.
	 *
	 * @return string
	 */
	public function get_consent_text() {

		$policy_url = $this->get_policy_url();

		/* translators: 1. Policy URL */
		$text = sprintf(  __( '<span>This website uses cookies to enhance the browsing experience. </span>By continuing you give us permission to deploy cookies as per our <a href="%s" rel="nofollow">privacy and cookies policy</a>.', 'ilmenite-cookie-consent' ), $policy_url );

		return apply_filters( 'ilcc_consent_text', $text, $policy_url );
	}

	/**
	 * Get the text for the accept button.
	 *
	 * @return string
	 */
	public function get_accept_text() {
		return apply_filters( 'ilcc_accept_text', __( 'I Understand', 'ilmenite-cookie-consent' ) );
	}

	/**
	 * Get the name of the cookie.
	 *
	 * @return void
	 */
	public function get_cookie_name() {
		return apply_filters( 'ilcc_cookie_name', 'EUConsentCookie' );
	}

	/**
	 * Check if the user has consented
	 * to cookies or not.
	 *
	 * @return boolean
	 */
	public function has_user_consented() {

		// Default to false.
		$has_consented = false;

		// Get the cookie name.
		$cookie_name = $this->get_cookie_name();

		// Get which value is considered consented.
		$active_value = apply_filters( 'ilcc_cookie_active_value', '1' );

		if( isset( $_COOKIE[ $cookie_name ] ) && $active_value === $_COOKIE[ $cookie_name ] ) {
			$has_consented = true;
		}

		return apply_filters( 'ilcc_has_user_consented', $has_consented, $cookie_name, $cookie_value );

	}

}

/**
 * Returns an instance of the plugin class.
 *
 * @return Ilmenite_Cookie_Consent
 */
function IlmeniteCookieConsent() {
    return Ilmenite_Cookie_Consent::instance();
}

// Initialize the class instance only once
IlmeniteCookieConsent();
