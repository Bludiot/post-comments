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

class Post_Comments extends Plugin {

	/**
	 * Is in the back end
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    boolean
	 */
	private $backend = false;

	/**
	 * Backend view/file
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    mixed
	 */
	private $backend_view = null;

	/**
	 * Backend request type
	 *
	 * `post`, `get`, `ajax`
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    mixed
	 */
	private $backend_request = null;

	/**
	 * Prepare plugin for installation
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function prepare() {
		require_once 'includes/functions.php';
	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $comments_plugin Instance of this class.
	 * @return self
	 */
	public function __construct() {

		// Define global variable for this class.
		global $comments_plugin;
		$comments_plugin = $this;

		// Run the parent constructor.
		parent :: __construct();
	}

	/**
	 * Selected helper method
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $field The respective option key (used in `getValue()`).
	 * @param  boolean $value The value to compare with.
	 * @param  boolean $print True to print `selected="selected"`.
	 *                       False to return the string.
	 *                       Use `null` to return as boolean.
	 * @return mixed
	 */
	public function selected( $field = '', $value = true, $print = true ) {

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

	/**
	 * Checked helper method
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $field The respective option key (used in `getValue()`).
	 * @param  boolean $value The value to compare with.
	 * @param  boolean $print True to print `checked="checked"`.
	 *                        False to return the string.
	 *                        Use `null` to return as boolean.
	 * @return mixed
	 */
	public function checked( $field = '', $value = true, $print = true ) {

		if ( sn_config( $field ) == $value ) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}
		if ( null === $print ) {
			return ! empty( $checked );
		}
		if ( ! $print ) {
			return $checked;
		}
		print( $checked );
	}

	/**
	 * Get database value
	 *
	 * Supersedes parent method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  mixed $field
	 * @param  boolean $html
	 * @return void
	 */
	public function getValue( $field, $html = true ) {

		if ( isset( $this->db[$field] ) ) {
			$data = strpos( $field, 'string_' ) === 0 ? sn__( $this->db[$field] ) : $this->db[$field];

			return ( $html ) ? $data : Sanitize :: htmlDecode( $data );
		}
		return isset( $this->dbFields[$field] ) ? $this->dbFields[$field] : null;
	}

	/**
	 * Initialize plugin
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $url The Url class.
	 * @return void
	 */
	public function init() {

		// Access global variables.
		global $url;

		// Get system functions.
		require_once 'includes/functions.php';

		// Plugin options for database.
		$this->dbFields = [
			'moderation'              => true,
			'moderation_loggedin'     => true,
			'moderation_approved'     => true,
			'comment_on_public'       => true,
			'comment_on_static'       => false,
			'comment_on_sticky'       => true,
			'comment_title'           => 'disabled',
			'comment_limit'           => 0,
			'comment_depth'           => 3,
			'comment_markup_html'     => true,
			'comment_markup_markdown' => false,
			'comment_vote_storage'    => 'session',
			'comment_enable_like'     => true,
			'comment_enable_dislike'  => true,
			'frontend_captcha'        => function_exists( 'imagettfbbox' ) ? 'gregwar' : 'purecaptcha',
			'frontend_recaptcha_public'  => '',
			'frontend_recaptcha_private' => '',
			'frontend_terms'        => 'default',
			'frontend_filter'       => 'pageEnd',
			'frontend_template'     => 'default',
			'frontend_order'        => 'date_desc',
			'frontend_form'         => 'top',
			'frontend_per_page'     => 15,
			'frontend_ajax'         => true,
			'frontend_avatar'       => 'mystery',
			'subscription'          => false,
			'subscription_from'     => "ticker@{$_SERVER['SERVER_NAME']}",
			'subscription_reply'    => "noreply@{$_SERVER['SERVER_NAME']}",
			'subscription_optin'    => 'default',
			'subscription_ticker'   => 'default',

			// Frontend messages, can be changed by the user.
			'string_success_1' => sn__( 'Thank you for your comment.' ),
			'string_success_2' => sn__( 'Thank you for your comment. Please confirm your subscription via the link we sent to your email address.' ),
			'string_success_3' => sn__( 'Thank you for voting this comment.' ),
			'string_error_1'   => sn__( 'An unknown error occurred. Please reload the page and try it again.' ),
			'string_error_2'   => sn__( 'An error occurred: The passed username is invalid or too long (42 characters only).' ),
			'string_error_3'   => sn__( 'An error occurred: The passed email address is invalid.' ),
			'string_error_4'   => sn__( 'An error occurred: The comment text is missing.' ),
			'string_error_5'   => sn__( 'An error occurred: The comment title is missing.' ),
			'string_error_6'   => sn__( 'An error occurred: You need to accept the terms to comment.' ),
			'string_error_7'   => sn__( 'An error occurred: Your IP address or email address has been marked as spam.' ),
			'string_error_8'   => sn__( 'An error occurred: You already rated this comment.' ),
			'string_terms_of_use' => sn__( 'I agree that my data (including my anonymized IP address) gets stored.' )
		];

		// Array of custom hooks.
		$this->customHooks = [
			'comments_full',
			'comments_list',
			'comments_form'
		];

		// Check admin URI filter.
		$this->backend = ( trim( $url->activeFilter(), '/' ) == ADMIN_URI_FILTER );
	}

