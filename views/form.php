<?php
/**
 * Comments form
 *
 * @package    Post Comments
 * @subpackage Views
 * @since      1.0.0
 */

// Access namespaced functions.
use function Post_Comments\{
	plugin,
	user_logged_in,
	user,
	username,
	user_display_name,
	form_heading,
	terms_page_url,
	captcha
};

$question = captcha();
$_SESSION['captcha_question'] = $question;

$name  = '';
$email = '';
if ( user_logged_in() ) {
	$user  = user( username() );
	$name  = user_display_name( username() );
	$email = $user->email();
}
$date = date( 'F j, Y' );
$time = date( 'h:i:s A' );

// Accept terms message.
if ( ! empty( terms_page_url() ) ) {
	$terms = sprintf(
		$L->get( 'I agree to the <a href="%s" target="_blank" rel="noopener noreferrer">terms of use</a>.' ),
		terms_page_url()
	);
} else {
	$terms = $L->get( 'I agree to the terms of use.' );
}

?>
<style>
#captcha-question {
	background-image: url( <?php echo DOMAIN_BASE . 'bl-plugins/' . plugin()->directoryName . '/assets/images/captcha.jpg'; ?> );
}
</style>

<form class="easyCommentsForm" id="comment-form" method="post" autocomplete="on">

	<?php echo form_heading( 'h3' ); ?>

	<?php if ( user_logged_in() ) : ?>
	<p><?php $L->p( 'You are logged in as' ); echo ' ' . user_display_name( username() ); ?> <a href="<?php echo DOMAIN_ADMIN . 'logout'; ?>"><?php $L->p( 'Log out?' ); ?></a></p>
	<?php endif; ?>

	<div class="reply-to-banner hide-reply-to">
		<p><?php $L->p( 'Replying to' ); ?> <span id="replying_to"></span></p>
	</div>

	<input type="hidden" name="comment_date" id="date" value="<?php echo $date; ?>" />
	<input type="hidden" name="comment_time" id="time" value="<?php echo $time; ?>" />

	<div>
		<label for="comment_name"><?php $L->p( 'pcs-form-name' ); ?></label> <sup class="required-field">*</sup><br />
		<input type="text" name="comment_name" id="name" value="<?php echo $name; ?>" required />
	</div>

	<input type="hidden" name="comment_username" id="username" value="<?php echo username(); ?>" />
	<input type="hidden" name="reply_id" id="reply_id" value="" />
	<input type="hidden" name="reply_name" id="reply_name" value="" />

	<div>
		<label for="comment_email"><?php $L->p( 'pcs-form-email' ); ?></label> <sup class="required-field">*</sup><br />
		<input type="email" name="comment_email" id="email" placeholder="email@example.com" value="<?php echo $email; ?>" required />
	</div>

	<div>
		<label for="comment_body"><?php $L->p( 'pcs-form-comment' ); ?></label> <sup class="required-field">*</sup><br />
		<textarea name="comment_body" id="comment-form-message" required /></textarea>
	</div>

	<input type="hidden" name="parent_id" id="parent_id" value="" />

	<?php if ( plugin()->accept_terms() ) : ?>
	<p>
		<label for="form_accept">
			<input type="checkbox" name="form_accept" id="form_accept" required />
			<?php echo $terms; ?> <sup class="required-field">*</sup>
		</label>
	</p>
	<?php endif; ?>

	<p><?php $L->p( 'Type the security code into the box; case sensitive.' ); ?></p>
	<div id="captcha-wrap">
		<div id="captcha-question"><?php echo $question; ?></div>
		<div id="captcha-answer">
			<input type="text" name="captcha_answer" placeholder="<?php $L->p( 'Code here' ); ?>" autocomplete="off" required />
		</div>
	</div>

	<!-- Pole honeypot -->
	<input type="text" name="honeypot" style="display: none;" />
	<p>
		<input type="submit" name="send_comment" value="<?php $L->p( 'addcomment' ); ?>" />
	</p>
</form>
