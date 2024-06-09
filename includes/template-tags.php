<?php
/**
 * Template tags
 *
 * @package    Post Comments
 * @subpackage Includes
 * @since      1.0.0
 */

namespace Post_Comments;

/**
 * Get SVG icon
 *
 * @since  1.0.0
 * @param  string $$file Name of the SVG file.
 * @return array
 */
function icon( $filename = '', $wrap = false, $class = '' ) {

	$exists = file_exists( sprintf(
		plugin()->phpPath() . DS . 'assets/images/svg-icons/%s.svg',
		$filename
	) );
	if ( ! empty( $filename ) && $exists ) {

		if ( true == $wrap ) {
			return sprintf(
				'<span class="svg-icon %s">%s</span>',
				$class,
				file_get_contents( plugin()->phpPath() . DS . "assets/images/svg-icons/{$filename}.svg" )
			);
		} else {
			return file_get_contents( plugin()->phpPath() . DS . "assets/images/svg-icons/{$filename}.svg" );
		}
	}
	return '';
}

/**
 * Comments loop heading
 *
 * Returns the heading heading markup.
 *
 * @since  1.0.0
 * @global object $L The Language class.
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return mixed
 */
function loop_heading() {

	// Access global variables.
	global $L, $page, $url;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$file  = comments_file_path();
	$text  = plugin()->loop_heading();
	$tag   = plugin()->loop_heading_el();
	$title = $page->title();
	$count = comment_reply_count();

	if ( empty( $text ) ) {
		return false;
	}

	$maybe_s = $L->get( 's' );
	if ( 1 == $count ) {
		$maybe_s = '';
	}

	$text = str_replace( '{{count}}', $count, $text );
	$text = str_replace( '{{maybe-s}}', $maybe_s, $text );
	$text = str_replace( '{{post-name}}', $title, $text );

	return sprintf(
		'<%s>%s</%s>',
		$tag,
		$text,
		$tag
	);
}

/**
 * Comment form heading
 *
 * Returns the heading heading markup.
 *
 * @since  1.0.0
 * @global object $L The Language class.
 * @global object $page The Page class.
 * @global object $url The Url class.
 * @return mixed
 */
function form_heading() {

	// Access global variables.
	global $L, $page, $url;

	// Stop if not on a post.
	if ( 'page' !== $url->whereAmI() ) {
		return false;
	}

	$text  = plugin()->form_heading();
	$tag   = plugin()->form_heading_el();
	$title = $page->title();

	if ( empty( $text ) ) {
		return false;
	}

	$text = str_replace( '{{post-name}}', $title, $text );
	return sprintf(
		'<%s>%s</%s>',
		$tag,
		$text,
		$tag
	);
}

/**
 * Comments log
 *
 * Returns the log list or a log empty message.
 *
 * @since  1.0.0
 * @global object $L The Language class.
 * @return string
 */
function comments_log() {

	// Access global variables.
	global $L;

	$log  = comments_log_path();
	$lead = "<?php defined( 'BLUDIT' ) or die( 'Not Allowed' ); ?>" . PHP_EOL;

	if ( @file_get_contents( $log ) && @file_get_contents( $log ) === $lead ) {
		unlink( comments_log_path() );
	}

	if ( @file_get_contents( $log ) ) {
		$html = sprintf(
			'<ol id="comments-log-list" style="list-style: none;">%s</ol>',
			file_get_contents( $log )
		);
	} else {
		$html = sprintf(
			'<p id="comments-log-empty">%s</p>',
			$L->get( 'No comments in log.' )
		);
	}
	return $html;
}

/**
 * First name
 *
 * @since  1.0.0
 * @param  string $name
 * @return mixed
 */
function user_first_name( $name = '' ) {
	$user = user( $name );
	if ( $user->firstName() ) {
		return $user->firstName();
	}
	return false;
}

/**
 * Last name
 *
 * @since  1.0.0
 * @param  string $name
 * @return mixed
 */
function user_last_name( $name = '' ) {
	$user = user( $name );
	if ( $user->lastName() ) {
		return $user->lastName();
	}
	return false;
}

/**
 * Full name
 *
 * @since  1.0.0
 * @param  string $name
 * @return mixed
 */
function user_full_name( $name = '' ) {
	$user = user( $name );
	if ( $user->firstName() && $user->lastName() ) {
		return $user->firstName() . ' ' . $user->lastName();
	}
	return false;
}

/**
 * Nickname
 *
 * @since  1.0.0
 * @param  string $name
 * @return mixed
 */
function user_nickname( $name = '' ) {
	$user = user( $name );
	if ( $user->nickname() ) {
		return $user->nickname();
	}
	return false;
}

/**
 * Display name
 *
 * @since  1.0.0
 * @param  string $name
 * @return string
 */
function user_display_name( $name = '' ) {

	$user = user( $name );

	if ( user_nickname( $name ) ) {
		return  user_nickname( $name );
	} elseif ( user_full_name( $name ) ) {
		return user_full_name( $name );
	} elseif ( user_first_name( $name ) ) {
		return user_first_name( $name );
	} else {
		return ucwords(
			str_replace(
				[ '-', '_', '.' ],
				' ',
				$user->username()
			)
		);
	}
}

/**
 * User avatar
 *
 * @since  1.0.0
 * @param  string $name Username
 * @return string Returns the user-uploaded avatar URL or
 *                the default avatar URL.
 */
function user_avatar( $name = '' ) {

	$src = '';
	if ( \Sanitize :: pathFile( PATH_UPLOADS_PROFILES . $name . '.png' ) ) {
		$src = DOMAIN_UPLOADS_PROFILES . $name . '.png?version=' . time();
	} else {
		$src = default_avatar();
	}
	return $src;
}
