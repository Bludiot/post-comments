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

<h1><?php $L->p( 'Post Comments Guide' ); ?></h1>

<div class="alert alert-primary alert-post-comments" role="alert">
	<p class="m-0"><?php $L->p( "Go to the <a href='{$settings_page}'>comments options</a> page." ); ?></p>
</div>

<pre>
"disable_comments": {
	"type"  : "bool",
	"label" : "Disable Comments",
	"tip"   : "Close comments for this content."
}
</pre>
