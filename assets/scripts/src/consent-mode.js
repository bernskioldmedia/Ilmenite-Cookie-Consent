import {getConsentedCategories} from "./consent";

export function isConsentModeEnabled() {
	return ilcc.consentModeEnabled === '1';
}

function hasGtagOnPage() {
	return typeof gtag === 'function';
}

export function grantConsent() {
	if (!isConsentModeEnabled() || !hasGtagOnPage()) {
		return;
	}

	const consentedCategories = getConsentedCategories();
	const hasMarketingConsent = consentedCategories.includes('marketing');

	gtag('consent', 'update', {
		ad_user_data: hasMarketingConsent ? 'granted' : 'denied',
		ad_personalization: hasMarketingConsent ? 'granted' : 'denied',
		ad_storage: hasMarketingConsent ? 'granted' : 'denied',
		analytics_storage: hasMarketingConsent ? 'granted' : 'denied'
	});
}
