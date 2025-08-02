<?php
/**
 * Post Comments options page
 *
 * @package    Post Comments
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

?>
<p class="page-description"><?php lang()->p( 'Settings and text options for the comments system.' ); ?></p>

<nav id="nav-tabs">
	<ul class="nav nav-tabs" id="nav-tab" role="tablist">
		<li class="nav-item">
			<a id="nav-general-tab" href="#general" class="nav-link active" data-toggle="tab" role="tab" aria-controls="nav-general" aria-selected="false">
				<?php lang()->p( 'General' ); ?>
			</a>
		</li>
		<li class="nav-item">
			<a id="nav-frontend-tab" href="#frontend" class="nav-link" data-toggle="tab" role="tab" aria-controls="nav-frontend" aria-selected="false">
				<?php lang()->p( 'Frontend' ); ?>
			</a>
		</li>
		<li class="nav-item">
			<a id="nav-text-tab" href="#text" class="nav-link" data-toggle="tab" role="tab" aria-controls="nav-text" aria-selected="false">
				<?php lang()->p( 'Text' ); ?>
			</a>
		</li>
	</ul>
</nav>

<div id="tab-content" class="tab-content">
	<div id="general" class="tab-pane fade show active" role="tabpanel" aria-labelledby="general-tab">
		<?php include( $this->phpPath() . '/views/admin/fields-general.php' ); ?>
	</div>
	<div id="frontend" class="tab-pane fade" role="tabpanel" aria-labelledby="frontend-tab">
		<?php include( $this->phpPath() . '/views/admin/fields-frontend.php' ); ?>
	</div>
	<div id="text" class="tab-pane fade" role="tabpanel" aria-labelledby="text-tab">
		<?php include( $this->phpPath() . '/views/admin/fields-text.php' ); ?>
	</div>
</div>

<script>
	// Open current tab after refresh page
	$(function() {
		$('a[data-toggle="tab"]').on('click', function(e) {
			window.localStorage.setItem('activeTab', $(e.target).attr('href'));
		});
		var activeTab = window.localStorage.getItem('activeTab');
		if (activeTab) {
			$('#nav-tabs a[href="' + activeTab + '"]').tab('show');
			//window.localStorage.removeItem("activeTab");
		}
	});
</script>
