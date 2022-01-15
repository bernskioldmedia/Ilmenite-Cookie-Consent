const mix = require( "laravel-mix" );

const assetPaths = {
	scripts: "assets/scripts",
	styles: "assets/styles",
	images: "assets/images",
	fonts: "assets/fonts"
};

mix.options( {
	processCssUrls: false,
	postCss: [
		require( "postcss-preset-env" )( {
			stage: 3,
			browsers: [
				"> 1%",
				"last 2 versions"
			]
		} )
	]
} );

if ( ! mix.inProduction() ) {
	mix.sourceMaps();
}

mix.js(
	`${assetPaths.scripts}/src/index.js`,
	`${assetPaths.scripts}/dist/cookie-banner.js`
);

mix.copy(
	`node_modules/yett/dist/yett.min.modern.js`,
	`${assetPaths.scripts}/dist/cookie-banner-vendor.js`
);

mix.copy(
	`node_modules/yett/dist/yett.min.js.map`,
	`${assetPaths.scripts}/dist/yett.min.modern.js.map`
);

mix.sass(
	`${assetPaths.styles}/src/cookie-banner.scss`,
	`${assetPaths.styles}/dist`,
	{
		sassOptions: {
			outputStyle: "compressed"
		}
	}
);
