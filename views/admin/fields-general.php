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
<h2 class="form-heading"><?php lang()->p( 'General Settings' ); ?></h2>

<div class="form-field form-group row">
	<label for="moderation" class="form-label col-sm-2 col-form-label"><?php lang()->p( 'Moderation' ); ?></label>
	<div class="col-sm-10">
		<select id="moderation" name="moderation" class="form-select">
			<option value="true" <?php sn_selected( 'moderation', true ); ?>><?php lang()->p( 'Enabled' ); ?></option>
			<option value="false" <?php sn_selected( 'moderation', false ); ?>><?php lang()->p( 'Disabled' ); ?></option>
		</select>
		<small class="form-text"><?php lang()->p( 'Enable manual approval of comments before displaying to the public.' ) ?></small>
	</div>
</div>

<div class="form-field form-group row">
	<label for="no_moderation_role" class="form-label col-sm-2 col-form-label"><?php lang()->p( 'Exceptions' ); ?></label>
	<div class="col-sm-10">
		<input type="hidden" name="no_moderation_role[]" value="default" />
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="admin"> <input type="checkbox" name="no_moderation_role[]" id="admin" value="admin" checked="checked" disabled="disabled" /> %s</label>',
				sn__( 'Administrator' )
			); ?>
		</div>
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="editor"> <input type="checkbox" name="no_moderation_role[]" id="editor" value="editor" %s /> %s</label>',
				( is_array( $this->getValue( 'no_moderation_role' ) ) && in_array( 'editor', $this->getValue( 'no_moderation_role' ) ) ? 'checked' : '' ),
				sn__( 'Editor' )
			); ?>
		</div>
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="author"> <input type="checkbox" name="no_moderation_role[]" id="author" value="author" %s /> %s</label>',
				( is_array( $this->getValue( 'no_moderation_role' ) ) && in_array( 'author', $this->getValue( 'no_moderation_role' ) ) ? 'checked' : '' ),
				sn__( 'Author' )
			); ?>
		</div>
		<small class="form-text"><?php lang()->p( 'The user roles that do not require moderation.' ) ?></small>
	</div>
</div>
<b>@todo Role to access comments.</b>
<div class="form-field form-group row">
	<label for="comment_page_type" class="form-label col-sm-2 col-form-label"><?php lang()->p( 'Content Types' ); ?></label>
	<div class="col-sm-10">
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="published"> <input type="checkbox" name="comment_page_type[]" id="published" value="published" %s /> %s</label>',
				( is_array( $this->getValue( 'comment_page_type' ) ) && in_array( 'published', $this->getValue( 'comment_page_type' ) ) ? 'checked' : '' ),
				sn__( 'Standard Posts' )
			); ?>
		</div>
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="sticky"> <input type="checkbox" name="comment_page_type[]" id="sticky" value="sticky" %s /> %s</label>',
				( is_array( $this->getValue( 'comment_page_type' ) ) && in_array( 'sticky', $this->getValue( 'comment_page_type' ) ) ? 'checked' : '' ),
				sn__( 'Sticky Posts' )
			); ?>
		</div>
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="static"> <input type="checkbox" name="comment_page_type[]" id="static" value="static" %s /> %s</label>',
				( is_array( $this->getValue( 'comment_page_type' ) ) && in_array( 'static', $this->getValue( 'comment_page_type' ) ) ? 'checked' : '' ),
				sn__( 'Static Pages' )
			); ?>
		</div>
		<small class="form-text"><?php lang()->p( 'The content types to apply comments.' ) ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="comment-title" class="col-sm-2 col-form-label"><?php lang()->p( 'Comment Title' ); ?></label>
	<div class="col-sm-10">
		<select id="comment-title" name="comment_title" class="form-select">
			<option value="optional" <?php sn_selected( 'comment_title', 'optional' ); ?>><?php lang()->p( 'Optional' ); ?></option>
			<option value="required" <?php sn_selected( 'comment_title', 'required' ); ?>><?php lang()->p( 'Required' ); ?></option>
			<option value="disabled" <?php sn_selected( 'comment_title', 'disabled' ); ?>><?php lang()->p( 'Disabled' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="comment-limit" class="col-sm-2 col-form-label"><?php lang()->p( 'Comments Limit' ); ?></label>
	<div class="col-sm-10">
		<input type="number" id="comment-limit" name="comment_limit" value="<?php echo sn_config( 'comment_limit' ); ?>" class="form-control" min="0" step="1" placeholder="0" />
		<small class="form-text"><?php lang()->p( 'Use 0 for no limit.' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="comment-depth" class="col-sm-2 col-form-label"><?php lang()->p( 'Comments Depth' ); ?></label>
	<div class="col-sm-10">
		<input type="number" id="comment-depth" name="comment_depth" value="<?php echo sn_config( 'comment_depth' ); ?>" class="form-control" min="0" placeholder="<?php lang()->p( 'Use 0 to disable any limit!' ); ?>" />
		<small class="form-text text-muted"><?php lang()->p( 'Use 0 to disable any limit.' ); ?></small>
	</div>
</div>

<div class="form-field form-group row">
	<label for="comment_markup" class="form-label col-sm-2 col-form-label"><?php lang()->p( 'Comment Markup' ); ?></label>
	<div class="col-sm-10">
		<input type="hidden" name="comment_markup[]" value="default" />
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="html"> <input type="checkbox" name="comment_markup[]" id="html" value="html" %s /> %s</label>',
				( is_array( $this->getValue( 'comment_markup' ) ) && in_array( 'html', $this->getValue( 'comment_markup' ) ) ? 'checked' : '' ),
				sn__( 'Basic HTML' )
			); ?>
		</div>
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="mark"> <input type="checkbox" name="comment_markup[]" id="mark" value="mark" %s /> %s</label>',
				( is_array( $this->getValue( 'comment_markup' ) ) && in_array( 'mark', $this->getValue( 'comment_markup' ) ) ? 'checked' : '' ),
				sn__( 'Markdown' )
			); ?>
		</div>
	</div>
