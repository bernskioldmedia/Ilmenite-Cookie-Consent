/**
 * Internal dependencies
 */
import { addConsentedCategory, hasConsentedTo, removeConsentedCategory } from './consent';

export function showBanner() {
	const consentBlock = '<div class="ilcc-cookie-consent-notice js--ilcc-cookie-consent-notice" id="cookie-consent-block"><div class="ilcc-cookie-consent-notice-content"><p><span>' + ilcc.cookieConsentTitle + '</span>' + ilcc.cookieConsentText + '</p><div class="ilcc-cookie-consent-actions"><button class="ilcc-cookie-consent-necessary js--ilcc-cookie-consent-necessary ilcc-cookie-consent-button">' + ilcc.necessaryText + '</button><button class="ilcc-cookie-consent-close js--ilcc-cookie-consent-close close-cookie-block ilcc-cookie-consent-button">' + ilcc.acceptText + '</button><button class="ilcc-cookie-consent-settings-toggle js--ilcc-cookie-consent-settings-toggle">Configure Settings</button></div></div>' + renderSettings() + '</div>';

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
				.removeClass( 'ilcc-style-takeover' )
				.addClass( 'has-ilcc-consented' );

			// Remove the cookie banner from the DOM.
			jQuery( this ).remove();
		},
	} );
}

export function toggleSettings() {
	jQuery( '.js--ilcc-cookie-consent-settings' ).slideToggle();
}

function renderSettings() {
	return `
		<div class="ilcc-cookie-consent-settings js--ilcc-cookie-consent-settings">
		<p class="ilcc-cookie-consent-settings-title">${ ilcc.settingsTitle }</p>
		<p class="ilcc-cookie-consent-settings-intro">${ ilcc.settingsDescription }</p>
		<div class="ilcc-cookie-consent-categories">
			<a href="#" class="ilcc-cookie-consent-category ilcc-toggle-disabled" data-category="necessary">
				<span class="ilcc-cookie-consent-category-info">
					<strong>${ ilcc.necessaryHeading }</strong>
					<p>${ ilcc.necessaryDescription }</p>
				</span>
				<span class="ilcc-cookie-consent-category-toggle">
				${ renderToggle() }
				</span>
			</a>
			<a href="#" class="ilcc-cookie-consent-category js--ilcc-cookie-consent-toggle ${ renderActiveSelector( 'analytics' ) }" data-category="analytics">
				<span class="ilcc-cookie-consent-category-info">
					<strong>${ ilcc.analyticsHeading }</strong>
					<p>${ ilcc.analyticsDescription }</p>
				</span>
				<span class="ilcc-cookie-consent-category-toggle">
				${ renderToggle() }
				</span>
			</a>
			<a href="#" class="ilcc-cookie-consent-category js--ilcc-cookie-consent-toggle ${ renderActiveSelector( 'marketing' ) }" data-category="marketing">
				<span class="ilcc-cookie-consent-category-info">
					<strong>${ ilcc.marketingHeading }</strong>
					<p>${ ilcc.marketingDescription }</p>
				</span>
				<span class="ilcc-cookie-consent-category-toggle">
				${ renderToggle() }
				</span>
			</a>
		</div>
		<div class="ilcc-cookie-consent-settings-save">
			<button class="ilcc-cookie-consent-button js--ilcc-cookie-consent-settings-save-button">${ ilcc.saveSettingsText }</button>
		</div>
</div>
	`;
}

function renderActiveSelector( category ) {
	return hasConsentedTo( category ) ? 'ilcc-toggle-active' : '';
}

function renderToggle() {
	return `<span class="ilcc-cookie-consent-toggle"><span class="ilcc-cookie-consent-toggle-handle"></span></span>`;
}

export function toggleCategory( element ) {
	const category = element.dataset.category;

	if ( element.classList.contains( 'ilcc-toggle-active' ) ) {
		removeConsentedCategory( category );
		element.classList.remove( 'ilcc-toggle-active' );
	} else {
		addConsentedCategory( category );
		element.classList.add( 'ilcc-toggle-active' );
	}
}
