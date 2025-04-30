<?php
/**
 * Dashboard log
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

if ( isset( $_POST['delete_log'] ) && file_exists( comments_log_path() ) ) {
	unlink( comments_log_path() );
};

?>
<style>
#comments-log-list {
	list-style: none;
	margin: 1rem 0;
}
#comments-log-list li {
	margin-top: 1rem;
}
.comments-log-date-time {
	display: block;
	font-size: 0.8125em;
}
</style>

<h2><?php $L->p( 'Comments Activity' ); ?></h2>

<form class="plugin-form" method="post" action="" enctype="" autocomplete="off">
	<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $sec_token; ?>">

	<?php echo comments_log(); ?>
	<p>
		<input id="delete_log" type="submit" name="delete_log" class="button btn" value="<?php echo $L->get( 'Clear Log' ); ?>"<?php echo ( ! file_exists( $log_path ) ? 'disabled' : '' ); ?> />
	</p>
</form>

<script>
$( function() {
	$( '#delete_log' ).bind( 'click', function() {
		if ( ! confirm( '<?php $L->p( 'Are you sure you want to clear the comments activity log?' ); ?>' ) ) {
			return false;
		}
	});
});
</script>
