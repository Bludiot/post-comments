<?php
/**
 * General settings tab
 *
 * @package    Post Comments
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

?>
<h2 class="form-heading"><?php sn_e( 'General Settings' ); ?></h2>

<div class="form-field form-group row">
	<label for="sn-moderation" class="form-label col-sm-2 col-form-label"><?php sn_e( 'Moderation' ); ?></label>
	<div class="col-sm-10">
		<select id="sn-moderation" name="moderation" class="form-select">
			<option value="true" <?php sn_selected( 'moderation', true ); ?>><?php sn_e( 'Enabled' ); ?></option>
			<option value="false" <?php sn_selected( 'moderation', false ); ?>><?php sn_e( 'Disabled' ); ?></option>
		</select>
		<small class="form-text"><?php sn_e( 'Enable manual approval of comments before displaying to the public.' ) ?></small>
	</div>
</div>
<div class="form-field form-group row">
	<label for="sn-moderation" class="form-label col-sm-2 col-form-label"><?php sn_e( 'Exceptions' ); ?></label>
	<div class="col-sm-10">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-moderation-loggedin" name="moderation_loggedin" value="true"
					class="custom-control-input" <?php sn_checked( 'moderation_loggedin' ); ?> />
			<label class="custom-control-label" for="sn-moderation-loggedin"><?php sn_e( 'Unless the user is logged in' ); ?></label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" value="true" class="custom-control-input" checked="checked" disabled="disabled" />
			<label class="custom-control-label"><?php sn_e( 'Unless the user is admin or the content author' ); ?></label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-moderation-approved" name="moderation_approved" value="true"
					class="custom-control-input" <?php sn_checked( 'moderation_approved' ); ?> />
			<label class="custom-control-label" for="sn-moderation-approved"><?php sn_e( 'Unless the user has an already approved comment' ); ?></label>
		</div>
	</div>
</div>

<div class="form-group row">
	<label for="sn-comment-title" class="col-sm-2 col-form-label"><?php sn_e( 'Allow Comments' ); ?></label>
	<div class="col-sm-10">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-comment-on-public" name="comment_on_public" value="true"
					class="custom-control-input" <?php sn_checked( 'comment_on_public' ); ?> />
			<label class="custom-control-label" for="sn-comment-on-public"><?php sn_e( 'Standard Posts' ); ?></label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-comment-on-sticky" name="comment_on_sticky" value="true"
					class="custom-control-input" <?php sn_checked( 'comment_on_sticky' ); ?> />
			<label class="custom-control-label" for="sn-comment-on-sticky"><?php sn_e( 'Sticky Posts' ); ?></label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-comment-on-static" name="comment_on_static" value="true"
					class="custom-control-input" <?php sn_checked( 'comment_on_static' ); ?> />
			<label class="custom-control-label" for="sn-comment-on-static"><?php sn_e( 'Static Pages' ); ?></label>
		</div>
	</div>
</div>

<div class="form-group row">
	<label for="sn-comment-title" class="col-sm-2 col-form-label"><?php sn_e( 'Comment Title' ); ?></label>
	<div class="col-sm-10">
		<select id="sn-comment-title" name="comment_title" class="form-select">
			<option value="optional" <?php sn_selected( 'comment_title', 'optional' ); ?>><?php sn_e( 'Optional' ); ?></option>
			<option value="required" <?php sn_selected( 'comment_title', 'required' ); ?>><?php sn_e( 'Required' ); ?></option>
			<option value="disabled" <?php sn_selected( 'comment_title', 'disabled' ); ?>><?php sn_e( 'Disabled' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="sn-comment-limit" class="col-sm-2 col-form-label"><?php sn_e( 'Comments Limit' ); ?></label>
	<div class="col-sm-10">
		<input type="number" id="sn-comment-limit" name="comment_limit" value="<?php echo sn_config( 'comment_limit' ); ?>" class="form-control" min="0" step="1" placeholder="0" />
		<small class="form-text"><?php sn_e( 'Use 0 for no limit.' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="sn-comment-depth" class="col-sm-2 col-form-label"><?php sn_e( 'Comments Depth' ); ?></label>
	<div class="col-sm-10">
		<input type="number" id="sn-comment-depth" name="comment_depth" value="<?php echo sn_config( 'comment_depth' ); ?>"
				class="form-control" min="0" placeholder="<?php sn_e( 'Use 0 to disable any limit!' ); ?>" />
		<small class="form-text text-muted"><?php sn_e( 'Use 0 to disable any limit.' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-2 col-form-label"><?php sn_e( 'Comment Markup' ); ?></label>
	<div class="col-sm-10">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-markup-html" name="comment_markup_html" value="true"
					class="custom-control-input" <?php sn_checked( 'comment_markup_html' ); ?> />
			<label class="custom-control-label" for="sn-markup-html"><?php sn_e( 'Allow Basic HTML' ); ?></label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-markup-markdown" name="comment_markup_markdown" value="true"
					class="custom-control-input" <?php sn_checked( 'comment_markup_markdown' ); ?> />
			<label class="custom-control-label" for="sn-markup-markdown"><?php sn_e( 'Allow Markdown' ); ?></label>
		</div>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-2 col-form-label"><?php sn_e( 'Comment Voting' ); ?></label>
	<div class="col-sm-10">

		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-like" name="comment_enable_like" value="true"
					class="custom-control-input" <?php sn_checked( 'comment_enable_like' ); ?> />
			<label class="custom-control-label" for="sn-like"><?php sn_e( 'Allow to %s comments', array( '<b>' . sn__( 'Like' ) . '</b>' )); ?></label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" id="sn-dislike" name="comment_enable_dislike" value="true"
					class="custom-control-input" <?php sn_checked( 'comment_enable_dislike' ); ?> />
			<label class="custom-control-label" for="sn-dislike"><?php sn_e( 'Allow to %s comments', array( '<b>' . sn__( 'Dislike' ) . '</b>' )); ?></label>
		</div>
		<br />
		<select id="sn-vote-storage" name="comment_vote_storage" class="form-select">
			<option value="cookie" <?php sn_selected( 'comment_vote_storage", "cookie' ); ?>><?php sn_e( 'Cookie Storage' ); ?></option>
			<option value="session" <?php sn_selected( 'comment_vote_storage", "session' ); ?>><?php sn_e( 'Session Storage' ); ?></option>
			<option value="database" <?php sn_selected( 'comment_vote_storage", "database' ); ?>><?php sn_e( 'Database Storage' ); ?></option>
		</select>
		<small class="form-text"><?php sn_e( 'How to store votes made by guests.' ); ?></small>

		<div id="help-content">
			<p>
				<?php sn_e( '<strong>Cookie Storage</strong> is located on the computer of the user. So you don\'t have the full control and you require the appropriate permissions from the user.' ); ?>
			</p>
			<p>
				<?php sn_e( '<strong>Session Storage</strong> is just stored temporary on the server, it gets cleaned up when the user closes the browser. Therefore you don\'t need any permissions from the user.' ); ?>
			</p>
			<p>
				<?php sn_e( '<strong>Database Storage</strong> generates and stores an anonymized but assignable value of the user, which also requires the appropriate permissions from the user.' ); ?>
			</p>
			<p>
				<?php sn_e( '<strong>Please Note:</strong> You are responsible for obtaining the appropriate permissions, Post Comments just handles the permissions for data sent and stored via the comment form.' ); ?>
			</p>
		</div>
	</div>
</div>
