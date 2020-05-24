export function showBanner() {
	const consentBlock = '<div class="ilcc-cookie-consent-notice js--ilcc-cookie-consent-notice" id="cookie-consent-block"><div class="ilcc-cookie-consent-notice-content"><p><span>' + ilcc.cookieConsentTitle + '</span>' + ilcc.cookieConsentText + '</p><div class="ilcc-cookie-consent-actions"><button class="ilcc-cookie-consent-necessary js--ilcc-cookie-consent-necessary ilcc-cookie-consent-button">' + ilcc.necessaryText + '</button><button class="ilcc-cookie-consent-close js--ilcc-cookie-consent-close close-cookie-block ilcc-cookie-consent-button">' + ilcc.acceptText + '</button><button class="ilcc-cookie-consent-settings js--ilcc-cookie-consent-settings">Configure Settings</button></div></div></div>';

	// Get body tag
	const $body = jQuery( 'body.has-ilcc-banner' );

	// Append to body
	$body.append( consentBlock );

	// Get the height of the consent block
	const consentBlockHeight = jQuery( '.js--ilcc-cookie-consent-notice' ).innerHeight();

	// Add class to body if top style.
	if ( $body.hasClass( 'ilcc-style-top' ) ) {
		$body.css( 'padding-top', consentBlockHeight + 'px' );
	}
}

export function removeBanner() {
	jQuery( '.js--ilcc-cookie-consent-notice' ).slideToggle( {
		start() {
			const $body = jQuery( 'body' );

			if ( $body.hasClass( 'ilcc-style-top' ) ) {
				$body.animate( {
					'padding-top': '0px',
				} );
			}
		},
		complete() {
			// Remove cookie banner class
			jQuery( 'body' )
				.removeClass( 'has-ilcc-banner' )
				.removeClass( 'ilcc-style-top' )
				.removeClass( 'ilcc-style-overlay' )
				.addClass( 'has-ilcc-consented' );

			// Remove the cookie banner from the DOM.
			jQuery( this ).remove();
		},
	} );
}
