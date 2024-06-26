<?php
/**
 * Comments options page
 *
 * @package    Post Comments
 * @subpackage Views
 * @since      1.0.0
 */

?>
<div class="alert alert-primary alert-search-forms" role="alert">
	<p class="m-0"><?php $L->p( 'Options for the post comments form and for the loop/list.' ); ?></p>
</div>

<fieldset>

	<legend class="screen-reader-text"><?php $L->p( 'Comments Options' ); ?></legend>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="post_types"><?php $L->p( 'Post Types' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="post_types" name="post_types">
				<option value="post" <?php echo ( $this->getValue( 'post_types' ) === 'post' ? 'selected' : '' ); ?>><?php $L->p( 'Posts' ); ?></option>
				<option value="page" <?php echo ( $this->getValue( 'post_types' ) === 'page' ? 'selected' : '' ); ?>><?php $L->p( 'Pages' ); ?></option>
				<option value="both" <?php echo ( $this->getValue( 'post_types' ) === 'both' ? 'selected' : '' ); ?>><?php $L->p( 'Posts & Pages' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'The post types that should display comments. Posts include sticky content.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="logged_form"><?php $L->p( 'Form Visibility' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="logged_form" name="logged_form">
				<option value="true" <?php echo ( $this->getValue( 'logged_form' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Logged In' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'logged_form' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'All Users' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Whether the comment form should be displayed only to logged in users.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="logged_name"><?php $L->p( 'Logged-In Name' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="logged_name" name="logged_name">
				<option value="true" <?php echo ( $this->getValue( 'logged_name' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Registered Name' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'logged_name' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Any Name' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Force logged-in users to use their display name.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="logged_email"><?php $L->p( 'Logged-In Email' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="logged_email" name="logged_email">
				<option value="true" <?php echo ( $this->getValue( 'logged_email' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Registered Email' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'logged_email' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Any Email' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Force logged-in users to use their registered email.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="accept_terms"><?php $L->p( 'Accept Terms' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="accept_terms" name="accept_terms">
				<option value="true" <?php echo ( $this->getValue( 'accept_terms' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'accept_terms' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disable' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Require users to accept the terms of commenting before submitting the form.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="logged_comments"><?php $L->p( 'Comments Visibility' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="logged_comments" name="logged_comments">
				<option value="true" <?php echo ( $this->getValue( 'logged_comments' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Logged In' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'logged_comments' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'All Users' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Whether the comments should be displayed only to logged in users.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="form_location"><?php $L->p( 'Form Location' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="form_location" name="form_location">
				<option value="before" <?php echo ( $this->getValue( 'form_location' ) === 'before' ? 'selected' : '' ); ?>><?php $L->p( 'Before Comments' ); ?></option>
				<option value="after" <?php echo ( $this->getValue( 'form_location' ) === 'after' ? 'selected' : '' ); ?>><?php $L->p( 'After Comments' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Where the comment form should be displayed when used with the comments loop.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="form_heading"><?php $L->p( 'Form Heading' ); ?></label>
		<div class="col-sm-10">
			<input type="text" id="form_heading" name="form_heading" value="<?php echo $this->getValue( 'form_heading' ); ?>" placeholder="<?php echo $this->dbFields['form_heading']; ?>" />
			<small class="form-text"><?php $L->p( 'The text to display above the comment form.' ); ?><br /><?php $L->p( 'Use <code class="select">{{post-name}}</code> as a place holder for the post or page title.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="form_heading_el"><?php $L->p( 'Form Heading Element' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="form_heading_el" name="form_heading_el">
				<option value="h2" <?php echo ( $this->getValue( 'form_heading_el' ) === 'h2' ? 'selected' : '' ); ?>><?php $L->p( 'H2' ); ?></option>
				<option value="h3" <?php echo ( $this->getValue( 'form_heading_el' ) === 'h3' ? 'selected' : '' ); ?>><?php $L->p( 'H3' ); ?></option>
				<option value="h4" <?php echo ( $this->getValue( 'form_heading_el' ) === 'h4' ? 'selected' : '' ); ?>><?php $L->p( 'H4' ); ?></option>
				<option value="p" <?php echo ( $this->getValue( 'form_heading_el' ) === 'p' ? 'selected' : '' ); ?>><?php $L->p( 'P' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'The HTML element to wrap the heading text.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="loop_heading"><?php $L->p( 'Loop Heading' ); ?></label>
		<div class="col-sm-10">
			<input type="text" id="loop_heading" name="loop_heading" value="<?php echo $this->getValue( 'loop_heading' ); ?>" placeholder="<?php echo $this->dbFields['loop_heading']; ?>" />
			<small class="form-text"><?php $L->p( 'The text to display above the comments loop.' ); ?>
			<br /><?php $L->p( 'Use <code class="select">{{count}}</code> as a place holder for the approved comments & replies count.' ); ?>
			<br /><?php $L->p( 'Use <code class="select">{{maybe-s}}</code> to print the letter s if the comment count is not one (1).' ); ?>
			<br /><?php $L->p( 'Use <code class="select">{{post-name}}</code> as a place holder for the post or page title ( e.g. User Discussion on {{post-name}} ).' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="loop_heading_el"><?php $L->p( 'Loop Heading Element' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="loop_heading_el" name="loop_heading_el">
				<option value="h2" <?php echo ( $this->getValue( 'loop_heading_el' ) === 'h2' ? 'selected' : '' ); ?>><?php $L->p( 'H2' ); ?></option>
				<option value="h3" <?php echo ( $this->getValue( 'loop_heading_el' ) === 'h3' ? 'selected' : '' ); ?>><?php $L->p( 'H3' ); ?></option>
				<option value="h4" <?php echo ( $this->getValue( 'loop_heading_el' ) === 'h4' ? 'selected' : '' ); ?>><?php $L->p( 'H4' ); ?></option>
				<option value="p" <?php echo ( $this->getValue( 'loop_heading_el' ) === 'p' ? 'selected' : '' ); ?>><?php $L->p( 'P' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'The HTML element to wrap the heading text.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="dashboard_log"><?php $L->p( 'Dashboard Log' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="dashboard_log" name="dashboard_log">
				<option value="true" <?php echo ( $this->getValue( 'dashboard_log' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enable' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'dashboard_log' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disable' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Show a comments activity log on the dashboard. Admins only.' ); ?></small>
		</div>
	</div>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="admin_email"><?php $L->p( 'Admin Email' ); ?></label>
		<div class="col-sm-10">
			<input type="email" id="admin_email" name="admin_email" value="<?php echo $this->getValue( 'admin_email' ); ?>" placeholder="email@example.com" />
			<small class="form-text"><?php $L->p( 'The email address for notification of new comments. Leave blank for no emails.' ); ?></small>
		</div>
	</div>
</fieldset>
