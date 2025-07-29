<?php
/*
 |  Snicker Plus - A FlatFile Comment Plugin for Bludit
 |  @file       ./admin/index-comments.php
 |  @author     Steve Harris (Harris Lineage)
 |  @version    1.0.0
 |  @website    https://github.com/harrislineage/snicker-plus
 |  @license    MIT License
 |  @copyright  Copyright © 2025 Steve Harris (Harris Lineage)
 */

if (!defined('BLUDIT')) {
	die('Access denied');
}

global $pages, $security, $post_comments, $SnickerIndex, $SnickerPlugin, $SnickerUsers;

// Get Data
$limit = $SnickerPlugin->getValue("frontend_per_page");
if ($limit === 0) {
	$limit = 15;
}
$current = isset($_GET["tab"]) ? $_GET["tab"] : "pending";

// Get View
$view = "index";
if (isset($_GET["view"]) && in_array($_GET["view"], array("search", "single", "uuid", "user"))) {
	$view = $current = $_GET["view"];
	$tabs = array($view);
} else {
	$tabs = array("pending", "approved", "rejected", "spam");
}

// Render Comments Tab
foreach ($tabs as $status) {
	if (isset($_GET["tab"]) && $_GET["tab"] === $status) {
		$page = max((isset($_GET["page"]) ? (int) $_GET["page"] : 1), 1);
	} else {
		$page = 1;
	}

	// Get Comments
	if ($view === "index") {
		$comments = $SnickerIndex->getList($status, $page, $limit);
		$total = $SnickerIndex->count($status);
	} else if ($view === "search") {
		$comments = $SnickerIndex->searchComments(isset($_GET["search"]) ? $_GET["search"] : "");
		$total = count($comments);
	} else if ($view === "single") {
		$comments = $SnickerIndex->getListByParent(isset($_GET["single"]) ? $_GET["single"] : "");
		$total = count($comments);
	} else if ($view === "uuid") {
		$comments = $SnickerIndex->getListByUUID(isset($_GET["uuid"]) ? $_GET["uuid"] : "");
		$total = count($comments);
	} else if ($view === "user") {
		$comments = $SnickerIndex->getListByUser(isset($_GET["user"]) ? $_GET["user"] : "");
		$total = count($comments);
	}

	// Render Tab Content
	$link = DOMAIN_ADMIN . "snicker?page=%d&tab={$status}#{$status}";

	?>
	<div id="snicker-<?php echo $status; ?>" class="tab-pane <?php echo ($current === $status) ? "active" : ""; ?>">
		<div class="card shadow-sm" style="margin: 1.5rem 0;">
			<div class="card-body">
				<div class="row">
					<form class="pr-4 pl-4 w-100" method="get" action="<?php echo DOMAIN_ADMIN; ?>snicker">
						<div class="form-row align-items-center">
							<div class="w-100 row flex-nowrap">
								<?php $search = isset($_GET["search"]) ? $_GET["search"] : ""; ?>
								<input type="text" name="search" value="<?php echo $search; ?>" class="form-control" placeholder="<?php sn_e("Comment Title or Excerpt"); ?>" />
								<button class="btn btn-primary" name="view" value="search"><?php sn_e("Search"); ?></button>
							</div>
						</div>
					</form>

					<div class="col-sm-6 text-right">
						<?php if ($total > $limit) { ?>
							<div class="btn-group btn-group-pagination">
								<?php if ($page <= 1) { ?>
									<span class="btn btn-secondary disabled">&laquo;</span>
									<span class="btn btn-secondary disabled">&lsaquo;</span>
								<?php } else { ?>
									<a href="<?php printf($link, 1); ?>" class="btn btn-secondary">&laquo;</a>
									<a href="<?php printf($link, $page - 1); ?>" class="btn btn-secondary">&lsaquo;</a>
								<?php } ?>
								<?php if (($page * $limit) < $total) { ?>
									<a href="<?php printf($link, $page + 1); ?>" class="btn btn-secondary">&rsaquo;</a>
									<a href="<?php printf($link, ceil($total / $limit)); ?>" class="btn btn-secondary">&raquo;</a>
								<?php } else { ?>
									<span class="btn btn-secondary disabled">&rsaquo;</span>
									<span class="btn btn-secondary disabled">&raquo;</span>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<?php /* No Comments available */ ?>
		<?php if (count($comments) < 1) { ?>
			<div class="row justify-content-md-center">
				<div class="col-sm-6">
					<div class="card w-100 shadow-sm bg-light">
						<div class="card-body text-center p-4"><i><?php sn_e("No Comments Available"); ?></i></div>
					</div>
				</div>
			</div>
		</div>
		<?php continue; ?>
	<?php } ?>

	<?php /* Comments Table */ ?>
	<?php $link = DOMAIN_ADMIN . "snicker?action=snicker&snicker=%s&uid=%s&status=%s&tokenCSRF=" . $security->getTokenCSRF(); ?>
	<table class="table table-bordered table-hover-light shadow-sm mt-3">
		<?php foreach (array("thead", "tfoot") as $tag) { ?>
			<<?php echo $tag; ?>>
				<tr class="thead-light">
					<th width="56%" class="border-0 p-3 text-uppercase text-muted"><?php sn_e("Comment"); ?></th>
					<th width="22%" class="border-0 p-3 text-uppercase text-muted text-center"><?php sn_e("Author"); ?></th>
					<th width="22%" class="border-0 p-3 text-uppercase text-muted text-center"><?php sn_e("Actions"); ?></th>
				</tr>
			</<?php echo $tag; ?>>
		<?php } ?>
		<tbody class="shadow-sm-both">
			<?php foreach ($comments as $uid) { ?>
				<?php
				$data = $SnickerIndex->getComment($uid, $status);
				if (!(isset($data["page_uuid"]) && is_string($data["page_uuid"]))) {
					continue;
				}
				$page = new Page($pages->getByUUID($data["page_uuid"]));
				$user = $SnickerUsers->getByString($data["author"]);
				?>
				<tr>
					<td class="">
						<?php
						if ($SnickerPlugin->getValue("comment_title") !== "disabled" && !empty($data["title"])) {
							echo '<b class="d-inline-block">' . $data["title"] . '</b>';
						}
						echo '<p class="text-muted m-0" style="font-size:12px;">' . (isset($data["excerpt"]) ? $data["excerpt"] : "") . '</p>';
						if (!empty($data["parent_uid"]) && $SnickerIndex->exists($data["parent_uid"]) && $view !== "single") {
							$reply = DOMAIN_ADMIN . "snicker?view=single&single={$uid}";
							$reply = '<a href="' . $reply . '" title="' . sn__("Show all replies") . '">' . $SnickerIndex->getComment($data["parent_uid"])["title"] . '</a>';
							echo "<div class='text-muted mt-1' style='font-size:12px;'>" . sn__("Reply To") . ": " . $reply . "</div>";
						}
						?>
					</td>
					<td class="">
						<span class="d-inline-block"><?php echo $user["username"]; ?></span>
						<small class='d-block'><?php echo $user["email"]; ?></small>
					</td>
					<td class="">
						<div class="comment-actions" style="position: relative;">
							<button class="dropdown-toggle button btn btn-sm" data-toggle="dropdown">
								<?php sn_e("Manage"); ?>
							</button>
							<ul class="dropdown-menu mr-0">
								<li>
									<a class="dropdown-item text-primary" href="<?php echo DOMAIN_ADMIN . "snicker/edit/?uid=" . $uid; ?>"><?php sn_e("Edit Comment"); ?></a>
								</li>
								<?php if ($status !== "pending") { ?>
								<li>
									<a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "pending"); ?>"><?php sn_e("Mark as Pending"); ?></a>
								</li>
								<?php } ?>

								<?php if ($status !== "approved") { ?>
								<li>
									<a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "approved"); ?>"><?php sn_e("Approve Comment"); ?></a>
								</li>
								<?php } ?>
								<?php if ($status !== "rejected") { ?>
								<li>
									<a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "rejected"); ?>"><?php sn_e("Reject Comment"); ?></a>
								</li>
								<?php } ?>
								<?php if ($status !== "spam") { ?>
								<li>
									<a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "spam"); ?>"><?php sn_e("Mark as Spam"); ?></a>
								</li>
								<?php } ?>
								<?php if ($status !== "pending") { ?>
								<li>
									<a class="dropdown-item" href="<?php echo $page->permalink(); ?>#comment-<?php echo $uid; ?>" target="_blank" rel="noopener noreferrer"><?php sn_e("View in Page"); ?></a>
								</li>
								<li>
									<a class="dropdown-item text-danger" href="<?php printf($link, "delete", $uid, "delete"); ?>"><?php sn_e("Delete Comment"); ?></a>
								</li>
								<?php } ?>
							</ul>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
	<?php
}
