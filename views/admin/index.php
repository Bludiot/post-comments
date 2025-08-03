<?php
/**
 * Comments page for tabbed content
 *
 * @package    Post Comments
 * @subpackage Views
 * @category   Pages
 * @since      1.0.0
 */

// Stop if accessed directly.
if ( ! defined( 'BLUDIT' ) ) {
	die( 'You are not allowed direct access to this file.' );
}

global $L, $comments_core;

// Pending Counter
$count = count($comments_core->getIndex("pending"));
$count = ($count > 99) ? "99+" : $count;
$spam = count($comments_core->getIndex("spam"));

// Tab Strings
$strings = array(
	"pending" => sn__("Pending"),
	"approved" => sn__("Approved"),
	"rejected" => sn__("Rejected"),
	"spam" => sn__("Spam"),
	"search" => sn__("Search"),
	"single" => sn__("Single Comment"),
	"uuid" => sn__("Page Comments"),
	"user" => sn__("User Comments")
);

// Current Tab
$view = "index";
if (isset($_GET["view"]) && in_array($_GET["view"], array("search", "single", "uuid", "user"))) {
	$view = $current = $_GET["view"];
	$tabs = array($view);
} else {
	$current = isset($_GET["tab"]) ? $_GET["tab"] : "pending";
	$tabs = array("pending", "approved", "rejected", "spam");
}

?>

<div class="align-middle">
	<?php if ( isset( $_GET["search"] ) ) : ?>
	<div class="float-right mt-1">
		<a class="button btn btn-primary btn-sm" href="<?php echo HTML_PATH_ADMIN_ROOT . 'comments' ?>" role="button"><?php $L->p( 'All Comments' ) ?></a>
	</div>
	<?php endif; ?>
	<h1 class="page-title"><span class="page-title-icon fa fa-comments"></span><span class="page-title-text"><?php $L->p( 'Post Comments' ); ?></span></h1>
</div>

<nav>
	<ul class="nav nav-tabs" data-handle="tabs">
		<?php foreach ($tabs as $tab) { ?>
			<?php $class = "nav-link nav-{$tab}" . ($current === $tab ? " active" : ""); ?>
			<li class="nav-item">
				<a id="<?php echo $tab; ?>-tab" href="#comments-<?php echo $tab; ?>" class="nav-link <?php echo $class; ?>" data-toggle="tab">
					<?php echo $strings[$tab]; ?>
				</a>
			</li>
		<?php } ?>
		<li class="nav-item mr-2">
			<a id="users-tab" href="#comments-users" class="nav-link nav-config" data-toggle="tab">
				<?php lang()->p("Users"); ?>
			</a>
		</li>
	</ul>
</nav>

<div class="tab-content">
	<?php
	include "comments.php";
	include "users.php";
	?>
</div>
