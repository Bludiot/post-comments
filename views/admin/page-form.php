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
<nav id="nav-tabs">
	<ul class="nav nav-tabs" data-handle="tabs">
		<li class="nav-item">
			<a id="general-tab" href="#general" class="nav-link active" data-toggle="tab">
				<?php sn_e( 'General' ); ?>
			</a>
		</li>
		<li class="nav-item">
			<a id="frontend-tab" href="#frontend" class="nav-link" data-toggle="tab">
				<?php sn_e( 'Frontend' ); ?>
			</a>
		</li>
		<li class="nav-item">
			<a id="text-tab" href="#text" class="nav-link" data-toggle="tab">
				<?php sn_e( 'Text' ); ?>
			</a>
		</li>
	</ul>
</nav>

<div class="tab-content">
	<div id="general" class="tab-pane active">
		<?php include( $this->phpPath() . '/views/admin/fields-general.php' ); ?>
	</div>
	<div id="frontend" class="tab-pane">
		<?php include( $this->phpPath() . '/views/admin/fields-frontend.php' ); ?>
	</div>
	<div id="text" class="tab-pane">
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
