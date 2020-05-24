/**
 * Internal dependencies
 */
import { getCookieValue, getJsonCookieValue, setCookie } from './cookies';
import { settings } from './settings';

/**
 * Set the "has set preferences" cookie.
 *
 * @param {boolean} hasSet If preference has been stored.
 */
export function setHasSetPreferences( hasSet = true ) {
	let value = '1';

	if ( ! hasSet ) {
		value = '0';
	}

	setCookie( settings.setPreferencesCookieName, value );
}

/**
 * Set the consented categories.
 *
 * @param {Array} categories
 */
export function setConsentedCategories( categories = [] ) {
	setCookie( settings.consentedCategories, JSON.stringify( categories ) );
}

/**
 * Get the consented categories as object.
 *
 * @return {Object} Object of categories.
 */
export function getConsentedCategories() {
	return getJsonCookieValue( settings.consentedCategories );
}

/**
 * Check if user has set their preferences.
 *
 * @return {boolean} Prefs set or not.
 */
export function hasUserSetPreferences() {
	return '1' === getCookieValue( settings.setPreferencesCookieName );
}
