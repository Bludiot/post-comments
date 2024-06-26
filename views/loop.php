<?php
/**
 * Comments loop
 *
 * @package    Post Comments
 * @subpackage Views
 * @since      1.0.0
 */

// Access namespaced functions.
use function Post_Comments\{
	login,
	user_logged_in,
	can_manage,
	comment_count,
	loop_heading,
	user_avatar,
	icon
};

// Access global variables.
global $L, $page;

?>
<?php

if ( file_exists( $file_path ) ) {

	$comments = simplexml_load_file( $file_path );

	if ( comment_count() > 0 ) {
		echo loop_heading();
	}
	echo '<ol class="comments-list">';

	foreach ( $comments->comment as $comment ) {

		$username = (string) $comment->comment_username;

		$approve_comment = '';
		if ( true !== (bool) $comment->approved ) {
			$approve_comment = sprintf(
				'<form class="inline-form" method="POST"><input type="hidden" name="publishComment" value="%1s" /><button type="submit" class="comment-admin-button comment-approve" title="%2s">%3s %4s</button></form>',
				$comment['id'],
				$L->get( 'Approve Comment' ),
				icon( 'stamp', true, 'inline-svg-icon' ),
				$L->get( 'Approve' )
			);
		}

		$delete_comment = sprintf(
			'<form class="inline-form" method="POST"><input type="hidden" name="deleteComment" value="%1s" /><button type="submit" class="comment-admin-button comment-delete" title="%2s">%3s %4s</button></form>',
			$comment['id'],
			$L->get( 'Delete Comment' ),
			icon( 'trash', true, 'inline-svg-icon' ),
			$L->get( 'Delete' )
		);

		$comment_details = sprintf(
			'<p class="comment-details"><date>%s</date> <a href="%s" title="%s">%s<span class="screen-reader-text">%s</span></a></p>',
			$comment->comment_date,
			$page->permalink() . '#' . $comment['id'],
			$L->get( 'Copy Link' ),
			icon( 'link', true, 'inline-svg-icon' ),
			$L->get( 'Link' )
		);

		/**
		 * Begin top-level comment
		 *
		 * Print the comment list item only if it has been approved
		 * or if the current user is logged in as administrator.
		 */
		if ( (bool) $comment->approved || can_manage() ) {

			printf(
				'<li id="%s" class="comments-entry post-comment">',
				$comment['id']
			);
			echo '<header class="comment-header">';

			if ( $users->exists( $username ) && getPlugin( 'User_Profiles' ) ) {

				printf(
					'<p class="comment-name"><a href="%s"><img src="%s" class="avatar comment-avatar" width="36" height="36" role="presentation" />%s</a></p>',
					\UPRO_Tags\user_link( $username ),
					user_avatar( $username ),
					\UPRO_Tags\user_display_name( $username )
				);
				echo $comment_details;
			} else {
				printf(
					'<p class="comment-name"><img src="%s" class="avatar comment-avatar" width="36" height="36" role="presentation" /> %s</p>',
					user_avatar( $username ),
					htmlspecialchars( $comment->comment_name, ENT_QUOTES, 'UTF-8' )
				);
				echo $comment_details;
			}
			echo '</header>';
			printf(
				'<div class="comment-body">%s</div>',
				htmlspecialchars( $comment->comment_body, ENT_QUOTES, 'UTF-8' )
			);
			echo '<footer class="comment-footer">';

			printf(
				'<a href="#comment-form" class="comment-reply" data-name="%1s" data-reply="%2s">%3s %4s</a>',
				$comment->comment_name,
				$comment['id'],
				icon( 'comment', true, 'inline-svg-icon' ),
				$L->get( 'Reply' )
			);

			if ( user_logged_in() ) {
				if ( 'author' == login()->role() && login()->username() === $page->username() ) {
					echo $approve_comment;
					echo $delete_comment;
				} elseif ( 'author' != login()->role() ) {
					echo $approve_comment;
					echo $delete_comment;
				}
			}
			echo '</footer></li>';

			if ( isset( $comment->response ) ) {

				echo '<ol class="comments-list comments-reply-list">';

				foreach ( $comment->response as $response ) {

					$username = (string) $response->comment_username;

					$approve_response = '';
					if ( true !== (bool) $response->approved ) {
						$approve_response = sprintf(
							'<form class="inline-form" method="POST"><input type="hidden" name="publishComment" value="%1s" /><button type="submit" class="comment-admin-button comment-approve" title="%2s">%3s %4s</button></form>',
							$response['id'],
							$L->get( 'Approve Reply' ),
							icon( 'stamp', true, 'inline-svg-icon' ),
							$L->get( 'Approve' )
						);
					}

					$delete_response = sprintf(
						'<form class="inline-form" method="POST"><input type="hidden" name="deleteComment" value="%1s" /><button type="submit" class="comment-admin-button comment-delete" title="%2s">%3s %4s</button></form>',
						$response['id'],
						$L->get( 'Delete Comment' ),
						icon( 'trash', true, 'inline-svg-icon' ),
						$L->get( 'Delete' )
					);

					$response_details = sprintf(
						'<p class="comment-details"><date>%s</date> <a href="%s" title="%s">%s<span class="screen-reader-text">%s</span></a></p>',
						$response->comment_date,
						$page->permalink() . '#' . $response['id'],
						$L->get( 'Copy Link' ),
						icon( 'link', true, 'inline-svg-icon' ),
						$L->get( 'Link' )
					);

					if ( (bool) $response->approved || can_manage() ) {

						printf(
							'<li id="%s" class="comments-entry post-comment-reply">',
							$response['id']
						);
						echo '<header class="comment-header">';

						$reply_tag = '';
						if ( $response->reply_id && $response->reply_name ) {
							$reply_tag = sprintf(
								' <span class="reply-to">%s <a href="#%s">%s</a></span>',
								$L->get( 'Reply to' ),
								$response->reply_id,
								$response->reply_name
							);
						}

						if ( $users->exists( $username ) && getPlugin( 'User_Profiles' ) ) {

							printf(
								'<p class="comment-name"><a href="%s"><img src="%s" class="avatar comment-avatar" width="36" height="36" role="presentation" />%s</a>%s</p>',
								\UPRO_Tags\user_link( $username ),
								user_avatar( $username ),
								\UPRO_Tags\user_display_name( $username ),
								$reply_tag
							);
							echo $response_details;
						} else {
							printf(
								'<p class="comment-name"><img src="%s" class="avatar comment-avatar" width="36" height="36" role="presentation" /> %s%s</p>',
								user_avatar( $username ),
								htmlspecialchars( $response->comment_name, ENT_QUOTES, 'UTF-8' ),
								$reply_tag
							);
							echo $response_details;
						}

						echo '</header>';
						printf(
							'<div class="comment-body">%s</div>',
							htmlspecialchars( $response->comment_body, ENT_QUOTES, 'UTF-8' )
						);
						echo '<footer class="comment-footer">';

						printf(
							'<a href="#comment-form" class="comment-reply" data-name="%1s" data-reply="%2s">%3s %4s</a>',
							$response->comment_name,
							$response['id'],
							icon( 'comment', true, 'inline-svg-icon' ),
							$L->get( 'Reply' )
						);

						if ( user_logged_in() ) {
							if ( 'author' == login()->role() && login()->username() === $page->username() ) {
								echo $approve_response;
								echo $delete_response;
							} elseif ( 'author' != login()->role() ) {
								echo $approve_response;
								echo $delete_response;
							}
						}
						echo '</footer>';
						echo '</li>';
					}
				}
			echo '</ol>';
			}
		}
	}
	echo '</ol>';
} ?>
<script>
$( function() {
	$( '.comment-delete' ).bind( 'click', function() {
		if ( ! confirm( '<?php $L->p( 'Are you sure you want to delete this comment?' ); ?>' ) ) {
			return false;
		}
	});
});

var replyButtons = document.querySelectorAll( '.comment-reply' );

replyButtons.forEach( function( replyButton ) {
	replyButton.addEventListener( 'click', function() {

		var parent_id = replyButton.getAttribute( 'data-reply' );

		document.getElementById( 'parent_id' ).value = parent_id;
		document.querySelector( '.reply-to-banner' ).classList.remove( 'hide-reply-to' );

		var parent_name = replyButton.getAttribute( 'data-name' );

		document.getElementById( 'replying_to' ).innerText = parent_name;
		document.getElementById( 'reply_id' ).value = parent_id;
		document.getElementById( 'reply_name' ).value = parent_name;
	});
});
</script>
