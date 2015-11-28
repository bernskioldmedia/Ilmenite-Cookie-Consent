# Ilmenite Cookie Consent
A simple, developer-friendly WordPress plugin that lets visitors know that the site is using cookies.

There are many WordPress plugins out there which does a lot of fancy things with the cookie consent. We didn't find one we really liked that was really lightweight and developer friendly and so we created our own.

It isn't meant for the masses who want tons of configurable options in the admin (although it will work fine out of the box). For the developer who wants the functionality and being able to convenietly override the styles in the theme without bloat—here's a plugin for you.

## Configuration
The plugin works out of the box with minimal settings. However here are a few things you will probably want to be aware about.

### Set the policy link
A settings field is appended to the Settings > Reading screen where you can insert a link to the privacy and cookie policy page.

### Custom Styling
Out of the box, the plugin includes a lightweight stylesheet. We suggest you implement it in your theme however. To prevent this plugin from loading its own stylesheet, just set the following constant in your wp-config file:

    // Don't load 'Ilmenite Cookie Consent' stylesheets
    define( 'ILCC_DEV_MODE', true );

Note: The constant needs to be defined before the plugin runs.

### Changing the text
To change the text in the banner, there is a filter available 'ilcc_consent_text'. To modify the accept button, the filter 'ilcc_accept_text' is also available.

## Translations
Included in the package are translations for the following languages:
- Swedish
- German
- Norwegian (Thanks Kristofer)
- Slovak (Thanks Peter)
- Spanish (Thanks Vigdis)

A complete *.pot* file is available in the *translations/* directory. If you use and translate this little plugin, please send us the translation so it can be included!

## Changelog

**Version 0.2.8**
- Added Spanish translation (Thanks Vigdis!)
- Fixed a bug where the cookie banner height would be outputted in the JS console.

**Version 0.2.7**
- Added Slovak translation (Thanks Peter!)

**Version 0.2.6**
- Added Norwegian (Bokmål) translation (Thanks Kristofer!)
- Updated German translation with missing string
- Fixes dev mode constant
- Remove the GitHub Updater. Plugin will be added to the WordPress respository.

**Version 0.2.5**
- Performance Increase: Don't load scripts and styles if the cookie has already been set.

**Version 0.2.4**
- Fixed a miss in the new CSS

**Version 0.2.3**
- Fixed a bug where the settings wouldn't save due to an incorrectly specified settings area. (Thanks to jnylin https://github.com/jnylin)
- Added mobile friendly default styles

**Version 0.2.2**
- Fixed a bug where the localization function wasn't properly loaded.
- Fixed a bug where some textdomains were not properly specified.

**Version 0.2.1**
- Fixed a bug where the language files weren't properly loaded.

**Version 0.2.0**
- Added GitHub updater
- Added settings field for policy URL
- Minify script and style
- Added German translation

**Version 0.1.0**
- First plugin version.

## Authors
This plugin was created by Erik Bernskiold at Bernskiold Media [http://www.bernskioldmedia.com].

## License
This plugin is licensed under GPL. Feel free to use it in personal and commercial projects as you wish.