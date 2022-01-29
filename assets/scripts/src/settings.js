export const settings = {
	consentRememberDuration: ilcc.rememberDuration,
	setPreferencesCookieName: ilcc.preferencesCookieName,
	consentedCategories: ilcc.consentedCategoriesCookieName
};

export function getBannerStyle() {
	return ilcc.style;
}

export function isConfigurable() {
	return isMarketingShown() || isAnalyticsShown();
}

export function isAnalyticsShown() {
	return 1 == ilcc.isAnalyticsShown;
}

export function isMarketingShown() {
	return 1 == ilcc.isMarketingShown;
}

export function isDebugging() {
	return 1 === ilcc.debug;
}
