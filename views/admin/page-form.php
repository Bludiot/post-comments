<?php
/**
 * Post Comments options page
 *
 * @package    Post Comments
 * @subpackage Views
 * @since      1.0.0
 */

?>
<nav>
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
			<a id="email-tab" href="#email" class="nav-link" data-toggle="tab">
				<?php sn_e( 'Email' ); ?>
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
	<div id="general" class="tab-pane active">General Settings</div>
	<div id="frontend" class="tab-pane">Frontend Settings</div>
	<div id="email" class="tab-pane">Email Settings</div>
	<div id="text" class="tab-pane">Text Settings</div>
</div>

<?php include( $this->phpPath() . '/views/admin/settings.php' ); ?>