</div>

<div class="form-field form-group row">
	<label for="comment_votes" class="form-label col-sm-2 col-form-label"><?php lang()->p( 'Comment Voting' ); ?></label>
	<div class="col-sm-10">
		<input type="hidden" name="comment_votes[]" value="default" />
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="like"> <input type="checkbox" name="comment_votes[]" id="like" value="like" %s /> %s</label>',
				( is_array( $this->getValue( 'comment_votes' ) ) && in_array( 'like', $this->getValue( 'comment_votes' ) ) ? 'checked' : '' ),
				sn__( 'Comment Likes' )
			); ?>
		</div>
		<div class="custom-checkbox">
			<?php
			printf(
				'<label class="check-label-wrap" for="dislike"> <input type="checkbox" name="comment_votes[]" id="dislike" value="dislike" %s /> %s</label>',
				( is_array( $this->getValue( 'comment_votes' ) ) && in_array( 'dislike', $this->getValue( 'comment_votes' ) ) ? 'checked' : '' ),
				sn__( 'Comment Dislikes' )
			); ?>
		</div>
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-2 col-form-label"><?php lang()->p( 'Vote Storage' ); ?></label>
	<div class="col-sm-10">
		<select id="vote-storage" name="comment_vote_storage" class="form-select">
			<option value="cookie" <?php sn_selected( 'comment_vote_storage", "cookie' ); ?>><?php lang()->p( 'Cookie Storage' ); ?></option>
			<option value="session" <?php sn_selected( 'comment_vote_storage", "session' ); ?>><?php lang()->p( 'Session Storage' ); ?></option>
			<option value="database" <?php sn_selected( 'comment_vote_storage", "database' ); ?>><?php lang()->p( 'Database Storage' ); ?></option>
		</select>
		<small class="form-text"><?php lang()->p( 'How to store votes made by guests.' ); ?></small>

		<div id="help-content">
			<p>
				<?php lang()->p( '<strong>Cookie Storage</strong> is located on the computer of the user. So you don\'t have the full control and you require the appropriate permissions from the user.' ); ?>
			</p>
			<p>
				<?php lang()->p( '<strong>Session Storage</strong> is just stored temporary on the server, it gets cleaned up when the user closes the browser. Therefore you don\'t need any permissions from the user.' ); ?>
			</p>
			<p>
				<?php lang()->p( '<strong>Database Storage</strong> generates and stores an anonymized but assignable value of the user, which also requires the appropriate permissions from the user.' ); ?>
			</p>
			<p>
				<?php lang()->p( '<strong>Please Note:</strong> You are responsible for obtaining the appropriate permissions, Post Comments just handles the permissions for data sent and stored via the comment form.' ); ?>
			</p>
		</div>
	</div>
</div>
