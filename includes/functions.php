<?php
/**
 * Plugin functions
 *
 * @package    Post Comments
 * @subpackage Includes
 * @since      1.0.0
 */

namespace Post_Comments;

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

/**
 * Plugin object
 *
 * Gets this plugin's core class.
 *
 * @since  1.0.0
 * @return mixed Returns the class object or false.
 */
function plugin() {

	if ( getPlugin( 'Post_Comments' ) ) {
		return getPlugin( 'Post_Comments' );
	} else {
		return false;
	}
}

/**
 * Debug mode
 *
 * Checks if the site is in debug mode.
 *
 * @since  1.0.0
 * @return boolean Returns true if in debug mode.
 */
function debug_mode() {

	if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
		return true;
	}
	return false;
}

/**
 * User logged in
 *
 * @since  1.0.0
 * @global object $login The Login class.
 * @return boolean Returns true if the current user is logged in.
 */
function user_logged_in() {

	// Access global variables.
	global $login;

	if ( $login->isLogged() ) {
		return true;
	}
	return false;
}

function username() {

	$username = 'anonymous';
	if ( user_logged_in() ) {
		$session  = new \User( \Session :: get( 'username' ) );
		$username = $session->username();
	}
	return $username;
}

/**
 * User
 *
 * Returns a user object by username.
 *
 * @since  1.0.0
 * @param  string $name The username.
 * @return object User class.
 */
function user( $name = '' ) {
	return new \User( $name );
}

/**
 * Default avatar
 *
 * Use the default avatar from the User Profiles
 * plugin if it is active. Default to native
 * mystery user image.
 *
 * @since  1.0.0
 * @return void
 */
function default_avatar() {

	if ( getPlugin( 'User_Profiles' ) ) {
		$src = \UPRO_Tags\default_avatar();
	} else {
		$src = plugin()->domainPath() . 'assets/images/user.png';
	}
	return $src;
}

/**
 * Disable comments
 *
 * Looks for the Disable Comments field
 * for a page and returns true or false.
 *
 * Returns false if the custom field is not
 * registered in the site settings for
 * custom fields.
 *
 * ```
 * "disable_comments": {
 *     "type"  : "bool",
 *     "label" : "Disable Comments",
 *     "tip"   : "Close comments for this content."
 * }
 * ```
 *
 * @since  1.0.0
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return boolean
 */
function disable_comments() {

	// Access global variables.
	global $page, $url;

	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}
	if ( $page->custom( 'disable_comments' ) ) {
		return true;
	}
	return false;
}

/**
 * Enqueue assets
 *
 * Whether to load CSS and JavaScript files
 * for the page,
 *
 * @since  1.0.0
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return boolean
 */
function enqueue_assets() {

	// Access global variables.
	global $page, $url;

	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	if ( $page->custom( 'disable_comments' ) ) {
		return false;
	}

	if ( $page->isStatic() && ( 'page' == plugin()->post_types() || 'both' == plugin()->post_types() ) ) {
		return true;
	} elseif ( ! $page->isStatic() && ( 'post' == plugin()->post_types() || 'both' == plugin()->post_types() ) ) {
		return true;
	}
	return false;
}

/**
 * Comments file path
 *
 * Path to a file containing post/page comments.
 * File named by post slug.
 *
 * @since  1.0.0
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return mixed
 */
function comments_file_path() {

	// Access global variables.
	global $page, $url;

	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}
	return PATH_CONTENT . plugin()->file_dir . DS . $page->slug() . '.xml';
}

/**
 * Comments log path
 *
 * @since  1.0.0
 * @return string
 */
function comments_log_path() {
	return PATH_CONTENT . 'post-comments-log.php';
}

/**
 * Comment count
 *
 * Number of approved comments per post.
 *
 * @since  1.0.0
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return integer
 */
function comment_count() {

	// Access global variables.
	global $page, $url;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$file  = comments_file_path();
	$count = 0;

	if ( file_exists( $file ) ) {

		$comments = simplexml_load_file( $file );

		foreach ( $comments->comment as $comment ) {
			if ( (bool) $comment->approved ) {
				$count++;
			}
		}
	}
	return $count;
}

/**
 * Reply count
 *
 * Number of approved replies per post.
 *
 * @since  1.0.0
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return integer
 */
