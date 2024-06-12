<?php
/**
 * Comments admin page
 *
 * @package    Post Comments
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

// Access namespaced functions.
use function Post_Comments\{
	comments_log_path,
	comments_log
};

$log_path  = comments_log_path();
$sec_token = $security->getTokenCSRF();

// Settings page URL.
$settings_page = DOMAIN_ADMIN . 'configure-plugin/' . $this->className();

// Guide page URL.
$guide_page = DOMAIN_ADMIN . 'plugin/' . $this->className() . '?page=guide';

?>
<style>
#comments-log-list {
	list-style: none;
	margin: 0;
}
#comments-log-list li:not(:first-of-type) {
	margin-top: 1em;
}
.comments-log-date-time {
	display: block;
	font-size: 0.8125em;
}
pre {
	user-select: all;
}
</style>

<h1><?php $L->p( 'Post Comments Log' ); ?></h1>

<div class="alert alert-primary alert-post-comments" role="alert">
	<p class="m-0"><?php $L->p( "Go to the <a href='{$settings_page}'>comments options</a> page." ); ?> <?php $L->p( "Go to the <a href='{$guide_page}'>comments guide</a> page." ); ?></p>
</div>

<form class="plugin-form" method="post" action="" enctype="" autocomplete="off">
	<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $sec_token; ?>">

	<div class="form-field form-group row">
		<label class="form-label col-sm-2 col-form-label" for="profile_pages"><?php $L->p( 'Comments Log' ); ?></label>
		<div class="col-sm-10">
			<?php echo comments_log(); ?>
		</div>
	</div>

	<p>
		<input id="delete_log" type="submit" name="delete_log" class="button btn" value="<?php echo $L->get( 'Clear Log' ); ?>"<?php echo ( ! file_exists( $log_path ) ? 'disabled' : '' ); ?> />
	</p>
</form>

<script>
$( function() {
	$( '#delete_log' ).bind( 'click', function() {
		if ( ! confirm( '<?php $L->p( 'Are you sure you want to clear the comments log?' ); ?>' ) ) {
			return false;
		}
	});
});
</script>
