=== Ilmenite Cookie Consent ===
Contributors: Erik Bernskiold, bernskioldmedia
Tags: cookies, cookie notice, eu cookie law, cookie compliance, cookie banner, cookie consent
Requires at least: 4.0
Tested up to: 4.7
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple, developer-friendly WordPress plugin with minimum bloat that lets visitors know that the site is using cookies.

== Description ==

There are many WordPress plugins out there which does a lot of fancy things with the cookie consent. We didn't find one we really liked that was really lightweight and developer friendly and so we created our own.

It isn't meant for the masses who want tons of configurable options in the admin (although it will work fine out of the box). For the developer who wants the functionality and being able to convenietly override the styles in the theme without bloat—here's a plugin for you.

See the installation section for more information on how to install. The FAQ section has important information on how to customize the plugin.

= Translations =

Included in the package are translations for the following languages:

- Swedish
- German (Thanks Frank)
- Norwegian (Thanks Kristofer)
- Slovak (Thanks Peter)
- Spanish (Thanks Vigdis & ibertrix)
- Lithuanian
- Italian (Thanks Matteo)

A complete *.pot* file is available in the *translations/* directory. If you use and translate this little plugin, please send us the translation so it can be included!

== Installation ==

We recommend using the built-in plugin installer in WordPress. If you wish to install the plugin manually:

1. Upload `ilmenite-cookie-consent` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Insert a link to your cookie policy in the 'Settings > Reading' page.

== Frequently Asked Questions ==

= How do I set the cookie policy link? =
A settings field is appended to the Settings > Reading screen where you can insert a link to the privacy and cookie policy page.

= Can I disable the default stylesheet? =

Out of the box, the plugin includes a lightweight stylesheet. We suggest you implement it in your theme however. To prevent this plugin from loading its own stylesheet, just set the following constant in your wp-config file:

    // Don't load 'Ilmenite Cookie Consent' stylesheets
    define( 'ILCC_DEV_MODE', true );

Note: The constant needs to be defined before the plugin runs.

= Can I change the text? =
Yes of course. To change the main text in the banner, there is a filter available 'ilcc_consent_text'.
To modify the accept button, the filter 'ilcc_accept_text' is also available.

== Screenshots ==

1. The default design of the cookie consent box on the website.

== Changelog ==

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