function reply_count() {

	// Access global variables.
	global $page, $url;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$file  = comments_file_path();
	$count = 0;

	if ( file_exists( $file ) ) {

		$comments = simplexml_load_file( $file );

		foreach ( $comments->comment as $comment ) {
			if ( (bool) $comment->approved ) {
				foreach ( $comment->response as $response ) {
					if ( (bool) $response->approved ) {
						$count++;
					}
				}
			}
		}
	}
	return $count;
}

/**
 * Comment & reply count
 *
 * Number of approved comments and replies per post.
 *
 * @since  1.0.0
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return integer
 */
function comment_reply_count() {

	// Access global variables.
	global $page, $url;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$file  = comments_file_path();
	$count = 0;

	if ( file_exists( $file ) ) {

		$comments = simplexml_load_file( $file );

		foreach ( $comments->comment as $comment ) {
			if ( (bool) $comment->approved ) {
				$count++;

				foreach ( $comment->response as $response ) {
					if ( (bool) $response->approved ) {
						$count++;
					}
				}
			}
		}
	}
	return $count;
}

/**
 * Captcha form security
 *
 * @since  1.0.0
 * @param  integer $length
 * @return string
 */
function captcha( $length = 7 ) {
	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$captcha = '';

	for ( $i = 0; $i < $length; $i++ ) {
		$captcha .= $characters[rand( 0, strlen( $characters ) - 1 )];
	}
	return $captcha;
}

function comments_loop() {

	// Access global variables.
	global $L, $page, $url, $users;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$log_path  = comments_log_path();
	$file_path = comments_file_path();

	// Get comments loop if option allows.
	if ( plugin()->logged_comments() && user_logged_in() ) {
		include( plugin()->phpPath() . DS . 'views/loop.php' );
	} elseif ( ! plugin()->logged_comments() ) {
		include( plugin()->phpPath() . DS . 'views/loop.php' );
	}
}

function comment_form() {

	// Access global variables.
	global $L, $page, $url;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$log_path  = comments_log_path();
	$file_path = comments_file_path();

	// Get comment form if option allows.
	if ( plugin()->logged_form() && user_logged_in() ) {
		include( plugin()->phpPath() . DS . 'views/form.php' );
	} elseif ( ! plugin()->logged_form() ) {
		include( plugin()->phpPath() . DS . 'views/form.php' );
	}
}

