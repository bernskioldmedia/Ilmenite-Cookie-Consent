<?php
/*
 *	Plugin Name: 	Ilmenite Cookie Consent
 *	Plugin URI: 	https://github.com/bernskioldmedia/Ilmenite-Cookie-Consent
 *	Description: 	A simple, developer-friendly WordPress plugin that lets visitors know that the site is using cookies.
 *	Author: 		Bernskiold Media
 *	Version: 		2.0.3
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
	public $version = '2.0.3';

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
		$this->init_hooks();

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
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );

		// Add Styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'styles' ] );

		// Register customizer fields.
		add_action( 'customize_register', [ $this, 'customizer_settings' ] );

		// Add Translation Loading.
		add_action( 'plugins_loaded', [ $this, 'load_languages' ] );

		// Add body class
		add_filter( 'body_class', [ $this, 'banner_body_class' ] );

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

		wp_register_script( 'ilmenite-cookie-consent', $this->plugin_url . '/assets/scripts/dist/cookie-banner.js', [ 'jquery' ], $this->version, true );

		/**
		 * We localize the script to add our texts.
		 * These are changeable by filters. See the functions
		 * that get the texts below.
		 */
		wp_localize_script( 'ilmenite-cookie-consent', 'ilcc', [
			'cookieConsentTitle' => $this->get_consent_title(),
			'cookieConsentText'  => $this->get_consent_text(),
			'acceptText'         => $this->get_accept_text(),
			'style'              => $this->get_style(),
		] );

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
		if ( false === apply_filters( 'ilcc_load_stylesheet', true ) || true === ILCC_DEV_MODE ) {
			return;
		}

		/**
		 * Register the main stylesheet.
		 */
		wp_register_style( 'ilmenite-cookie-consent', $this->plugin_url . '/assets/styles/dist/cookie-banner.css', false, $this->version, 'all' );

		// Finally, enqueue!
		wp_enqueue_style( 'ilmenite-cookie-consent' );

	}

	/**
	 * Add settings in the customer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function customizer_settings( $wp_customize ) {

		/**
		 * Set the filter to false to prevent the customizer
		 * settings from showing up.
		 */
		if ( ! apply_filters( 'ilcc_enable_customizer', true ) ) {
			return;
		}

		$wp_customize->add_section( 'ilmenite_cookie_banner', [
			'title'       => __( 'Cookie Banner', 'ilmenite-cookie-consent' ),
			'description' => __( 'Customize the appearance and texts in the cookie banner, used for EU cookie compliance.', 'ilmenite-cookie-consent' ),
			'priority'    => 120,
		] );

		/**
		 * Title
		 */
		$wp_customize->add_setting( 'ilcc_title', [
			'default'    => __( 'This website uses cookies to enhance the browsing experience', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_title_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_title', [
			'label'       => __( 'Title', 'ilmenite-cookie-consent' ),
			'description' => __( 'Keep the title short. It is styled prominently.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_title',
			'section'     => 'ilmenite_cookie_banner',
			'priority'    => 80,
		] ) );

		/**
		 * Text with link
		 */
		$wp_customize->add_setting( 'ilcc_text', [
			'default'    => __( 'By continuing you give us permission to deploy cookies as per our %linkstart%privacy and cookies policy%linkend%.', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_text_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_text', [
			'label'       => __( 'Text', 'ilmenite-cookie-consent' ),
			'description' => __( 'A secondary line of info about your cookie usage. Remember to link to the policy by using the %linkstart% and %linkend% placeholders.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_text',
			'section'     => 'ilmenite_cookie_banner',
			'priority'    => 80,
		] ) );

		/**
		 * URL setting
		 */
		$wp_customize->add_setting( 'ilcc_policy_url', [
			'default'    => get_privacy_policy_url(),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_policy_url_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_policy_url', [
			'label'       => __( 'Cookie Policy Link', 'ilmenite-cookie-consent' ),
			'description' => __( 'Enter a link to your privacy and cookie policy where you outline the use of cookies.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_policy_url',
			'section'     => 'ilmenite_cookie_banner',
			'priority'    => 80,
		] ) );

		/**
		 * Button
		 */
		$wp_customize->add_setting( 'ilcc_button', [
			'default'    => __( 'I Understand', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_button', [
			'label'       => __( 'Button Text', 'ilmenite-cookie-consent' ),
			'description' => __( 'Displays the message on the action button that closes the consent banner and assumes consent.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_button',
			'section'     => 'ilmenite_cookie_banner',
			'priority'    => 80,
		] ) );

		/**
		 * Style
		 */
		$wp_customize->add_setting( 'ilcc_style', [
			'default'    => 'top',
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_style_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_style', [
			'label'       => __( 'Style', 'ilmenite-cookie-consent' ),
			'description' => __( 'The banner can appear both at the top, or overlaid at the bottom of the page.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_style',
			'section'     => 'ilmenite_cookie_banner',
			'priority'    => 80,
			'type'        => 'radio',
			'choices'     => [
				'top'     => __( 'Top', 'ilmenite-cookie-consent' ),
				'overlay' => __( 'Overlay', 'ilmenite-cookie-consent' ),
			],
		] ) );

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
	 * Get the informational consent title.
	 *
	 * @return string
	 */
	public function get_consent_title() {

		$title = __( 'This website uses cookies to enhance the browsing experience', 'ilmenite-cookie-consent' );

		if ( get_option( 'ilcc_title' ) ) {
			$title = get_option( 'ilcc_title' );
		}

		return apply_filters( 'ilcc_consent_title', $title );
	}

	/**
	 * Get the informational consent text.
	 *
	 * @return string
	 */
	public function get_consent_text() {

		$policy_url = $this->get_policy_url();

		/* translators: 1. Policy URL */
		$text = sprintf( __( 'By continuing you give us permission to deploy cookies as per our <a href="%s" rel="nofollow">privacy and cookies policy</a>.', 'ilmenite-cookie-consent' ), $policy_url );

		if ( get_option( 'ilcc_text' ) ) {

			$text = get_option( 'ilcc_text' );

			// check if we have linkstart and linkend, replace with link
			if ( strpos( $text, '%linkstart%' ) !== false && strpos( $text, '%linkend%' ) !== false ) {
				$text = str_replace( '%linkstart%', '<a href="' . $policy_url . '" rel="nofollow">', $text );
				$text = str_replace( '%linkend%', '</a>', $text );
			} // if we only have linkstart but no linked, add linkend
			elseif ( strpos( $text, '%linkstart%' ) !== false && strpos( $text, '%linkend%' ) === false ) {
				$text = str_replace( '%linkstart%', '<a href="' . $policy_url . '" rel="nofollow">', $text );
				$text = $text . '</a>';
			} // if we have linkend, but no linkstart, remove linkend
			elseif ( strpos( $text, '%linkstart%' ) === false && strpos( $text, '%linkend%' ) !== false ) {
				$text = str_replace( '%linkend%', '', $text );
			} // if we have a start a-tag but no end, add the end
			elseif ( strpos( $text, '<a' ) !== false && strpos( $text, '</a' ) === false ) {
				$text = $text . '</a>';
			} // if we only have an end a-tag, remove the endtag.
			elseif ( strpos( $text, '<a' ) === false && strpos( $text, '</a' ) !== false ) {
				$text = str_replace( '</a>', '', $text );
			}
		}


		return apply_filters( 'ilcc_consent_text', $text, $policy_url );
	}

	/**
	 * Get the text for the accept button.
	 *
	 * @return string
	 */
	public function get_accept_text() {
		$accept = __( 'I Understand', 'ilmenite-cookie-consent' );

		if ( get_option( 'ilcc_button' ) ) {
			$accept = get_option( 'ilcc_button' );
		}

		return apply_filters( 'ilcc_accept_text', $accept );
	}

	/**
	 * Get the style for the banner.
	 *
	 * @return string
	 */
	public function get_style() {
		$style = 'top';

		if ( get_option( 'ilcc_style' ) ) {
			$style = get_option( 'ilcc_style' );
		}

		return apply_filters( 'ilcc_style', $style );
	}

	/**
	 * Get the name of the cookie.
	 *
	 * @return string
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

		if ( isset( $_COOKIE[ $cookie_name ] ) && $active_value === $_COOKIE[ $cookie_name ] ) {
			$has_consented = true;
		}

		return apply_filters( 'ilcc_has_user_consented', $has_consented, $cookie_name, $active_value );

	}

	/**
	 * Add body classes
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	public function banner_body_class( $classes ) {

		if ( $this->has_user_consented() ) {
			$classes[] = 'has-ilcc-consented';
		} else {
			$classes[] = 'has-ilcc-banner';
			$classes[] = 'ilcc-style-' . $this->get_style();
		}

		return $classes;
	}

}

/**
 * Returns an instance of the plugin class.
 *
 * @return Ilmenite_Cookie_Consent
 */
function ilmenite_cookie_consent() {
	return Ilmenite_Cookie_Consent::instance();
}

// Initialize the class instance only once
ilmenite_cookie_consent();
