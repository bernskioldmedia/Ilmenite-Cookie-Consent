/**
 * Internal dependencies
 */
import { removeBanner, showBanner, toggleCategory, toggleSettings } from "./banner";
import { hasConsentedTo, hasUserSetPreferences, setConsentedCategories, setHasSetPreferences } from "./consent";
import { getJsonCookieValue } from "./cookies";
import { log, logDebug } from "./log";
import { getBannerStyle, hasMatomo, isConfigurable, isDebugging, settings } from "./settings";

document.addEventListener( "DOMContentLoaded", () => {

	log( "=========== COOKIE CONSENT DEBUGGING ===========" );

	window.YETT_BLACKLIST = [];

	if ( ! hasConsentedTo( "marketing" ) ) {
		window.YETT_BLACKLIST.concat( ilcc.marketingDomains );
	}

	if ( ! hasConsentedTo( "analytics" ) ) {
		window.YETT_BLACKLIST.concat( ilcc.analyticsDomains );
	}

	window.YETT_WHITELIST = ilcc.necessaryDomains;

	if ( hasConsentedTo( "marketing" ) ) {
		window.YETT_WHITELIST.concat( ilcc.marketingDomains );
	}

	if ( hasConsentedTo( "analytics" ) ) {
		window.YETT_WHITELIST.concat( ilcc.analyticsDomains );
	}

	logDebug( "Allowed Domains:" );
	logDebug( window.YETT_WHITELIST );

	logDebug( "Disallowed Domains:" );
	logDebug( window.YETT_BLACKLIST );

	/**
	 * If the user has not already consented, show the banner.
	 */
	if ( hasUserSetPreferences() ) {
		logDebug( "✅ User has expressed consent." );
		logDebug( "The following categories were granted:" );
		logDebug( getJsonCookieValue( settings.consentedCategories ) );
		document.body.classList.add( "has-ilcc-consented" );

		if ( hasMatomo() && hasConsentedTo( "analytics" ) ) {
			_paq.push( [ "setCookieConsentGiven" ] );
		}

	} else {
		logDebug( "❌ User has not expressed consent." );
		document.body.classList.add( "has-ilcc-banner" );
		document.body.classList.add( "ilcc-style-" + getBannerStyle() );
		showBanner();
	}

	if ( isDebugging() ) {
		document.body.classList.add( "ilcc-is-debugging" );
	}

	if ( document.querySelector( ".js--ilcc-cookie-consent-notice" ) ) {
		document.querySelector( ".js--ilcc-cookie-consent-close" ).addEventListener( "click", function( e ) {
			e.preventDefault();

			window.yett.unblock();

			removeBanner();
			setHasSetPreferences();
			setConsentedCategories( [
				"necessary",
				"marketing",
				"analytics"
			] );
		} );

		if ( isConfigurable() ) {
			document.querySelector( ".js--ilcc-cookie-consent-necessary" ).addEventListener( "click", function( e ) {
				e.preventDefault();

				removeBanner();
				setHasSetPreferences();
				setConsentedCategories( [
					"necessary"
				] );
			} );

			document.querySelector( ".js--ilcc-cookie-consent-settings-toggle" ).addEventListener( "click", function( e ) {
				e.preventDefault();
				toggleSettings();
			} );

			document.querySelector( ".js--ilcc-cookie-consent-settings-save-button" ).addEventListener( "click", function( e ) {
				e.preventDefault();
				setHasSetPreferences();
				removeBanner();
			} );

			document.querySelectorAll( ".js--ilcc-cookie-consent-toggle" ).forEach( ( toggle ) => {
				toggle.addEventListener( "click", function( e ) {
					e.preventDefault();
					toggleCategory( this );
				} );
			} );
		}
	}

} );