function post_comments() {

	// Access global variables.
	global $L, $page, $url;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$id        = $page->slug();
	$log_path  = comments_log_path();
	$file_path = comments_file_path();

	if ( isset( $_POST['send_comment'] ) ) {

		$id = $page->title();

		if ( isset( $_POST['captcha_answer'] ) && $_POST['captcha_answer'] == $_SESSION['captcha_question'] ) {
			if ( ! empty( $_POST['honeypot'] ) ) {
				echo 'Nope!';
				exit;
			}

			$name      = htmlentities( $_POST['comment_name'] );
			$username  = $_POST['comment_username'];
			$datetime  = $_POST['comment_datetime'];
			$email     = htmlentities( $_POST['comment_email'] );
			$message   = htmlentities( $_POST['comment_body'] );
			$parent_id = $_POST['parent_id'] !== '' ? htmlentities( $_POST['parent_id'] ) : null;

			$to      = plugin()->admin_email();
			$subject = "New comment: $name";
			$body    = "New Comments: $name\n";
			$body   .= "Email: $email\n";

			$body   .= "Slug page with comment: $id\n";
			$body   .= "message:\n$message";

			$headers = "From: " . plugin()->admin_email() . "\r\n";
			$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

			if ( file_exists( $file_path ) ) {
				$xml = simplexml_load_file( $file_path );
			} else {

				if ( ! file_exists( PATH_CONTENT . plugin()->file_dir . DS ) ) {
					mkdir( PATH_CONTENT . plugin()->file_dir . DS, 0755 );
				}

				$con = '<?xml version="1.0"?><comments></comments>';
				file_put_contents( $file_path, $con );
				$xml = simplexml_load_file( $file_path );
			}

			if ( $parent_id !== null ) {
				$parentComment = $xml->xpath( "//comment[@id='$parent_id']" )[0];
				$response = $parentComment->addChild( 'response' );
				$response->addChild( 'comment_name', $name );
				$response->addChild( 'comment_username', $username );
				$response->addChild( 'comment_datetime', $datetime );
				$response->addAttribute( 'id', md5( uniqid( '', true ) ) );
				$response->addChild( 'comment_email', $email );
				$response->addChild( 'comment_body', strip_tags( html_entity_decode( $message ) ) );
			} else {
				$comment = $xml->addChild( 'comment' );
				$comment->addAttribute( 'id', uniqid() );
				$comment->addChild( 'comment_name', $name );
				$comment->addChild( 'comment_username', $username );
				$comment->addChild( 'comment_datetime', $datetime );
				$comment->addChild( 'comment_email', $email );
				$comment->addChild( 'comment_body',  strip_tags( html_entity_decode( $message ) ) );
			}

			$xml->asXML( $file_path );

			$log_path    = comments_log_path();
			$actual_link = ( empty( $_SERVER['HTTPS'] ) ? 'http' : 'https' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			$log_entry = sprintf(
				'<li>%s <a href="%s" target="_blank" rel="noopener noreferrer">%s</a> <span class="comments-log-date-time"><date>%s</date> | <time>%s</time></span></li>',
				$L->get( 'Comment awaiting moderation on' ),
				$actual_link,
				$page->title(),
				date( 'l, F j, Y' ),
				date( 'h:i:s A' )
			);

			if ( file_exists( $log_path ) ) {
				mail( $to, $subject, $body, $headers );

				file_put_contents(
					$log_path,
					$log_entry
				);

			} else {
				mail( $to, $subject, $body, $headers );

				$secure = "<?php defined( 'BLUDIT' ) or die( 'Not Allowed' ); ?>" . PHP_EOL;
				file_put_contents( $log_path, $secure . $log_entry );
			}

			echo '<div class="alert alert-success" id="comment-alert"><span>' . $L->get( 'commentadded' )  . '</span></div>';
			echo "<meta http-equiv='refresh' content='1'>";

		} else {

			echo '<div class="alert alert-danger" id="comment-alert"><span>' . $L->get( 'wrongcaptcha' ) . '</span></div>';
			echo "<meta http-equiv='refresh' content='1'>";
		}

		unset( $_SESSION['captcha_question'] );
		unset( $_SESSION['captcha_answer'] );

		global $log_path, $id;
	}

	if ( isset( $_POST['deleteComment'] ) ) {

		$xmlFile = $file_path;
		$xml     = simplexml_load_file( $xmlFile );

		$commentIdToDelete =  $_POST['deleteComment'];
		$elementsToDelete  = $xml->xpath( "//comment[@id='$commentIdToDelete']" );

		foreach ( $elementsToDelete as $element ) {
			$dom = dom_import_simplexml( $element );
			$dom->parentNode->removeChild( $dom );
		}

		$responsesToDelete = $xml->xpath( "//response[@id='$commentIdToDelete']" );
		foreach ( $responsesToDelete as $response ) {
			$domResponse = dom_import_simplexml( $response );
			$domResponse->parentNode->removeChild( $domResponse );
		}

		$xml->asXML( $xmlFile );

		echo '<div class="alert alert-success" id="comment-alert"><span>' . $L->get( 'deleted' ) . '</span></div>';
		echo "<meta http-equiv='refresh' content='1'>";
	}

	if ( isset( $_POST['publishComment'] ) ) {

		$xmlFile = $file_path;
		$xml     = simplexml_load_file( $xmlFile );

		$commentIdToPublish = $_POST['publishComment'];

		$elementsToPublish = $xml->xpath( "//comment[@id='$commentIdToPublish']" );
		foreach ( $elementsToPublish as $element ) {
			$element->addChild( 'approved' );
		}

		$responsesToPublish = $xml->xpath( "//response[@id='$commentIdToPublish']" );
		foreach ( $responsesToPublish as $response ) {
			$response->addChild( 'approved' );
		}

		$xml->asXML( $xmlFile );

		echo '<div class="alert alert-success" id="comment-alert"><span>' . $L->get( 'published' ) . '</span></div>';

		echo "<meta http-equiv='refresh' content='1'>";
	}

	if ( 'before' == plugin()->form_location() ) {
		echo comment_form();
	}
	echo comments_loop();
	if ( 'after' == plugin()->form_location() ) {
		echo comment_form();
	}
}
