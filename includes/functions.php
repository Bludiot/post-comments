<?php
/**
 * Comments template abstract
 *
 * @package    Post Comments
 * @subpackage Includes
 * @category   Functions
 * @version    1.0.0
 * @since      1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

/**
 * Language class object
 *
 * Function to use inside other functions and
 * methods rather than calling the global.
 *
 * @since  1.0.0
 * @global object $L Language class
 * @return object
 */
function lang() {
	global $L;
	return $L;
}

/*
 |  S18N :: FORMAT AND GET STRING
 |  @since  0.1.0
 |
 |  @param  string  The respective string to translate.
 |  @param  array   Some additional array for `printf()`.
 |
 |  @return string  The translated and formated string.
 */
function sn__( $string, $args = [] ) {

    //Access global variables.
    global $L;

    $hash  = "s18n-" . md5( strtolower( $string ) );
    $value = $L->g( $hash );
    if ( $hash === $value ) {
        $value = $string;
    }
    return ( count( $args ) > 0 ) ? vsprintf( $value, $args ) : $value;
}

/*
 |  S18N :: FORMAT AND PRINT STRING
 |  @since  0.1.0
 |
 |  @param  string  The respective string to translate.
 |  @param  array   Some additional array for `printf()`.
 |
 |  @return <print>
 */
function sn_e( $string, $args = [] ) {
    print ( sn__( $string, $args ) );
}

/*
 |  SHORTFUNC :: GET VALUE
 |  @since  0.1.0
 |
 |  @param  string  The respective configuration key.
 |
 |  @return multi   The respective value or FALSE if the option doens't exist.
 */
function sn_config( $key ) {

    //Access global variables.
    global $comments_plugin;

    return $comments_plugin->getValue( $key );
}

/*
 |  SHORTFUNC :: RESPONSE
 |  @since  0.1.0
 |
 |  @return die();
 */
function sn_response( $data, $key = null ) {

    //Access global variables.
    global $comments_plugin;

    return $comments_plugin->response( $data, $key );
}

/**
 * Selected helper method
 *
 * @since  1.0.0
 * @param  string $field The respective option key (used in `getValue()`).
 * @param  boolean $value The value to compare with.
 * @param  boolean $print True to print `selected="selected"`.
 *                       False to return the string.
 *                       Use `null` to return as boolean.
 * @return mixed
 */
function selected( $field = '', $value = true, $print = true ) {

    if ( sn_config( $field ) == $value ) {
        $selected = 'selected="selected"';
    } else {
        $selected = '';
    }
    if ( null === $print ) {
        return ! empty( $selected );
    }
    if ( ! $print ) {
        return $selected;
    }
    print( $selected );
}
