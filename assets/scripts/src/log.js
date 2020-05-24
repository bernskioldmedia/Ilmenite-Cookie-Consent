/* eslint-disable no-console */

/**
 * Internal dependencies
 */
import { settings } from './settings';

export function logDebug( message ) {
	if ( ! settings.debug ) {
		return;
	}

	console.debug( message );
}

export function logError( message ) {
	if ( ! settings.debug ) {
		return;
	}

	console.error( message );
}

export function logInfo( message ) {
	if ( ! settings.debug ) {
		return;
	}

	console.info( message );
}

export function log( message ) {
	if ( ! settings.debug ) {
		return;
	}

	console.log( message );
}

export function logWarning( message ) {
	if ( ! settings.debug ) {
		return;
	}

	console.warn( message );
}

export function logTable( object ) {
	if ( ! settings.debug ) {
		return;
	}

	console.table( object );
}
