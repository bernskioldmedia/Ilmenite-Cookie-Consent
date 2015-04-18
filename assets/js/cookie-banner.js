// Ilmenite Cookie Banner v 0.0.1
// by Bernskiold Media

// Variables
var noCookieMode = false;						// Debug Mode: true will disable the cookie, allowing you to debug the banner.
var consentDuration = 30;						// Duration in Days: The number of days before the cookie should expire.
var containerID = 'cookie-consent-block';		// The ID of the notice container div
var cookieName = 'EUCookieConsent';				// The name of the cookie
var cookieActiveValue = '1';					// The active value of the cookie.

function setComplianceCookie() {

    // If no debug mode, set the cookie
    if ( ! window.noCookieMode ) {

    	// Set the consent duration into a cookie date string
		var date = new Date();
	    date.setTime(date.getTime()+(window.consentDuration*24*60*60*1000));

	    // Set the actual cookie
		document.cookie = window.cookieName + '=' + window.cookieActiveValue + '; expires=' + date.toGMTString() + '; path=/';

	}

}

function createConsentDiv() {

	// Get body tag
	var bodytag = document.getElementsByTagName('body')[0];

	// Create Cookie Div
	var div = document.createElement('div');
	div.setAttribute('id', window.containerID);

	// Set the contents
	div.innerHTML = '<p>' + ilcc.cookieConsentText + '<a class="close-cookie-block" href="javascript:void(0);" onclick="removeMe();">' + ilcc.acceptText + '</a></p>';

	// Append to body
	bodytag.appendChild(div);

	// Add class to body
	document.getElementsByTagName('body')[0].className+=' has-cookie-banner';

	// Set the cookie
	setComplianceCookie();

}

function checkCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

window.onload = function(){
    if(checkCookie(window.cookieName) != window.cookieActiveValue){
        createConsentDiv();
    }
}

function removeMe(){
	var element = document.getElementById( window.containerID );
	element.parentNode.removeChild(element);
}