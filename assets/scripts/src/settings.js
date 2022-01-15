export const settings = {
	debug: document.body.classList.contains( "ilcc-is-debugging" ),
	consentRememberDuration: ilcc.rememberDuration,
	setPreferencesCookieName: ilcc.preferencesCookieName,
	consentedCategories: ilcc.consentedCategoriesCookieName
};

export function isConfigurable() {
	return isMarketingShown() || isAnalyticsShown();
}

export function isAnalyticsShown() {
	return 1 == ilcc.isAnalyticsShown;
}

export function isMarketingShown() {
	return 1 == ilcc.isMarketingShown;
}