	/**
	 * Plugin installed
	 *
	 * Supersedes parent method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $comments_core  The Comments_Core class.
	 * @global object $comments_index The Comments_Index class.
	 * @global object $comments_users The Comments_Users class.
	 * @global object $comments_votes The Comments_Votes class.
	 * @return void
	 */
	public function installed() {

		// Access global variables.
		global $comments_core, $comments_index, $comments_users, $comments_votes;

		if ( file_exists( $this->filenameDb ) ) {
			if ( ! defined( 'POST_COMMENTS' ) ) {
				define( 'POST_COMMENTS', true );
				define( 'PC_PATH', PATH_PLUGINS . basename( __DIR__ ) . DS );
				define( 'PC_DOMAIN', DOMAIN_PLUGINS . basename( __DIR__ ) . '/' );
				define( 'PC_VERSION', '1.0.0' );

				// DataBases
				define( 'PC_DB_COMMENTS', $this->workspace() . 'pages' . DS );
				define( 'PC_DB_INDEX', $this->workspace() . 'comments-index.php' );
				define( 'PC_DB_USERS', $this->workspace() . 'comments-users.php' );
				define( 'PC_DB_VOTES', $this->workspace() . 'comments-votes.php' );

				// Pages Filter
				if ( ! file_exists( PC_DB_COMMENTS ) ) {
					@mkdir( PC_DB_COMMENTS );
				}

				// Plugin path.
				$path = PATH_PLUGINS . $this->directoryName . DS;

				foreach ( glob( $path . 'system/*.php' ) as $filename ) {
					require_once $filename;
				}
				require_once 'includes/autoload.php';
			} else {
				$comments_core  = new Comments_Core();
				$comments_index = new Comments_Index();
				$comments_users = new Comments_Users();
				$comments_votes = new Comments_Votes();
				$this->request();
			}
			return true;
		}
		return false;
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
		include( $this->phpPath() . '/views/admin/page-form.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Form submission response
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $data The response data. Must contain at least status.
	 *                     `error` The error message.
	 *                     `success` The success message.
	 *                     `referer` A referer URL (The current URL is used
	 *                          if not present). non-AJAX only.
	 *                     Any additional data, which should return
	 *                     to the client. AJAX only.
	 * @param  mixed $key
	 * @global object $url The Url class.
	 * @return void This method calls the `die()` method at any time.
	 */
	public function response( $data = [], $key = null ) {

		// Access global variables.
		global $url;

		// Validate
		if ( isset( $data['success'] ) || isset( $data['error'] ) ) {
			$status = isset( $data['success'] );
		} else {
			$status = false;
			$data['error'] = sn__( 'An unknown error occurred.' );
		}

		// POST redirect.
		if ( $this->backend_request !== 'ajax' ) {
			if ( $status ) {
				$key = empty( $key ) ? 'comments-success' : $key;
				Alert :: set( $data['success'], ALERT_STATUS_OK, $key );
			} else {
				$key = empty( $key ) ? 'comments-alert' : $key;
				Alert :: set( $data['error'], ALERT_STATUS_FAIL, $key );
			}

			if ( ! empty( $data['referer'] ) ) {
				Redirect :: url( $data['referer'] );
			} else {
				$action = isset( $_GET['comments'] ) ? $_GET['comments'] : $_POST['comments'];
				Redirect :: url( HTML_PATH_ADMIN_ROOT . $url->slug() . "#{$action}" );
			}
			die();
		}

		// AJAX print.
		if ( ! is_array( $data ) ) {
			$data = [];
		}
		$data['status'] = ( $status ) ? 'success' : 'error';
		$data = json_encode( $data );

		header( 'Content-Type: application/json' );
		header( 'Content-Length: ' . strlen( $data ) );
		print ( $data );
		die();
	}

	/**
	 * Form submission request
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $comments_core The Comments_Core class.
	 * @global object $login The Login class.
	 * @global object $security The Security class.
	 * @global object $url The Url class.
	 * @return mixed
	 */
	public function request() {

		// Access global variables.
		global $comments_core, $login, $security, $url;

		// POST/GET request.
		if ( isset( $_POST['action'] ) && $_POST['action'] === 'comments' ) {
			$data = $_POST;
			$this->backend_request = 'post';
		} elseif ( isset( $_GET['action'] ) && $_GET['action'] === 'comments' ) {
			$data = $_GET;
			$this->backend_request = 'get';
		}
		if ( ! ( isset( $data ) && isset( $data['comments'] ) ) ) {
			$this->backend_request = null;
			return null;
		}

		// AJAX request.
		$ajax = 'HTTP_X_REQUESTED_WITH';
		if ( strpos( $url->slug(), 'comments/ajax' ) === 0 ) {
			if ( isset( $_SERVER[$ajax] ) && $_SERVER[$ajax] === 'XMLHttpRequest' ) {
				$this->backend_request = 'ajax';
			} else {
				return Redirect :: url( HTML_PATH_ADMIN_ROOT . 'comments/' );
			}
		} elseif ( isset( $_SERVER[$ajax] ) && $_SERVER[$ajax] === 'XMLHttpRequest' ) {
			print ( 'Invalid AJAX call' );
			die();
		}
		if ( $this->backend_request === 'ajax' && ! sn_config( 'frontend_template' ) ) {
			print ( 'AJAX calls have been disabled' );
			die();
		}

		// Start session.
		if ( ! Session :: started() ) {
			Session :: start( '', true );
		}

		$key    = null;
		$action = [
			'add',
			'edit',
			'delete',
			'config',
			'users',
			'backup',
			'moderate'
		];
		if ( in_array( $data['comments'], $action ) ) {
			$key = 'alert';
		}

		// Check CSRF token.
		if ( ! empty( $key ) ) {
			if ( ! isset( $data['tokenCSRF'] ) ) {
				return $this->response( [
					'error' => sn__( 'The CSRF token is missing' )
				] );
			}
			if ( ! $security->validateTokenCSRF( $data['tokenCSRF'] ) ) {
				return $this->response( [
					'error' => sn__( 'The CSRF token is invalid' )
				] );
			}
		}

		// Check permissions.
		if ( ! empty( $key ) ) {
			if ( ! is_a( $login, 'Login' ) ) {
				$login = new Login();
			}
			if ( ! $login->isLogged() ) {
				return $this->response( [
					'error' => sn__( 'You don\'t have the permission to call this action' )
				] );
			}
			if ( $login->role() !== 'admin' ) {
				return $this->response( [
					'error' => sn__( 'You don\'t have the permission to perform this action' )
				] );
			}
		}

		// Route.
		switch ( $data['comments'] ) {
			case 'comment': // @fallthrough
			case 'reply': // @fallthrough
			case 'add':
				return $comments_core->writeComment( $data['comment'], $key );
			/* case 'update': */ // @todo User can edit his own comments.
			case 'edit':
				return $comments_core->editComment( $data['uid'], $data['comment'], $key );
			/* case 'remove': */ // @todo User can delete his own comments.
			case 'delete':
				return $comments_core->deleteComment( $data['uid'], $key );
			case 'moderate':
				return $comments_core->moderateComment( $data['uid'], $data['status'], $key );
			case 'list': // @fallthrough
			case 'get':
				return $comments_core->renderComment( $data );
			case 'rate':
				return $comments_core->rateComment( $data['uid'], $data['type'] );
			case 'users':
				return $this->user( $data );
			case 'settings':
				return $this->config( $data );
			case 'backup':
				return $this->backup();
			case 'captcha':
				return $this->response( [
					'success' => sn__( 'The Captcha image was successfully created' ),
					'captcha' => $comments_core->generateCaptcha( 150, 40, true )
				] );
		}
		return $this->response( [
			'error' => sn__( 'The passed action is unknown or invalid' )
		], 'alert' );
	}

	/**
	 * Handle users
	 *
	 * @since  1.0.0
	 * @access private
	 * @param  array $data
	 * @global object $comments_index The Comments_Index class.
	 * @global object $comments_users The Comments_Users class.
	 * @return void
	 */
	private function user( $data ) {

		// Access global variables.
		global $comments_index, $comments_users;

		// Validate data.
		if ( ! isset( $data['uuid'] ) || ! isset( $data['handle'] ) ) {
			return $this->response( [
				'error' => sn__( 'An unknown error is occurred' )
			], 'alert' );
		}

		// Validate UUID.
		if ( ! $comments_users->exists( $data['uuid'] ) ) {
			return $this->response( [
				'error' => sn__( 'An unique user ID does not exist' )
			], 'alert' );
		}

		// Handle.
		if ( $data['handle'] === 'delete' ) {
			$comments = $comments_users->db[$data['uuid']]['comments'];

			foreach ( $comments as $uid ) {
				if ( ! $comments_index->exists( $uid ) ) {
					continue;
				}
				$index   = $comments_index->getComment( $uid );
				$comment = new Comments( $index['page_uuid'] );

				if ( isset( $data['anonymize'] ) && $data['anonymize'] === 'true' ) {
					$comment = new Comments( $index['page_uuid'] );
					$comment->edit( $uid, [ 'author' => 'anonymous' ] );
				} else {
					$comment = new Comments( $index['page_uuid'] );
					$comment->delete( $uid );
				}
			}
			$status = $comments_users->delete( $data['uuid'] );
		} elseif ( $data['handle'] === 'block' ) {
			$status = $comments_users->edit( $data['uuid'], null, null, true );
		} elseif ( $data['handle'] === 'unblock' ) {
			$status = $comments_users->edit( $data['uuid'], null, null, false );
		}

		// Redirect.
		if ( ! isset( $status ) ) {
			return $this->response( [
				'error' => sn__( 'The passed action is unknown or invalid' )
			], 'alert' );
		}
		if ( $status === false ) {
			return $this->response( [
				'error' => sn__( 'An unknown error is occurred' )
			], 'alert' );
		}
		return $this->response( [
			'success' => sn__( 'The action has been performed successfully' )
		], 'alert' );
	}

	/**
	 * Handle plugin settings
	 *
	 * @since  1.0.0
	 * @access private
	 * @param  array $data Data to be configured.
	 * @global object $comments_core The Comments_Core class.
	 * @global object $pages The Pages class.
	 * @return void
	 */
	private function config( $data ) {

		// Access global variables.
		global $comments_core, $pages;

		// Validations.
		$config = [];
		$text = [
			'frontend_recaptcha_public',
			'frontend_recaptcha_private'
		];
		$numbers = [
			'comment_limit',
			'comment_depth',
			'frontend_per_page'
		];
		$selects = [
			'comment_title' => [
				'optional',
				'required',
				'disabled'
			],
			'comment_vote_storage' => [
				'cookie',
				'session',
				'database'
			],
			'frontend_captcha' => [
				'disabled',
				'purecaptcha',
				'gregwar',
				'recaptchav2',
				'recaptchav3'
			],
			'frontend_avatar' => [
				'mystery',
				'initials'
			],
			'frontend_filter' => [
				'disabled',
				'comments_full',
				'pageBegin',
				'pageEnd',
				'siteBodyBegin',
				'siteBodyEnd'
			],
			'frontend_order' => [
				'date_desc',
				'date_asc'
			],
			'frontend_form' => [
				'top',
				'bottom'
				]
		];
		$emails = [
			'subscription_from',
			'subscription_reply'
		];
		$pageid = [
			'frontend_terms',
			'subscription_optin',
			'subscription_ticker'
		];

		// Loop database fields.
		foreach ( $this->dbFields as $field => $value ) {

			if ( ! isset( $data[$field] ) ) {
				$config[$field] = is_bool( $value ) ? false : '';
				continue;
			}

			// Sanitize booleans.
			if ( is_bool( $value ) ) {
				$config[$field] = ( 'true' === $data[$field] || true === $data[$field] );
				continue;
			}

			// Sanitize numbers.
			if ( in_array( $field, $numbers ) ) {
				if ( $data[$field] < 0 || ! is_numeric( $data[$field] ) ) {
					$config[$field] = 0;
				}
				$config[$field] = (int) $data[$field];
				continue;
			}

			// Sanitize selection.
			if ( array_key_exists( $field, $selects ) ) {
				if ( in_array( $data[$field], $selects[$field] ) ) {
					$config[$field] = $data[$field];
				} else {
					$config[$field] = $value;
				}
				continue;
			}

			// Sanitize emails.
			if ( in_array( $field, $emails ) ) {
				if ( Valid :: email( $data[$field] ) ) {
					$config[$field] = Sanitize :: email( $data[$field] );
				} else {
					$config[$field] = $value;
				}
				continue;
			}

			// Sanitize pages.
			if ( in_array( $field, $pageid ) ) {
				$default = in_array( $data[$field], [ 'default', 'disabled' ] );
				if ( $default || $pages->exists( $data[$field] ) ) {
					$config[$field] = $data[$field];
				} else {
					$config[$field] = $value;
				}
				continue;
			}

			// Sanitize template.
			if ( $field == 'frontend_template' ) {
				if ( $comments_core->hasTheme( $data[$field] ) ) {
					$config[$field] = $data[$field];
				} else {
					$config[$field] = $value;
				}
				continue;
			}

			// Sanitize strings.
			if ( strpos( $field, 'string_' ) === 0 || in_array( $field, $text ) ) {
				$config[$field] = Sanitize :: html( strip_tags( $data[$field] ) );
				if ( empty( $config[$field] ) ) {
					$config[$field] = $value;
				}
				continue;
			}
		}

		// Save & return.
		$this->db = array_merge( $this->db, $config );
		if ( ! $this->save() ) {
			return $this->response(
				array( 'error' => sn__( 'An unknown error is occurred.' ) ),
				'alert'
			);
		}
		return $this->response(
			['success' => sn__( 'The settings has been updated successfully.' ) ],
			'alert'
		);
	}

	/**
	 * Create a backup
	 *
	 * When deactivating the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function backup() {

		$filename = 'comments-backup-' . time() . '.zip';

		// Create backup.
		$zip = new PIT\Zip();
		$zip->addFolder( $this->workspace(), '/', true, true );
		$zip->save( PATH_TMP . $filename );

		// Return.
		return $this->response(
			[
				'success' => sn__( 'The backup has been created successfully.' ),
				'referer' => DOMAIN_ADMIN . 'uninstall-plugin/Post_Comments'
			],
			'alert'
		);
	}

	/**
	 * Before admin load
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $url The Url class.
	 * @return void
	 */
	public function beforeAdminLoad() {

		// Access global variables.
		global $url;

		// Check if the current View is the "comments"
		if (strpos($url->slug(), "comments") !== 0) {
			return false;
		}
		checkRole(array("admin"));

		// Set Backend View
		$split = str_replace("comments", "", trim($url->slug(), "/"));
		if (!empty($split) && $split !== "/" && isset($_GET["uid"])) {
			$this->backend_view = "edit";
		} else {
			$this->backend_view = "index";
		}
	}

	/**
	 * Admin head
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $page The Page class.
	 * @global object $security The Security class.
	 * @global object $url The Url class.
	 * @return void
	 */
	public function adminHead() {

		// Access global variables.
		global $page, $security, $url;

		$js   = PC_DOMAIN . 'assets/js/';
		$css  = PC_DOMAIN . 'assets/css/';
		$slug = explode( '/', str_replace( HTML_PATH_ADMIN_ROOT, '', $url->uri() ) );

		// Maybe get non-minified assets.
		$suffix = '.min';
		if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
			$suffix = '';
		}

		// Admin Header
		ob_start();
		if ( 'new-content' === $slug[0] || 'edit-content' === $slug[0] ) {

		?>
		<script type="text/javascript">
			(function () {
				'use strict';
				var w = window, d = window.document;

				// Render Field
				var HANDLE_COMMENTS_FIELD = '<?php echo Bootstrap :: formSelectBlock( [
					'name'     => 'allowComments',
					'label'    => sn__( 'Page Comments' ),
					'selected' => ( ! $page) ? '1' : ( $page->allowComments() ? '1' : '0' ),
					'class'    => '',
					'options'  => [
						'1' => sn__( 'Allow Comments' ),
						'0' => sn__( 'Disallow Comments' )
					]
				] ); ?>';

				// Ready ?
				d.addEventListener("DOMContentLoaded", function () {
					if (d.querySelector("#jscategory")) {
						var form = d.querySelector("#jscategory").parentElement;
						form.insertAdjacentHTML("afterend", HANDLE_COMMENTS_FIELD);
					}
				});
			}());
		</script>
		<?php

		} elseif ( 'comments' === $slug[0] ) {

		?>
		<script type="text/javascript" src="<?php echo $js; ?>admin.comments<?php echo $suffix; ?>.js"></script>
		<link type="text/css" rel="stylesheet" href="<?php echo $css; ?>admin.comments.css" />
		<?php

		} elseif ( 'plugins' === $slug[0] ) {

			$link = DOMAIN_ADMIN . 'comments?action=comments&comments=backup&tokenCSRF=' . $security->getTokenCSRF();
		?>
		<script type="text/javascript">
			document.addEventListener("DOMContentLoaded", function () {
				var link = document.querySelector("tr#Post_Comments td a[href='/bludit/admin/uninstall-plugin/Post_Comments']");
				if (link) {
					link.addEventListener("click", function (event) {
						event.preventDefault();
						jQuery("#dialog-deactivate-comments").modal();
					});
					jQuery("#dialog-deactivate-comments button[data-comments='backup']").click(function () {
						console.log("owo");
						window.location.replace("<?php echo $link; ?>&referer=" + link.href);
					});
					jQuery("#dialog-deactivate-comments button[data-comments='deactivate']").click(function () {
						window.location.replace(link.href);
					});
				}
			})
		</script>
		<?php
		}
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/**
	 * Admin body begin
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed
	 */
	public function adminBodyBegin() {
		if ( ! $this->backend || ! $this->backend_view ) {
			return false;
		}
		ob_start();
	}

