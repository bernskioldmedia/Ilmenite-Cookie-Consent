=== Ilmenite Cookie Consent ===
Contributors: Erik Bernskiold, bernskioldmedia
Tags: cookies, cookie notice, eu cookie law, cookie compliance, cookie banner, cookie consent
Requires at least: 4.0
Tested up to: 5.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple, developer-friendly WordPress plugin with minimum bloat that lets visitors know that the site is using cookies.

== Description ==

There are many WordPress plugins out there which does a lot of fancy things with the cookie consent. We didn't find one we really liked that was really lightweight and developer friendly and so we created our own.

It isn't meant for the masses who want tons of configurable options in the admin (although it will work and look fine out of the box). Many use this plugin with the default styling because it is so light-weight and good-looking.

For the developer who wants the functionality and being able to convenietly override the styles in the theme without bloat—here's a plugin for you. You have filters and actions available to you at every step of the process.

See the installation section for more information on how to install. The FAQ section has important information on how to customize the plugin.

= Translations =

Included in the package are translations for the following languages:

- Danish (Thanks Magnus)
- German (Thanks Frank)
- Hungarian (Thanks Miklos)
- Italian (Thanks Matteo)
- Lithuanian
- Norwegian (Thanks Kristofer)
- Slovak (Thanks Peter)
- Spanish (Thanks Vigdis & Ibertrix)
- Swedish

