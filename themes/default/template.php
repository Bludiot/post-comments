<?php
/**
 * Default comments template
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

class Default_Template extends Comments_Template {

	/**
	 * Theme name
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $theme_name = 'Default Theme';

	/**
	 * Theme CSS file
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $theme_css = 'styles.min.css';

	/**
	 * Theme JS file
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $theme_js = 'comments.min.js';

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Maybe get non-minified assets.
		if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
			$this->theme_css = 'styles.css';
			$this->theme_js  = 'comments.js';
		}
	}

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
	public function form( $username = '', $email = '', $title = '', $message = '' ) {

		// Access global variables.
		global $comments, $login, $page, $post_comments, $security;

		// User is logged in.
		if ( ! is_a( $login, 'Login' ) ) {
			$login = new Login;
		}
		$user = $login->isLogged();

		// Get data.
		if ( empty( $security->getTokenCSRF() ) ) {
			$security->generateTokenCSRF();
		}
		$captcha = ( $user ) ? 'disabled' : sn_config( 'frontend_captcha' );
		$terms   = ( $user ) ? 'disabled' : sn_config( 'frontend_terms' );

		// Is a reply.
		$reply = isset( $_GET['comments'] ) && $_GET['comments'] == 'reply';
		if ( $reply && isset( $_GET['uid'] ) && $comments->exists( $_GET['uid'] ) ) {
			$reply = new Comment( $_GET['uid'], $page->uuid() );
		}
		?>
		<form class="comment-form" method="post" action="<?php echo $page->permalink(); ?>?comments=comment#comments">

		<?php if ( is_array( $username ) ) { ?>
			<div class="comment-header">
				<input type="hidden" id="comment-user" name="comment[user]" value="<?php echo $username[0]; ?>" />
				<input type="hidden" id="comment-token" name="comment[token]" value="<?php echo $username[1]; ?>" />
				<div class="inner">
					<?php sn_e( 'Logged in as %s (%s)', [ '<strong>' . $username[2] . '</strong>', $username[0] ] ); ?>
				</div>
			</div>
		<?php } else { ?>
			<div class="comment-header">
				<div class="table">
					<div class="table-cell align-left">
						<input type="text" id="comment-user" name="comment[username]" value="<?php echo $username; ?>" placeholder="<?php sn_e( 'Your Username' ); ?>" />
					</div>
					<div class="table-cell align-right">
						<input type="email" id="comment-mail" name="comment[email]" value="<?php echo $email; ?>" placeholder="<?php sn_e( 'Your eMail address' ); ?>" />
					</div>
				</div>
			</div>
		<?php } ?>
			<div class="comment-article">
				<?php if ( Alert :: get( 'comments-alert' ) !== false ) { ?>
					<div class="comment-alert alert-error">
						<?php Alert :: p( 'comments-alert' ); ?>
					</div>
				<?php } elseif ( Alert :: get( 'comments-success' ) !== false ) { ?>
						<div class="comment-alert alert-success">
						<?php Alert :: p( 'comments-success' ); ?>
						</div>
				<?php } ?>

				<?php if ($title !== false) { ?>
					<p>
						<input type="text" id="comment-title" name="comment[title]" value="<?php echo $title; ?>" placeholder="<?php sn_e("Comment Title"); ?>" />
					</p>
				<?php } ?>
				<p>
					<textarea id="comment-text" name="comment[comment]" placeholder="<?php sn_e("Your Comment..."); ?>"><?php echo $message; ?></textarea>
				</p>
				<?php if ($captcha !== "disabled") { ?>
					<div class="comment-captcha">
						<input type="text" name="comment[captcha]" value="" placeholder="<?php sn_e("Answer"); ?>" />

						<a href="<?php echo $page->permalink(); ?>#comments-comment-form" data-captcha="reload">
							<?php echo $post_comments->generateCaptcha(); ?>
						</a>
					</div>
				<?php } ?>

				<?php if (is_a($reply, "Comment")) { ?>
					<div class="comment-reply">
						<a href="<?php echo $page->permalink(); ?>" class="reply-cancel"></a>
						<div class="reply-title">
							<?php echo $reply->username(); ?>             <?php sn_e("wrote"); ?>:
						</div>
						<div class="reply-content">
							<?php echo $reply->comment(); ?>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="comment-footer">
				<div class="table">
					<div class="table-cell align-left">
						<?php if ($terms === "default") { ?>
							<div class="terms-of-use">
								<input type="checkbox" id="comment-terms" name="comment[terms]" value="1" />
								<label for="comment-terms">
									<?php echo sn_config("string_terms_of_use"); ?>
								</label>
							</div>
						<?php } elseif ($terms !== "disabled") { ?>
								<div class="terms-of-use">
									<input type="checkbox" id="comment-terms" name="comment[terms]" value="1" />
									<label for="comment-terms">
									<?php sn_e("I agree the %s!", array('<a href="" target="_blank">' . sn__("Terms of Use") . '</a>')); ?>
									</label>
								</div>
						<?php } ?>
					</div>
					<div class="table-cell align-right">
						<input type="hidden" name="tokenCSRF" value="<?php echo $security->getTokenCSRF(); ?>" />
						<input type="hidden" name="comment[page_uuid]" value="<?php echo $page->uuid(); ?>" />
						<input type="hidden" name="action" value="comments" />
						<?php if (is_a($reply, "Comment")) { ?>
							<input type="hidden" name="comment[parent_uid]" value="<?php echo $reply->uid(); ?>" />
							<button name="comments" value="reply" data-string="<?php sn_e("Comment"); ?>"><?php sn_e("Answer"); ?></button>
						<?php } else { ?>
							<button name="comments" value="comment" data-string="<?php sn_e("Answer"); ?>"><?php sn_e("Comment"); ?></button>
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
		<?php

		unset($_SESSION["s_comments-alert"]);        // Remove Alerts
		unset($_SESSION["s_comments-success"]);      // Remove Success
	}

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
	public function comment($comment, $uid, $depth) {
		global $users, $security, $post_comments, $comments_users;

		// Get Page
		$page = new Page($comment->page_key());
		$user = $comments_users->getByString($comment->getValue("author"));

		// Render
		$token = $security->getTokenCSRF();
		$maxdepth = (int) sn_config("comment_depth");
		$url = $page->permalink() . "?action=comments&comments=rate&uid=%s&tokenCSRF=%s";
		$url = sprintf($url, $comment->uid(), $token);
		?>
		<div id="comment-<?php echo $comment->uid(); ?>" class="comment" style="margin-left: <?php echo (15 * ($depth - 1)); ?>px;">
			<div class="table">
				<div class="table-cell comment-avatar">
					<?php
					if ( $comment->user_has_profile( $user["username"] ) ) {
						printf(
							'<a href="%s">',
							$comment->profile_link( $comment->getValue("author") )
						);
					}
					echo $comment->avatar();
					if ( $comment->user_has_profile($user["username"]) ) {
						echo '</a>';
					}
					?>

					<?php
						if (isset($user["role"]) && $user["username"] === $page->username()) {
							echo '<p class="comment-role">Author</p>';
						} elseif (isset($user["role"]) && $user["role"] === "admin") {
							echo '<p class="comment-role">Admin</p>';
						}
					?>
				</div>

				<div class="table-cell comment-content">
					<?php if (sn_config("comment_title") !== "disabled" && !empty($comment->title())) { ?>
						<div class="comment-title">
							<?php echo $comment->title(); ?>
							<?php if ($comment->status() === "pending") { ?>
								<span class="comment-moderation"><?php sn_e("This comment hasn't been moderated yet!"); ?></span>
							<?php } ?>
						</div>
					<?php } elseif ($comment->status() === "pending") { ?>
							<div class="comment-moderation"><?php sn_e("This comment hasn't been moderated yet!"); ?></div>
					<?php } ?>
					<div class="comment-meta">
						<span class="meta-author">
							<?php sn_e("Written by %s", array('<span class="author-username">' . $user["username"] . '</span>')); ?>
						</span>
						<span class="meta-date">
							<?php sn_e("on %s", array($comment->date())); ?>
						</span>
					</div>
					<div class="comment-comment">
						<?php echo $comment->comment(); ?>
					</div>
				</div>
			</div>

			<div class="comment-action">
				<div class="table">
					<div class="table-cell align-left">
						<?php if (sn_config("comment_enable_like")) { ?>
							<a href="<?php echo $url; ?>&type=like" class="action-like <?php echo ($post_comments->hasLiked($comment->uid()) ? "active" : ""); ?>">
								<?php sn_e("Like"); ?> <span data-comments="like"><?php echo $comment->like(); ?></span>
							</a>
						<?php } ?>
						<?php if (sn_config("comment_enable_dislike")) { ?>
							<a href="<?php echo $url; ?>&type=dislike" class="action-dislike <?php echo ($post_comments->hasDisliked($comment->uid()) ? "active" : ""); ?>">
								<?php sn_e("Dislike"); ?> <span data-comments="dislike"><?php echo $comment->dislike(); ?></span>
							</a>
						<?php } ?>
					</div>
					<div class="table-cell align-right">
						<?php if ($maxdepth === 0 || $maxdepth > $comment->depth()) { ?>
							<a href="<?php echo $page->permalink(); ?>?comments=reply&uid=<?php echo $comment->key(); ?>#post-comments-form" class="action-reply">
								<?php sn_e("Reply"); ?>
							</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

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
	public function pagination($location, $cpage, $limit, $count) {
		global $url;

		// Data
		$link = DOMAIN . $url->uri() . "?cpage=%d#post-comments-list";
		$maxpages = (int) ceil($count / $limit);
		$prev = ($cpage === 1) ? false : $cpage - 1;
		$next = ($cpage === $maxpages) ? false : $cpage + 1;

		// Top Position
		if ($location === "top") {
			?>
			<div class="pagination pagination-top">
				<?php if ($cpage === 1) { ?>
					<span class="pagination-button button-previous disabled"><?php sn_e("Previous Comments"); ?></span>
				<?php } else { ?>
					<a href="<?php printf($link, $prev); ?>" class="pagination-button button-previous"><?php sn_e("Previous Comments"); ?></a>
				<?php } ?>

				<?php if ($cpage < $maxpages) { ?>
					<a href="<?php printf($link, $next); ?>" class="pagination-button button-next"><?php sn_e("Next Comments"); ?></a>
				<?php } else { ?>
					<span class="pagination-button button-next disabled"><?php sn_e("Next Comments"); ?></span>
				<?php } ?>
			</div>
			<?php
		}

		// Bottom Position
		if ($location === "bottom") {
			?>
			<div class="pagination pagination-bottom">
				<div class="pagination-inner">
					<?php if ($prev === false) { ?>
						<span class="pagination-button button-first disabled">&laquo;</span>
						<span class="pagination-button button-previous disabled">&lsaquo;</span>
					<?php } else { ?>
						<a href="<?php printf($link, 1); ?>" class="pagination-button button-first">&laquo;</a>
						<a href="<?php printf($link, $prev); ?>" class="pagination-button button-previous">&lsaquo;</a>
					<?php } ?>

					<?php
					if ($maxpages < 6) {
						$start = 1;
						$stop = $maxpages;
					} else {
						$start = ($cpage > 3) ? $cpage - 3 : $cpage;
						$stop = ($cpage + 3 < $maxpages) ? $cpage + 3 : $maxpages;
					}

					if ($start > 1) {
						?><span class="pagination-button button-sep disabled">...</span><?php
					}
					for ($i = $start; $i <= $stop; $i++) {
						$active = ($i == $cpage) ? "active" : "";
						?>
						<a href="<?php printf($link, $i); ?>" class="pagination-button button-number <?php echo $active; ?>"><?php echo $i; ?></a>
						<?php
					}
					if ($stop < $maxpages) {
						?><span class="pagination-button button-sep disabled">...</span><?php
					}
					?>

					<?php if ($next !== false) { ?>
						<a href="<?php printf($link, $next); ?>" class="pagination-button button-next">&rsaquo;</a>
						<a href="<?php printf($link, $maxpages); ?>" class="pagination-button button-last">&raquo;</a>
					<?php } else { ?>
						<span class="pagination-button button-next disabled">&rsaquo;</span>
						<span class="pagination-button button-last disabled">&raquo;</span>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}
}
