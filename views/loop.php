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
	comment_count,
	loop_heading,
	user_avatar,
	icon
};

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

		if ( (bool) $comment->approved || checkRole( [ 'admin' ], false ) ) {

			printf(
				'<li id="%s" class="comments-entry post-comment"><header class="comment-header">',
				$comment['id']
			);

			if ( $users->exists( $username ) && getPlugin( 'User_Profiles' ) ) {

				printf(
					'<p class="comment-name"><a href="%s"><img src="%s" class="avatar comment-avatar" width="36" height="36" />%s</a></p>',
					\UPRO_Tags\user_link( $username ),
					user_avatar( $username ),
					\UPRO_Tags\user_display_name( $username )
				);
				printf(
					'<p class="comment-date">%s</p>',
					$comment->comment_datetime
				);
			} else {
				printf(
					'<p class="comment-name"><img src="%s" class="avatar comment-avatar" width="36" height="36" /> %s</p>',
					user_avatar( $username ),
					htmlspecialchars( $comment->comment_name, ENT_QUOTES, 'UTF-8' )
				);
				printf(
					'<p class="comment-date"><date>%s</date></p>',
					$comment->comment_datetime
				);
			}

			echo '</header>';

			echo '<div class="comment-body">' . htmlspecialchars( $comment->comment_body, ENT_QUOTES, 'UTF-8' ) . '</div>';

			echo '<footer class="comment-footer">';

			echo '<a href="#comment-form" class="comment-reply" data-name="' . $comment->comment_name . '" data-reply="' . $comment['id'] . '">' . icon( 'comment', true, 'inline-svg-icon' ) . $L->get( 'Reply' ) . '</a>';

			if ( checkRole( [ 'admin' ], false ) ) {

				if ( true !== (bool) $comment->approved ) {
					echo '
						<form class="inline-form" method="POST">
						<input type="hidden" name="publishComment" value="' . $comment['id'] . '">' . icon( 'stamp', true, 'inline-svg-icon' ) . '
						<input type="submit" class="comment-admin-button comment-approve" value="' . $L->get( 'Approve' ) . '">
						</form>';
				};

				echo '<form class="inline-form" method="POST">';
				echo '<input type="hidden" name="deleteComment" value="' . $comment['id'] . '">';
				printf(
					'<button type="submit" class="comment-admin-button comment-delete" title="%s">%s %s</button>',
					$L->get( 'Delete Comment' ),
					icon( 'trash', true, 'inline-svg-icon' ),
					$L->get( 'Delete' )
				);
				echo '</form>';
			}

			echo '</header>';
			echo '</li>';

			if ( isset( $comment->response ) ) {
				echo '<ol class="comments-list comments-reply-list">';
				foreach ( $comment->response as $response ) {

					if ( (bool) $response->approved || checkRole( [ 'admin' ], false ) ) {

						echo '<li class="comments-entry post-comment-reply">';

						if ( checkRole( [ 'admin' ], false ) ) {

							if ( true !== (bool) $response->approved ) {
								echo '
								<form class="inline-form" method="POST">
								<input type="hidden" name="publishComment" value="' . $response['id'] . '">
								<input type="submit" class="comment-admin-button comment-approve" value="Publish">
								</form>';
							};

							echo  ' <form class="inline-form" method="POST">
							<input type="hidden" name="deleteComment" value="' . $response['id'] . '">
							<input type="submit" class="comment-admin-button comment-delete" value="Delete">
							</form>';
						};

						echo '<p class="comment-name">' . htmlspecialchars( $response->comment_name, ENT_QUOTES, 'UTF-8' ) . '</p>';
						echo '<p>' . htmlspecialchars( $response->comment_body, ENT_QUOTES, 'UTF-8') . '</p>';
						echo '<a href="#comment-form" class="comment-reply" data-name="' . $response->comment_name . '" data-reply="' . $comment['id'] . '">' . $L->get( 'Reply' ) . '</a>';

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

		document.getElementById( 'reply_to' ).innerText = parent_name;
	});
});
</script>