A complete *.pot* file is available in the *translations/* directory. If you use and translate this little plugin, please send us the translation so it can be included!

**Even better** is if you use Translate.WordPress.org for your translations. That way, they will be automatically distributed with the WordPress updater.
However, in some locales, the work with the Translate site is not up to speed. We will continue to support included translations a while longer.

== Installation ==

We recommend using the built-in plugin installer in WordPress. If you wish to install the plugin manually:

1. Upload `ilmenite-cookie-consent` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Insert a link to your cookie policy in the 'Settings > Reading' page.

== Frequently Asked Questions ==

= How do I set the cookie policy link? =
You can set the URL to the cookie policy page in the customizer under the "Site Identity" section.

= Can I disable the default stylesheet? =

Out of the box, the plugin includes a lightweight stylesheet. If you don't want to use our default coloring, you can easily prevent us from including the styles.

Just define the following filter somewhere in your code, such as the theme functions.php file:

    apply_filters( 'ilcc_load_stylesheet', '__return_false' );

= Can I change the text? =
To change the text in the consent banner and/or the button label, there are two filters: ilcc_consent_text and ilcc_accept_text.

Just set their value somewhere in your code, such as in the functions.php file of your theme:

    function ilcc_modify_consent_text( $text ) {
        $text = __( 'This is my custom text about how we use cookies.', 'YOURTEXTDOMAIN' );
        return $text;
    }

    apply_filters( 'ilcc_consent_text', 'ilcc_modify_consent_text' );

    function ilcc_modify_accept_text( $text ) {
        $text = __( 'I Accept', 'YOURTEXTDOMAIN' );
        return $text;
    }

    apply_filters( 'ilcc_accept_text', 'ilcc_modify_accept_text' );

 = List of Actions = 

`ilcc_loaded` - Runs on constructor.

`before_ilcc_init` - Runs before we have run any init actions.

`ilcc_init` - Runs when all init hooks have run.

= List of Filters =

`ilcc_has_user_consented` - Specifiy if the user has accepted or not. True or false value. Has arguments $cookie_name and $cookie_value.

`ilcc_cookie_active_value` - Set which value is "active" for the cookie, ie. consented. Defaults to 1.

`ilcc_cookie_name` - Set the name of the cookie. Defaults to 'EUConsentCookie'.

`ilcc_accept_text` - Set the accept button text.

`ilcc_consent_text` - Set the consent text. Has $policy_url as argument.

`ilcc_policy_url` - Allows you to modify the Policy URL. Has the url from the options as argument.

`ilcc_edit_policy_url_capability` - Allows you to modify which capability is required for editing the policy URL in the customizer. Defaults to `edit_theme_options`.

`ilcc_load_stylesheets` - (bool) Set if you want the stylesheets to be loaded or not. Defaults to true.

== Screenshots ==

1. The default design of the cookie consent box on the website.

== Changelog ==

= Version 1.2.0 =

In this release we've made some code improvements as well as improvements to class names and the JavaScript that powers most of the features. You will also have better and more access to filters and actions for customization.

- Improvement: Better class names for the consent box.
- Improvement: Switched to setting the policy URL in the customizer instead of under Settings > Reading.
- Improvement: Re-structured the JavaScript code.
- Improvement: Ensure we get languages from all possible storage folders in WordPress.
- Improvement: Added filter to disable stylesheet loading.
- Improvement: Never process any of the the JS or CSS logic if the user has already consented.
- Improvement: Added filter when we check if user has consented.
- Improvement: Added filter for cookie name.
- Improvement: Added filter for cookie acceptance value.
- Improvement: Modified consent text filter to include the policy URL as a variable.
- Improvement: Added filter for when getting the policy URL.
- Improvement: Switched from an `<a>` tag for the acceptance button, to a more proper `button`.
- Improvement: Added filter to edit the capbility required for editing the Policy URL in the customizer. Defaults to `edit_theme_options`.
- Bug: Fixed a bug where the consent block could add to the DOM multiple times.

= Version 1.1.4 =
Added Danish translation. (Thanks Magnus!)

= Version 1.1.3 =
Added an Hungarian translation. (Thanks Miklos)

= Version 1.1.2 =
Updated a string in the Spanish translation (thanks ibertrix)

= Version 1.1.1 =
We managed to change a string we shouldn't have changed in Version 1.1.0. Sorry about that!

= Version 1.1.0 =
It's time we switch this plugin over to above 1.0 releases.
- Changed the textdomain to conform with the plugin name = text domain. This means we will have full support for the WordPress.org Plugin translations.
- Added Italian translation (Thanks Matteo)

= Version 0.2.9 =
- Improved German translation (Thanks Frank!)
- Added Lithuanian translation
- Minor Code Tweaks & Improvements (just behind the scenes—Thanks Johan)

= Version 0.2.8 =
- Added Spanish translation (Thanks Vigdis!)
- Fixed a bug where the cookie banner height would be outputted in the JS console.

= Version 0.2.7 =
- Added Slovak language support (Thanks Peter!)

= Version 0.2.6 =
- Added Norwegian (Bokmål) translation (Thanks Kristofer!)
- Updated German translation with missing string
- Fixes dev mode constant
- Remove the GitHub Updater. Plugin will be added to the WordPress respository.

= Version 0.2.5**
- Performance Increase: Don't load scripts and styles if the cookie has already been set.

= Version 0.2.4 =
- Fixed a miss in the new CSS

= Version 0.2.3 =
- Fixed a bug where the settings wouldn't save due to an incorrectly specified settings area. (Thanks to jnylin https://github.com/jnylin)
- Added mobile friendly default styles

= Version 0.2.2 =
- Fixed a bug where the localization function wasn't properly loaded.
- Fixed a bug where some textdomains were not properly specified.

= Version 0.2.1 =
- Fixed a bug where the language files weren't properly loaded.

= Version 0.2.0 =
- Added GitHub updater
- Added settings field for policy URL
- Minify script and style
- Added German translation

= Version 0.1.0 =
- First plugin version.

== Upgrade Notice ==

= 1.2.0 =

In this release we've made some code improvements as well as improvements to class names and the JavaScript that powers most of the features. You will also have better and more access to filters and actions for customization.

- Improvement: Better class names for the consent box.
- Improvement: Switched to setting the policy URL in the customizer instead of under Settings > Reading.
- Improvement: Re-structured the JavaScript code.
- Improvement: Ensure we get languages from all possible storage folders in WordPress.
- Improvement: Added filter to disable stylesheet loading.
- Improvement: Never process any of the the JS or CSS logic if the user has already consented.
- Improvement: Added filter when we check if user has consented.
- Improvement: Added filter for cookie name.
- Improvement: Added filter for cookie acceptance value.
- Improvement: Modified consent text filter to include the policy URL as a variable.
- Improvement: Added filter for when getting the policy URL.
- Improvement: Switched from an `<a>` tag for the acceptance button, to a more proper `button`.
- Improvement: Added filter to edit the capbility required for editing the Policy URL in the customizer. Defaults to `edit_theme_options`.
- Bug: Fixed a bug where the consent block could add to the DOM multiple times.

= 1.1.1 =
We managed to change a string we shouldn't have changed in Version 1.1.0. Sorry about that!

= 1.1.0 =
It's time we switch this plugin over to above 1.0 releases.
- Changed the textdomain to conform with the plugin name = text domain. This means we will have full support for the WordPress.org Plugin translations.
- Added Italian translation (Thanks Matteo)

= 0.2.9 =
Improved the German translation.

= 0.2.8 =
Spanish translation has been added, along with a minor bug fix.

= 0.2.7 =
Added Slovak language.

= 0.2.6 =
Improved translations and added Norwegian to the list of supported languages.