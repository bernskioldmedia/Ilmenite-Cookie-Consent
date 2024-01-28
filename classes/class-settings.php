<?php

class ILCC_Settings {

	public static function hooks() {
		add_action( 'customize_register', [ self::class, 'customizer' ] );

		if ( true === apply_filters( 'ilcc_tracker_settings_enabled', true ) ) {
			add_action( 'admin_init', [ self::class, 'integrity_settings' ] );
			add_action( 'admin_menu', [ self::class, 'integrity_settings_page' ] );
		}
	}

	/**
	 * Get the Policy URL from the settings.
	 *
	 * @return string
	 */
	public static function get_policy_url() {
		$wp_policy_url_page_id = get_option( 'wp_page_for_privacy_policy' );
		$default_url           = '#';
		if ( $wp_policy_url_page_id ) {
			$default_url = get_permalink( $wp_policy_url_page_id );
		}

		return apply_filters( 'ilcc_policy_url', get_option( 'ilcc_policy_url', $default_url ) );
	}

	/**
	 * Get the informational consent title.
	 *
	 * @return string
	 */
	public static function get_consent_title() {
		$title = get_option( 'ilcc_title', __( 'This website uses cookies', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_consent_title', $title );
	}

	/**
	 * Get the informational consent text.
	 *
	 * @return string
	 */
	public static function get_consent_text() {

		$policy_url = self::get_policy_url();

		/* translators: 1. Policy URL */
		$default_text = sprintf( __( 'We use cookies to analyze our traffic, personalize marketing and to provide social media features. <a href="%s" rel="nofollow">Privacy and cookies policy ›</a>.', 'ilmenite-cookie-consent' ), $policy_url );

		$text = get_option( 'ilcc_text', $default_text );

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


		return apply_filters( 'ilcc_consent_text', $text, $policy_url );
	}

	/**
	 * Get the text for the accept button.
	 *
	 * @return string
	 */
	public static function get_accept_text() {
		$text = get_option( 'ilcc_button', __( 'Allow All Cookies', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_accept_text', $text );
	}

	/**
	 * Get the text for the accept button.
	 *
	 * @return string
	 */
	public static function get_only_necessary_text() {
		$text = get_option( 'ilcc_only_necessary_text', __( 'Only Necessary', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_only_necessary_text', $text );
	}

	/**
	 * Get the text for the settings configuration link.
	 *
	 * @return string
	 */
	public static function get_configure_settings_text() {
		$text = get_option( 'ilcc_configure_settings_text', __( 'Configure Settings', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_configure_settings_text', $text );
	}

	/**
	 * Get the style for the banner.
	 *
	 * @return string
	 */
	public static function get_style() {
		$style = get_option( 'ilcc_style', 'overlay' );

		return apply_filters( 'ilcc_style', $style );
	}

	/**
	 * Get the heading for the necessary cookies section.
	 *
	 * @return string
	 */
	public static function get_settings_necessary_heading() {
		$text = get_option( 'ilcc_settings_necessary_heading', __( 'Necessary', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_settings_necessary_heading', $text );
	}

	/**
	 * Get the description for the necessary cookies section.
	 *
	 * @return string
	 */
	public static function get_settings_necessary_description() {
		$text = get_option( 'ilcc_settings_necessary_description', __( 'These cookies cannot be disabled. They are requires for the website to work.', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_settings_necessary_description', $text );
	}

	/**
	 * Get the heading for the marketing cookies section.
	 *
	 * @return string
	 */
	public static function get_settings_marketing_heading() {
		$text = get_option( 'ilcc_settings_marketing_heading', __( 'Marketing', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_settings_marketing_heading', $text );
	}

	/**
	 * Get the description for the marketing cookies section.
	 *
	 * @return string
	 */
	public static function get_settings_marketing_description() {
		$text = get_option( 'ilcc_settings_marketing_description', __( 'By sharing your browsing behavior on our website we are able to serve you with personalized content and offers.', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_settings_marketing_description', $text );
	}

	/**
	 * Get the heading for the analytics cookies section.
	 *
	 * @return string
	 */
	public static function get_settings_analytics_heading() {
		$text = get_option( 'ilcc_settings_analytics_heading', __( 'Analytics', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_settings_analytics_heading', $text );
	}

	/**
	 * Get the description for the analytics cookies section.
	 *
	 * @return string
	 */
	public static function get_settings_analytics_description() {
		$default = __( 'To be able to improve the website including information and functionality we want to gather analytics. We are not able to identify you personally using this data.', 'ilmenite-cookie-consent' );

		$text = get_option( 'ilcc_settings_analytics_description', $default );

		return apply_filters( 'ilcc_settings_analytics_description', $text );
	}

	/**
	 * Get the save settings button title.
	 *
	 * @return string
	 */
	public static function get_save_settings_button_title() {
		$text = get_option( 'ilcc_save_settings_text', __( 'Save Settings', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_save_settings_text', $text );
	}

	/**
	 * Get the settings title.
	 *
	 * @return string
	 */
	public static function get_settings_title() {
		$accept = get_option( 'ilcc_settings_title', __( 'Select Cookies', 'ilmenite-cookie-consent' ) );

		return apply_filters( 'ilcc_settings_title', $accept );
	}

	/**
	 * Get the save settings button title.
	 *
	 * @return string
	 */
	public static function get_settings_description() {
		$default = __( 'Cookies are small text files that the web server stores on your computer when you visit the website.', 'ilmenite-cookie-consent' );
		$text    = get_option( 'ilcc_settings_description', $default );

		return apply_filters( 'ilcc_settings_description', $text );
	}

	/**
	 * Check whether the analytics section should be shown or not.
	 *
	 * @return bool
	 */
	public static function is_analytics_shown() {
		$hidden = empty( get_option( 'ilcc_settings_analytics_is_shown' ) );
		$shown  = ! $hidden;

		return apply_filters( 'ilcc_settings_analytics_is_shown', $shown );
	}

	/**
	 * Check whether the marketing section should be shown or not.
	 *
	 * @return bool
	 */
	public static function is_marketing_shown() {
		$hidden = empty( get_option( 'ilcc_settings_marketing_is_shown' ) );
		$shown  = ! $hidden;

		return apply_filters( 'ilcc_settings_marketing_is_shown', $shown );
	}

	/**
	 * Add settings in the customer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public static function customizer( $wp_customize ) {

		/**
		 * Set the filter to false to prevent the customizer
		 * settings from showing up.
		 */
		if ( ! apply_filters( 'ilcc_enable_customizer', true ) ) {
			return;
		}

		$wp_customize->add_panel( 'ilmenite_cookie_banner', [
			'priority'    => 120,
			'capability'  => apply_filters( 'ilcc_edit_style_capability', 'edit_theme_options' ),
			'title'       => __( 'Cookie Banner', 'ilmenite-cookie-consent' ),
			'description' => __( 'Customize the appearance and texts in the cookie banner, used for EU cookie compliance.', 'ilmenite-cookie-consent' ),
		] );

		$wp_customize->add_section( 'ilmenite_cookie_banner_style', [
			'title' => __( 'Style', 'ilmenite-cookie-consent' ),
			'panel' => 'ilmenite_cookie_banner',
		] );

		$wp_customize->add_section( 'ilmenite_cookie_banner_general', [
			'title' => __( 'General', 'ilmenite-cookie-consent' ),
			'panel' => 'ilmenite_cookie_banner',
		] );

		$wp_customize->add_section( 'ilmenite_cookie_banner_necessary', [
			'title' => __( 'Section: Necessary', 'ilmenite-cookie-consent' ),
			'panel' => 'ilmenite_cookie_banner',
		] );

		$wp_customize->add_section( 'ilmenite_cookie_banner_analytics', [
			'title' => __( 'Section: Analytics', 'ilmenite-cookie-consent' ),
			'panel' => 'ilmenite_cookie_banner',
		] );

		$wp_customize->add_section( 'ilmenite_cookie_banner_marketing', [
			'title' => __( 'Section: Marketing', 'ilmenite-cookie-consent' ),
			'panel' => 'ilmenite_cookie_banner',
		] );

		/**
		 * Style
		 */
		$wp_customize->add_setting( 'ilcc_style', [
			'default'    => 'overlay',
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_style_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_style', [
			'label'       => __( 'Style', 'ilmenite-cookie-consent' ),
			'description' => __( 'The banner can appear both at the top, or overlaid at the bottom of the page.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_style',
			'section'     => 'ilmenite_cookie_banner_style',
			'priority'    => 80,
			'type'        => 'radio',
			'choices'     => [
				'top'      => __( 'Top', 'ilmenite-cookie-consent' ),
				'overlay'  => __( 'Overlay', 'ilmenite-cookie-consent' ),
				'takeover' => __( 'Take Over', 'ilmenite-cookie-consent' ),
			],
		] ) );

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
			'section'     => 'ilmenite_cookie_banner_general',
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
			'label'       => __( 'Description', 'ilmenite-cookie-consent' ),
			'description' => __( 'A secondary line of info about your cookie usage. Remember to link to the policy by using the %linkstart% and %linkend% placeholders.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_text',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
			'type'        => 'textarea',
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
			'description' => __( 'Enter a link to your privacy and cookie policy where you outline the use of cookies. If left blank, the privacy policy page from Settings > Privacy will be used.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_policy_url',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
		] ) );

		/**
		 * Button
		 */
		$wp_customize->add_setting( 'ilcc_button', [
			'default'    => __( 'Allow All Cookies', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_button', [
			'label'       => __( 'Accept All Button Text', 'ilmenite-cookie-consent' ),
			'description' => __( 'Displays the message on the call to action button that adds consent for everything.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_button',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
		] ) );

		/**
		 * Only Necessary Button
		 */
		$wp_customize->add_setting( 'ilcc_only_necessary_text', [
			'default'    => __( 'Only Necessary', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_only_necessary_text', [
			'label'       => __( 'Only Necessary Cookies Button Text', 'ilmenite-cookie-consent' ),
			'description' => __( 'A secondary button that displays a call to action where the user can accept only the necessary cookies on the page. This essentially just closes the banner.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_only_necessary_text',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
		] ) );

		/**
		 * Only Necessary Button
		 */
		$wp_customize->add_setting( 'ilcc_configure_settings_text', [
			'default'    => __( 'Configure Settings', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_configure_settings_text', [
			'label'       => __( 'Configure Settings Button Text', 'ilmenite-cookie-consent' ),
			'description' => __( 'A small button/link that the user can click on to open more fine-grained settings.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_configure_settings_text',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
		] ) );

		/**
		 * Settings Title
		 */
		$wp_customize->add_setting( 'ilcc_settings_title', [
			'default'    => __( 'Select Cookies', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_title', [
			'label'       => __( 'Settings Title', 'ilmenite-cookie-consent' ),
			'description' => __( 'The title for the settings selection area.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_title',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
		] ) );

		/**
		 * Settings Description
		 */
		$wp_customize->add_setting( 'ilcc_settings_description', [
			'default'    => __( 'Cookies are small text files that the web server stores on your computer when you visit the website.', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_description', [
			'label'       => __( 'Settings Description', 'ilmenite-cookie-consent' ),
			'description' => __( 'A description to further let people know what cookies are for and why they can select different options.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_description',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
		] ) );

		/**
		 * Necessary Heading
		 */
		$wp_customize->add_setting( 'ilcc_settings_necessary_heading', [
			'default'    => __( 'Necessary', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_necessary_heading', [
			'label'       => __( 'Necessary Heading', 'ilmenite-cookie-consent' ),
			'description' => __( 'A title for the necessary cookie group.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_necessary_heading',
			'section'     => 'ilmenite_cookie_banner_necessary',
			'priority'    => 80,
		] ) );

		/**
		 * Necessary Text
		 */
		$wp_customize->add_setting( 'ilcc_settings_necessary_description', [
			'default'    => __( 'These cookies cannot be disabled. They are requires for the website to work.', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_necessary_description', [
			'label'       => __( 'Necessary Description', 'ilmenite-cookie-consent' ),
			'description' => __( 'Describes what the necessary cookies are used for.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_necessary_description',
			'section'     => 'ilmenite_cookie_banner_necessary',
			'priority'    => 80,
			'type'        => 'textarea',
		] ) );

		/**
		 * Show Analytics Section
		 */
		$wp_customize->add_setting( 'ilcc_settings_analytics_is_shown', [
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_analytics_is_shown', [
			'type'        => 'checkbox',
			'label'       => __( 'Show Analytics Section', 'ilmenite-cookie-consent' ),
			'description' => __( 'When checked the analytics configuration section is shown. If you have no analytics trackers you can disable this section.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_analytics_is_shown',
			'section'     => 'ilmenite_cookie_banner_analytics',
			'priority'    => 80,
		] ) );

		/**
		 * Analytics Heading
		 */
		$wp_customize->add_setting( 'ilcc_settings_analytics_heading', [
			'default'    => __( 'Analytics', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_analytics_heading', [
			'label'       => __( 'Analytics Heading', 'ilmenite-cookie-consent' ),
			'description' => __( 'A title for the analytics cookie group.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_analytics_heading',
			'section'     => 'ilmenite_cookie_banner_analytics',
			'priority'    => 80,
		] ) );

		/**
		 * Analytics Text
		 */
		$wp_customize->add_setting( 'ilcc_settings_analytics_description', [
			'default'    => __( 'To be able to improve the website including information and functionality we want to gather analytics. We are not able to identify you personally using this data.', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_analytics_description', [
			'label'       => __( 'Analytics Description', 'ilmenite-cookie-consent' ),
			'description' => __( 'Describes what the analytics cookies are used for.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_analytics_description',
			'section'     => 'ilmenite_cookie_banner_analytics',
			'priority'    => 80,
			'type'        => 'textarea',
		] ) );

		/**
		 * Show Marketing Section
		 */
		$wp_customize->add_setting( 'ilcc_settings_marketing_is_shown', [
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_marketing_is_shown', [
			'type'        => 'checkbox',
			'label'       => __( 'Show Marketing Section', 'ilmenite-cookie-consent' ),
			'description' => __( 'When checked the marketing configuration section is shown. If you have no marketing trackers you can disable this section.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_marketing_is_shown',
			'section'     => 'ilmenite_cookie_banner_marketing',
			'priority'    => 80,
		] ) );

		/**
		 * Marketing Heading
		 */
		$wp_customize->add_setting( 'ilcc_settings_marketing_heading', [
			'default'    => __( 'Marketing', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_marketing_heading', [
			'label'       => __( 'Marketing Heading', 'ilmenite-cookie-consent' ),
			'description' => __( 'A title for the marketing cookie group.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_marketing_heading',
			'section'     => 'ilmenite_cookie_banner_marketing',
			'priority'    => 80,
		] ) );

		/**
		 * Marketing Text
		 */
		$wp_customize->add_setting( 'ilcc_settings_marketing_description', [
			'default'    => __( 'By sharing your browsing behavior on our website we are able to serve you with personalized content and offers.', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_settings_marketing_description', [
			'label'       => __( 'Marketing Description', 'ilmenite-cookie-consent' ),
			'description' => __( 'Describes what the marketing cookies are used for.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_settings_marketing_description',
			'section'     => 'ilmenite_cookie_banner_marketing',
			'priority'    => 80,
			'type'        => 'textarea',
		] ) );

		/**
		 * Save Settings Button Text
		 */
		$wp_customize->add_setting( 'ilcc_save_settings_text', [
			'default'    => __( 'Save Settings', 'ilmenite-cookie-consent' ),
			'type'       => 'option',
			'capability' => apply_filters( 'ilcc_edit_button_capability', 'edit_theme_options' ),
		] );

		$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ilcc_save_settings_text', [
			'label'       => __( 'Save Settings Button Text', 'ilmenite-cookie-consent' ),
			'description' => __( 'The label of the button that lets users save their settings.', 'ilmenite-cookie-consent' ),
			'settings'    => 'ilcc_save_settings_text',
			'section'     => 'ilmenite_cookie_banner_general',
			'priority'    => 80,
		] ) );

	}

	public static function integrity_settings() {

		add_settings_section( 'ilcc_trackers_necessary', __( 'Necessary', 'ilmenite-cookie-consent' ), function () {
			?>
			<p class="section-lead"><?php esc_html_e( 'A user cannot opt out of allowing necessary cookies. These should be cookies that are crucial to the functionality of the site.', 'ilmenite-cookie-consent' ); ?></p>
			<?php
		}, 'ilcc-trackers' );

		add_settings_field( 'ilcc_domains_necessary', __( 'Domains', 'ilmenite-cookie-consent' ), function () {
			?>
			<textarea name="ilcc_domains_necessary" id="ilcc_domains_necessary" style="width: 100%; max-width: 35rem;" rows="10"><?php echo esc_html( implode( "\n", ILCC_Trackers::get_necessary() ) ); ?></textarea>
			<p class="form-description"><?php esc_html_e( 'Enter one domain per line.', 'ilmenite-cookie-consent' ); ?></p>
			<?php
		}, 'ilcc-trackers', 'ilcc_trackers_necessary' );

		add_settings_section( 'ilcc_trackers_analytics', __( 'Analytics', 'ilmenite-cookie-consent' ), function () {
			?>
			<p class="section-lead"><?php esc_html_e( 'Marketing cookies normally track the user behavior either to log in a CRM system or to serve personalized advertising. It is essential for privacy regulation compliance to separate these out and give users an informed choice.', 'ilmenite-cookie-consent' ); ?></p>
			<?php
		}, 'ilcc-trackers' );

		add_settings_field( 'ilcc_domains_analytics', __( 'Domains', 'ilmenite-cookie-consent' ), function () {
			?>
			<textarea name="ilcc_domains_analytics" id="ilcc_domains_analytics" style="width: 100%; max-width: 35rem;" rows="10"><?php echo esc_html( implode( "\n", ILCC_Trackers::get_analytics() ) ); ?></textarea>
			<p class="form-description"><?php esc_html_e( 'Enter one domain per line.', 'ilmenite-cookie-consent' ); ?></p>
			<?php
		}, 'ilcc-trackers', 'ilcc_trackers_analytics' );

		add_settings_section( 'ilcc_trackers_marketing', __( 'Marketing', 'ilmenite-cookie-consent' ), function () {
			?>
			<p class="section-lead"><?php esc_html_e( 'Marketing cookies normally track the user behavior either to log in a CRM system or to serve personalized advertising. It is essential for privacy regulation compliance to separate these out and give users an informed choice.', 'ilmenite-cookie-consent' ); ?></p>
			<?php
		}, 'ilcc-trackers' );

		add_settings_field( 'ilcc_domains_marketing', __( 'Domains', 'ilmenite-cookie-consent' ), function () {
			?>
			<textarea name="ilcc_domains_marketing" id="ilcc_domains_marketing" style="width: 100%; max-width: 35rem;" rows="10"><?php echo esc_html( implode( "\n", ILCC_Trackers::get_marketing() ) ); ?></textarea>
			<p class="form-description">Enter one domain per line.</p>
			<?php
		}, 'ilcc-trackers', 'ilcc_trackers_marketing' );

		register_setting( 'ilcc-trackers', 'ilcc_domains_necessary' );
		register_setting( 'ilcc-trackers', 'ilcc_domains_analytics' );
		register_setting( 'ilcc-trackers', 'ilcc_domains_marketing' );
	}

	public static function integrity_settings_page() {
		add_options_page( __( 'Tracker Control', 'ilmenite-cookie-consent' ), __( 'Tracker Control', 'ilmenite-cookie-consent' ), 'manage_options', 'ilcc-trackers', function () {
			?>
			<div class="wrap">
				<h1><?php esc_html_e( 'Tracker Control', 'ilmenite-cookie-consent' ); ?></h1>
				<p class="lead"><?php esc_html_e( 'For privacy regulation compliance it is important to give the user an informed decision to be tracked and profiled. We do this by dividing any cookie setting domains into three categories.', 'ilmenite-cookie-consent' ); ?></p>
				<p><?php esc_html_e( 'Adding domains to these disallow-lists will ensure that scripts aren\'t loading and sending data through before the user has consented.', 'ilmenite-cookie-consent' ); ?></p>
				<form action='options.php' method='post'>
					<?php
					settings_fields( 'ilcc-trackers' );
					do_settings_sections( 'ilcc-trackers' );
					submit_button();
					?>
				</form>
			</div>
			<style>

				p {
					max-width: 45rem;
				}

				p.lead {
					font-size: 1.1rem;
					opacity: 0.8;
					margin-top: 0;
				}

				h2 {
					margin-bottom: 0.5em;
				}

				.section-lead {
					margin-top: 0;
				}

				p.form-description {
					font-style: italic;
					font-size: 85%;
				}
			</style>
			<?php
		} );
	}


}
