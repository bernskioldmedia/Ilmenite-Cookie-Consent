/**
 * Laravel Mix Configuration
 *
 * We use Laravel Mix as an easy-to-understand interface for webpack,
 * which can otherwise be quite complicated. Mix is super simple and
 * works very well.
 *
 * @link https://laravel.com/docs/5.6/mix
 *
 * @author  Bernskiold Media <info@bernskioldmedia.com>
 **/

const { mix }           = require( 'laravel-mix' );

/**************************************************************
 * Build Process
 *
 * This part handles all the compilation and concatenation of
 * all the theme's resources.
 *************************************************************/

/*
 * Set Laravel Mix options.
 *
 * @link https://laravel.com/docs/5.6/mix#postcss
 * @link https://laravel.com/docs/5.6/mix#url-processing
 */
mix.options( {
	postCss: [
		require( 'postcss-preset-env' )()
	],
	processCssUrls: false
} );

/*
 * Builds sources maps for assets.
 *
 * @link https://laravel.com/docs/5.6/mix#css-source-maps
 */
mix.sourceMaps();

/*
 * Process JavaScript
 */
mix.js( `assets/scripts/src/cookie-banner.js`, `assets/scripts/dist` );

/*
 * Process the SCSS
 *
 * @link https://laravel.com/docs/5.6/mix#working-with-stylesheets
 * @link https://laravel.com/docs/5.6/mix#sass
 * @link https://github.com/sass/node-sass#options
 */
const sassConfig = {
	outputStyle: 'compressed',
	indentType: 'tab',
	indentWidth: 1
};

// Process the scss files.
mix.sass( 'assets/styles/src/cookie-banner.scss', `assets/styles/dist`, sassConfig );


/**
 * Process SCSS
 */

/*
 * Custom Webpack Config
 *
 * @link https://laravel.com/docs/5.8/mix#custom-webpack-configuration
 * @link https://webpack.js.org/configuration/
 */
mix.webpackConfig( {
	stats: "minimal",
	devtool: mix.inProduction() ? false : "source-map",
	performance: {
		hints: false
	},
	externals: {
		"jquery": "jQuery",
	},
	plugins: []
} );
