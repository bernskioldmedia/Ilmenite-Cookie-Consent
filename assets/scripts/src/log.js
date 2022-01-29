/* eslint-disable no-console */

/**
 * Internal dependencies
 */
import { isDebugging } from "./settings";

export function logDebug( message ) {
	if ( ! isDebugging() ) {
		return;
	}

	console.debug( message );
}

export function logError( message ) {
	if ( ! isDebugging() ) {
		return;
	}

	console.error( message );
}

export function logInfo( message ) {
	if ( ! isDebugging() ) {
		return;
	}

	console.info( message );
}

export function log( message ) {
	if ( ! isDebugging() ) {
		return;
	}

	console.log( message );
}

export function logWarning( message ) {
	if ( ! isDebugging() ) {
		return;
	}

	console.warn( message );
}

export function logTable( object ) {
	if ( ! isDebugging() ) {
		return;
	}

	console.table( object );
}
