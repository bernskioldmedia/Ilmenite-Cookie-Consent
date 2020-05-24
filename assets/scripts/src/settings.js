export const settings = {
	debug: document.body.classList.contains( 'ilcc-is-debugging' ),
	consentRememberDuration: ilcc.rememberDuration,
	setPreferencesCookieName: ilcc.preferencesCookieName,
	consentedCategories: ilcc.consentedCategoriesCookieName,
};
