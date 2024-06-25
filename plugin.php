<?php
/**
 * Post Comments plugin
 *
 * @package  Post Comments
 * @category Plugins
 * @version  1.0.0
 * @since    1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

// Access namespaced functions.
use function Post_Comments\{
	plugin,
	can_manage,
	debug_mode,
	enqueue_assets,
	comments_log_path,
	post_comments,
	disable_comments
};

/**
 * Core plugin class
 *
 * Extends the Bludit class for plugin functionality,
 * options form, and template hooks.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Post_Comments extends Plugin {

	/**
	 * Directory name
	 *
	 * Used for the plugin directory and
	 * for content directories.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $file_dir = 'post-comments';

	/**
	 * Prepare plugin for installation
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function prepare() {
		$this->get_files();
	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Run parent constructor.
		parent :: __construct();

		// Include functionality.
		if ( $this->installed() ) {
			$this->get_files();
		}
	}

	/**
	 * Include functionality
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_files() {

		// Plugin path.
		$path = PATH_PLUGINS . $this->directoryName . DS;

		// Get plugin functions.
		foreach ( glob( $path . 'includes/*.php' ) as $filename ) {
			require_once $filename;
		}
	}

	/**
	 * Initialize plugin
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L The Language class.
	 * @return void
	 */
	public function init() {

		// Access global variables.
		global $L;

		// Plugin options for database.
		$this->dbFields = [
			'user_level'      => 'admin',
			'post_types'      => 'post',
			'logged_form'     => true,
			'logged_comments' => false,
			'form_location'   => 'before',
			'form_heading'    => $L->get( 'Leave a Comment' ),
			'form_heading_el' => 'h2',
			'loop_heading'    => $L->get( 'User Discussion' ),
			'loop_heading_el' => 'h2',
			'admin_email'     => '',
			'terms_page'      => '',
			'accept_terms'    => false,
			'dashboard_log'   => true,
		];

		// Array of custom hooks.
		$this->customHooks = [
			'comments_full',
			'comments_list',
			'comments_form'
		];

		if ( ! $this->installed() ) {
			$Tmp = new dbJSON( $this->filenameDb );
			$this->db = $Tmp->db;
			$this->prepare();
		}
	}

	/**
	 * Install plugin
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  integer $position
	 * @return boolean Return true if the installation is successful.
	 */
	public function install( $position = 1 ) {

		if ( $this->installed() ) {
			return;
		}

		// Create workspace.
		$workspace = $this->workspace();
		mkdir( $workspace, DIR_PERMISSIONS, true );

		// Create plugin directory for the database
		mkdir( PATH_PLUGINS_DATABASES . $this->directoryName, DIR_PERMISSIONS, true );

		$this->dbFields['position'] = $position;

		// Sanitize default values to store in the file.
		foreach ( $this->dbFields as $key => $value ) {

			if ( is_array( $value ) ) {
				$value = $value;
			} else {
				$value = Sanitize :: html( $value );
			}
			settype( $value, gettype( $this->dbFields[$key] ) );
			$this->db[$key] = $value;
		}

		$storage = PATH_CONTENT . $this->file_dir . DS;
		if ( ! file_exists( $storage ) ) {
			Filesystem :: mkdir( $storage, 0755 );
		}
		file_put_contents( $storage . '.htaccess', 'Deny from all' );

		// Create the database.
		return $this->save();
	}

	/**
	 * Load frontend scripts & styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function siteHead() {

		// Maybe get non-minified assets.
		$suffix = '';
		if ( ! debug_mode() ) {
			$suffix = '.min';
		}
		$assets = '';

		if ( enqueue_assets() ) {
			$assets .= '<link rel="stylesheet" type="text/css" href="' . $this->domainPath() . "assets/css/frontend{$suffix}.css?version=" . $this->getMetadata( 'version' ) . '" />' . PHP_EOL;
		}
		return "\n" . $assets;
	}

	/**
	 * Admin page controller
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L The Language class.
	 * @global array $layout
	 * @global object $site The Site class.
	 * @return void
	 */
	public function adminController() {

		// Access global variables.
		global $L, $layout, $site;

		$layout['title'] = $L->get( 'Post Comments Log' ) . ' | ' . $site->title();

		if ( isset( $_POST['delete_log'] ) && file_exists( comments_log_path() ) ) {
			unlink( comments_log_path() );
		};
	}

	/**
	 * Admin settings form
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @global object $plugin Plugin class.
	 * @global object $site Site class.
	 * @return string Returns the markup of the form.
	 */
	public function form() {

		// Access global variables.
		global $L, $plugin, $site;

		$html = '';
		ob_start();
		include( $this->phpPath() . '/views/page-form.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Load backend scripts & styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function adminHead() {

		// Maybe get non-minified assets.
		$suffix = '';
		if ( ! debug_mode() ) {
			$suffix = '.min';
		}

		$assets = '<link rel="stylesheet" type="text/css" href="' . $this->domainPath() . "assets/css/admin{$suffix}.css?version=" . $this->getMetadata( 'version' ) . '" />' . PHP_EOL;

		return "\n" . $assets;
	}

	/**
	 * Admin page(s)
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @global object $security Security class.
	 * @return string Returns page markup.
	 */
	public function adminView() {

		// Access global variables.
		global $L, $security;

		$html = '';
		ob_start();
		if ( isset( $_GET['page'] ) && 'guide' == $_GET['page'] ) {
			include( $this->phpPath() . '/views/page-info.php' );
		} else {
			include( $this->phpPath() . '/views/page-admin.php' );
		}
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Body begin admin hook
	 *
	 * Used to begin user session if not already.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function adminBodyBegin() {
		if ( ! isset( $_SESSION ) ) {
			session_start();
		};
	}

	/**
	 * Admin sidebar hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @return string Returns link markup.
	 */
	public function adminSidebar() {

		// Access global variables.
		global $L;

		$slug = strtolower( __CLASS__ );
		$url  = HTML_PATH_ADMIN_ROOT . 'plugin/' . $slug;

		$html = sprintf(
			'<a class="nav-link" href="%s"><span class="fa fa-comments"></span>%s</a>',
			$url,
			$L->get( 'Comments' )
		);
		return $html;
	}

	/**
	 * Dashboard admin hook
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @global object $security Security class.
	 * @return string Returns the log widget markup.
	 */
	public function dashboard() {

		// Access global variables.
		global $L, $security;

		if ( $this->dashboard_log() && ! can_manage() ) {
			return false;
		} elseif ( ! $this->dashboard_log() ) {
			return false;
		}

		$html = '';
		ob_start();
		include( $this->phpPath() . '/views/dashboard-log.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Full comments theme hook
	 *
	 * Prints the comments list and the form
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $L Language class.
	 * @global object $page The Page class.
	 * @global object $url The Url class.
	 * @return mixed
	 */
	public function comments_full() {

		// Access global variables.
		global $L, $page, $url;

		if ( 'page' !== $url->whereAmI() ) {
			return false;
		}

		if ( disable_comments() ) {
			printf(
				'<p class="comments-closed-notice">%s</p>',
				$L->get( 'Comments are closed.' )
			);
			return false;
		}

		if ( $page->isStatic() && ( 'page' == $this->post_types() || 'both' == $this->post_types() ) ) {
			return post_comments();
		} elseif ( ! $page->isStatic() && 'page' !== $this->post_types() ) {
			return post_comments();
		}
		return false;
	}

	// @return string
	public function user_level() {
		return $this->getValue( 'user_level' );
	}

	// @return string
	public function post_types() {
		return $this->getValue( 'post_types' );
	}

	// @return boolean
	public function logged_form() {
		return $this->getValue( 'logged_form' );
	}

	// @return boolean
	public function logged_comments() {
		return $this->getValue( 'logged_comments' );
	}

	// @return string
	public function form_location() {
		return $this->getValue( 'form_location' );
	}

	// @return string
	public function form_heading() {
		return $this->getValue( 'form_heading' );
	}

	// @return string
	public function form_heading_el() {
		return $this->getValue( 'form_heading_el' );
	}

	// @return string
	public function loop_heading() {
		return $this->getValue( 'loop_heading' );
	}

	// @return string
	public function loop_heading_el() {
		return $this->getValue( 'loop_heading_el' );
	}

	// @return string
	public function admin_email() {
		return $this->getValue( 'admin_email' );
	}

	// @return boolean
	public function accept_terms() {
		return $this->getValue( 'accept_terms' );
	}

	// @return string
	public function terms_page() {
		return $this->getValue( 'terms_page' );
	}

	// @return boolean
	public function dashboard_log() {
		return $this->getValue( 'dashboard_log' );
	}
}
