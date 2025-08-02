<?php
/**
 * Autoload classes
 *
 * @package    Post Comments
 * @subpackage Includes
 * @version    1.0.0
 * @since      1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

spl_autoload_register( function( $class ) {
    foreach ( [ 'Gregwar', 'PIT', 'OWASP' ] as $allowed ) {
        if ( strpos( $class, $allowed ) !== 0 ) {
            continue;
        }
        $dir_path   = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
        $class_path = str_replace( '\\', DIRECTORY_SEPARATOR, $class );
        require_once $dir_path . $class_path . '.php';
        return true;
    }
    return false;
} );
