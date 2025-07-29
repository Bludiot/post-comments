<?php
/**
 * Comments template abstract
 *
 * @package    Post Comments
 * @subpackage Classes
 * @category   Templates
 * @version    1.0.0
 * @since      1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

abstract class Comments_Template {

	/**
	 * Theme name
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $theme_name;

	/**
	 * Theme CSS file
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $theme_css;

	/**
	 * Theme JS file
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $theme_js;

	/**
	 * Frontend form
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $username The previously passed username (on errors only).
	 *                         An array `[ $username, $hash, $nickname ]` if
	 *                         the user is logged in.
	 * @param  string $email The previously passed email address (on errors only).
	 * @param  string $title The previously passed comment title (on errors only).
	 * @param  string $message The previously passed comment message (on errors only).
	 * @return void
	 */
	abstract public function form( $username = '', $email = '', $title = '', $message = '' );

	/**
	 * Individual comment
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $comment The comment instance.
	 * @param  string $uid The unique comment UID.
	 * @param  integer $depth The depth of the comment.
	 * @return void
	 */
	abstract public function comment( $comment, $uid, $depth );

	/**
	 * Comments pagination
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $location The called location: `top` or `bottom`.
	 * @param  integer $cpage The current comment page.<, starting with 1.
	 * @param  integer $limit The number of comments to be shown per page.
	 * @param  integer $count The total number of comments for the content page.
	 * @return void
	 */
	abstract public function pagination( $location, $cpage, $limit, $count );
}
