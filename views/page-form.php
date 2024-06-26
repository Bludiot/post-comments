<?php
/**
 * Comments options page
 *
 * @package    Post Comments
 * @subpackage Views
 * @since      1.0.0
 */

// Get array of pages in the database.
global $pages;
$get_pages = $pages->getDB();

?>
<div class="alert alert-primary alert-search-forms" role="alert">
	<p class="m-0"><?php $L->p( 'Options for the post comments form and for the loop/list.' ); ?></p>
</div>

<fieldset>

	<legend class="screen-reader-text"><?php $L->p( 'Comments Options' ); ?></legend>

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="user_level"><?php $L->p( 'User Level' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="user_level" name="user_level">
				<option value="admin" <?php echo ( $this->getValue( 'user_level' ) === 'admin' ? 'selected' : '' ); ?>><?php $L->p( 'Administrator' ); ?></option>
				<option value="editor" <?php echo ( $this->getValue( 'user_level' ) === 'editor' ? 'selected' : '' ); ?>><?php $L->p( 'Editor' ); ?></option>
				<option value="author" <?php echo ( $this->getValue( 'user_level' ) === 'author' ? 'selected' : '' ); ?>><?php $L->p( 'Author' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'The minimum user level for managing comments. If Author is selected then the author will only be able to manage their own content.' ); ?></small>
		</div>
	</div>

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
		<label class="form-label col-sm-2 col-form-label" for="accept_terms"><?php $L->p( 'Accept Terms' ); ?></label>
		<div class="col-sm-10">
			<select class="form-select" id="accept_terms" name="accept_terms">
				<option value="true" <?php echo ( $this->getValue( 'accept_terms' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'accept_terms' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
			</select>
			<small class="form-text"><?php $L->p( 'Require users to accept the terms of commenting before submitting the form.' ); ?></small>
		</div>
	</div>

	<div id="terms-options" style="display: <?php echo ( $this->accept_terms() == true ? 'block' : 'none' ); ?>;">
		<div class="form-field form-group row">
			<label for="terms_page" class="col-sm-2 col-form-label"><?php $L->p( 'Terms Page' ); ?></label>
			<div class="col-sm-10">
				<select id="terms_page" name="terms_page" class="form-select">

					<option value="" <?php echo ( empty( $this->terms_page() ) ? 'selected' : '' ); ?>><?php $L->p( 'None' ); ?></option>

					<?php
					// Static page options.
					foreach ( $get_pages as $key ) {

						$page = new \Page( $key );
						if ( ! $page->isStatic() ) {
							continue;
						}
						printf(
							'<option value="%s" %s>%s</option>',
							$page->key(),
							( $page->key() == $this->terms_page() ? 'selected' : '' ),
							$page->title()
						);
					} ?>
				</select>
				<small class="form-text text-muted"><?php $L->p( 'Select a static page that contains the terms of commenting, privacy policy, etc.' ); ?></small>
			</div>
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
				<option value="true" <?php echo ( $this->getValue( 'dashboard_log' ) === true ? 'selected' : '' ); ?>><?php $L->p( 'Enabled' ); ?></option>
				<option value="false" <?php echo ( $this->getValue( 'dashboard_log' ) === false ? 'selected' : '' ); ?>><?php $L->p( 'Disabled' ); ?></option>
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

<script>
jQuery(document).ready( function($) {
	$( '#accept_terms' ).on( 'change', function() {
    	var show = $(this).val();
		if ( show == 'true' ) {
			$( "#terms-options" ).fadeIn( 250 );
		} else if ( show == 'false' ) {
			$( "#terms-options" ).fadeOut( 250 );
		}
    });
});
</script>
