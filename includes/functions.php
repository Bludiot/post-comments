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

/*
 |  SHORTFUNC :: SELECTED
 |  @since  0.1.0
 |
 |  @return die();
 */
function sn_selected( $field, $value = true, $print = true ) {

    //Access global variables.
    global $comments_plugin;

    return $comments_plugin->selected( $field, $value, $print );
}

/*
 |  SHORTFUNC :: CHECKED
 |  @since  0.1.0
 |
 |  @return die();
 */
function sn_checked( $field, $value = true, $print = true ) {

    //Access global variables.
    global $comments_plugin;

    return $comments_plugin->checked( $field, $value, $print );
}
