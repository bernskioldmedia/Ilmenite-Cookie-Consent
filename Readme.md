# Ilmenite Cookie Consent
A simple, developer-friendly WordPress plugin that lets visitors know that the site is using cookies.

There are many WordPress plugins out there which does a lot of fancy things with the cookie consent. We didn't find one we really liked that was really lightweight and developer friendly and so we created our own.

It isn't meant for the masses who want tons of configurable options in the admin (although it will work fine out of the box). For the developer who wants the functionality and being able to convenietly override the styles in the theme without bloat—here's a plugin for you.

~Current Version:0.2.0~

## Configuration
The plugin works out of the box with minimal settings. However here are a few things you will probably want to be aware about.

### Set the policy link
A settings field is appended to the Settings > Reading screen where you can insert a link to the privacy and cookie policy page.

### Custom Styling
Out of the box, the plugin includes a lightweight stylesheet. We suggest you implement it in your theme however. To prevent this plugin from loading its own stylesheet, just set the following constant in your theme:

    // Don't load 'Ilmenite Cookie Consent' stylesheets
    define( 'ILCC_DEV_MODE', true );

### Changing the text
To change the text in the banner, there is a filter available 'ilcc_consent_text'. To modify the accept button, the filter 'ilcc_accept_text' is also available.

## Translations
Included in the package are translations for the following languages:
- Swedish

A complete *.pot* file is available in the *translations/* directory. If you use and translate this little plugin, please send us the translation so it can be included!

## Changelog

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