	/**
	 * Admin body end
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $comments_plugin This class.
	 * @global object $url The Url class.
	 * @return boolean Returns false after printing markup.
 	 */
	public function adminBodyEnd() {

		// Access global variables.
		global $comments_plugin, $url;

		if ( ! $this->backend || ! $this->backend_view ) {
			$slug = explode( '/', str_replace( HTML_PATH_ADMIN_ROOT, '', $url->uri() ) );
			if ( $slug[0] === 'plugins' ) {
				?>
				<div id="dialog-deactivate-comments" class="modal fade" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php sn_e( 'Post Comments Deactivation' ); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="<?php sn_e( 'Close' ); ?>">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>
									<?php sn_e( 'You are about to deactivate the Post Comments plugin, which will delete all written comments. Do you want to backup your comments before deactivation?' ); ?>
								</p>
								<p>
									<?php sn_e( 'The Backup will be stored in %s', [ '<code>./bl-content/tmp/</code>' ] ); ?>
								</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-comments="backup"><?php sn_e( 'Yes, create a Backup' ); ?></button>
								<button type="button" class="btn btn-danger" data-comments="deactivate"><?php sn_e( 'No, just Deactivate' ); ?></button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php sn_e( 'Cancel' ); ?></button>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			return false;
		}

		// Fetch content.
		$content = ob_get_contents();
		ob_end_clean();

		// Admin content.
		ob_start();
		if ( file_exists( PC_PATH . 'views/admin' . DS . "{$this->backend_view}.php" ) ) {
			require PC_PATH . 'views/admin' . DS . "{$this->backend_view}.php";
			$add = ob_get_contents();
		}
		ob_end_clean();

		// Inject code.
		if ( isset( $add ) && ! empty( $add ) ) {
			$regexp = "#(\<div class=\"col-lg-10 pt-3 pb-1 h-100\"\>)(.*?)(\<\/div\>)#s";
			$content = preg_replace( $regexp, "$1{$add}$3", $content );
		}
		print ($content);
	}

	/**
	 * Admin info pages
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the markup of the page.
	 */
	public function adminView() {

		$html  = '';
		ob_start();
		include( $this->phpPath() . '/views/admin/page-guide.php' );
		$html .= ob_get_clean();

		return $html;
	}

	/**
	 * Admin sidebar
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object $comments_index The Comments_Index class.
	 * @return void
	 */
	public function adminSidebar() {

		// Access global variables.
		global $comments_index;

		$count = $comments_index->count( 'pending' );
		$count = ( $count > 99 ) ? '99+' : $count;

		ob_start();
		?>
		<a href="<?php echo HTML_PATH_ADMIN_ROOT; ?>comments" class="nav-link" style="white-space: nowrap;">
			<span class="fa fa-comments"></span> <?php sn_e( 'Comments' ); ?>
			<?php if ( ! empty( $count ) ) { ?>
				<span class="badge badge-success badge-pill"><?php echo $count; ?></span>
			<?php } ?>
		</a>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/**
	 * Before site load
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object The Comments class.
	 * @global object The Page class.
	 * @global object $url The Url class.
	 * @return void
	 */
	public function beforeSiteLoad() {

		// Access global variables.
		global $comments, $page, $url;

		// Start session.
		if ( ! Session :: started() ) {
			Session :: start( '', true );
		}

		// Initiate comments.
		if ( is_a( $page, 'Page' ) && $page->published() && ! empty( $page->uuid() ) ) {
			$comments = new Comments( $page->uuid() );
		} else {
			$comments = false;
		}
	}

	/**
	 * Site head
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object The Comments_Core class.
	 * @return void
	 */
	public function siteHead() {

		// Access global variables.
		global $comments_core;

		if ( ( $theme = $comments_core->getTheme() ) === false ) {
			return false;
		}
		if ( ! empty( $theme->theme_js ) ) {
			$file = PC_DOMAIN . 'themes/' . sn_config( 'frontend_template' ) . '/' . $theme->theme_js;
			?>
			<script type="text/javascript">
				var COMMENTS_AJAX = <?php echo sn_config( 'frontend_ajax' ) ? 'true' : 'false'; ?>;
				var PC_PATH = "<?php echo HTML_PATH_ADMIN_ROOT ?>comments/ajax/";
			</script>
			<script id="comments-js" type="text/javascript" src="<?php echo $file; ?>"></script>
			<script src="https://www.google.com/recaptcha/api.js" async defer></script>
			<?php
		}

		if ( ! empty( $theme->theme_css ) ) {
			$file = PC_DOMAIN . 'themes/' . sn_config( 'frontend_template' ) . '/' . $theme->theme_css;
			?>
			<link id="comments-css" type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
			<?php
		}
	}

	/**
	 * Add comments to theme hook `comments_full`
	 *
	 * This hook is established by this plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object The Comments_Core class.
	 * @return void
	 */
	public function comments_full() {

		// Access global variables.
		global $comments_core;

		if ( sn_config( 'frontend_filter' ) !== 'comments_full' ) {
			return false;
		}
		print( $comments_core->render() );
	}

	/**
	 * Add comments to theme hook `siteBodyBegin`
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object The Comments_Core class.
	 * @return void
	 */
	public function siteBodyBegin() {

		// Access global variables.
		global $comments_core;

		if ( sn_config( 'frontend_filter' ) !== 'siteBodyBegin' ) {
			return false;
		}
		print( $comments_core->render() );
	}

	/**
	 * Add comments to theme hook `pageBegin`
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object The Comments_Core class.
	 * @return void
	 */
	public function pageBegin() {

		// Access global variables.
		global $comments_core;

		if ( sn_config( 'frontend_filter' ) !== 'pageBegin' ) {
			return false;
		}
		print( $comments_core->render() );
	}

	/**
	 * Add comments to theme hook `pageEnd`
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object The Comments_Core class.
	 * @return void
	 */
	public function pageEnd() {

		// Access global variables.
		global $comments_core;

		if ( sn_config( 'frontend_filter' ) !== 'pageEnd' ) {
			return false;
		}
		print( $comments_core->render() );
	}

	/**
	 * Add comments to theme hook `siteBodyEnd`
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object The Comments_Core class.
	 * @return void
	 */
	public function siteBodyEnd() {

		// Access global variables.
		global $comments_core;

		if ( sn_config( 'frontend_filter' ) !== 'siteBodyEnd' ) {
			return false;
		}
		print( $comments_core->render() );
	}
}
