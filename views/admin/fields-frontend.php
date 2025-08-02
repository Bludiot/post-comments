<?php
/**
 * Frontend settings tab
 *
 * @package    Post Comments
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

// Access global variables.
global $comments_core, $pages;

/**
 * Theme compatibility in active theme's metadata file.
 *
 * Looks for `"comments" : true` in the JSON file.
 * Intended to indicate that the theme uses the
 * `comments_full` hook established by this plugin.
 */
$themes = buildThemes();
$theme_compat = false;
foreach ( $themes as $theme ) {
	if ( $theme['dirname'] != $site->theme() ) {
		continue;
	}
	if ( isset( $theme['comments'] ) ) {
		if ( true === $theme['comments'] ) {
			$theme_compat = true;
		}
	}
}

// Get static pages.
$static = $pages->getStaticDB( false );

?>
<h2 class="form-heading"><?php lang()->p( 'Frontend Settings' ); ?></h2>

<div class="form-group row">
	<label for="filter" class="col-sm-2 col-form-label"><?php lang()->p( 'Theme Hook' ); ?></label>
	<div class="col-sm-10">
		<select id="filter" name="frontend_filter" class="form-select">

			<option value="disabled" <?php sn_selected( 'frontend_filter', 'disabled' ); ?>><?php lang()->p( 'No Hook' ); ?></option>

			<?php
			// Custom hook from this plugin.
			if ( $theme_compat ) : ?>
			<option value="comments_full" <?php sn_selected( 'frontend_filter', 'comments_full' ); ?>><?php lang()->p( "Use 'comments_full'" ); ?></option>
			<?php endif; ?>

			<option value="pageBegin" <?php sn_selected( 'frontend_filter', 'pageBegin' ); ?>><?php lang()->p( "Use 'pageBegin'" ); ?></option>

			<option value="pageEnd" <?php sn_selected( 'frontend_filter', 'pageEnd' ); ?>><?php lang()->p( "Use 'pageEnd'" ); ?></option>

			<option value="siteBodyBegin" <?php sn_selected( 'frontend_filter', 'siteBodyBegin' ); ?>><?php lang()->p( "Use 'siteBodyBegin'" ); ?></option>

			<option value="siteBodyEnd" <?php sn_selected( 'frontend_filter', 'siteBodyEnd' ); ?>><?php lang()->p( "Use 'siteBodyEnd'" ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="captcha" class="col-sm-2 col-form-label"><?php lang()->p( 'Comment Captcha' ); ?></label>
	<div class="col-sm-10">
		<select id="captcha" name="frontend_captcha" class="form-select">
			<option value="disabled" <?php sn_selected( 'frontend_captcha', 'disabled' ); ?>><?php lang()->p( 'Disable Captcha' ); ?></option>
			<option value="purecaptcha" <?php sn_selected( 'frontend_captcha', 'purecaptcha' ); ?>><?php lang()->p( 'Use OWASP\'s PureCaptcha' ); ?></option>
			<?php if (function_exists( 'imagettfbbox' )) { ?>
				<option value="gregwar" <?php sn_selected( 'frontend_captcha', 'gregwar' ); ?>><?php lang()->p( 'Use Gregwar\'s Captcha' ); ?></option>
			<?php } else { ?>
				<option disabled="disabled"><?php lang()->p( 'Use Gregwar\'s Captcha (GD library is missing)' ); ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="template" class="col-sm-2 col-form-label"><?php lang()->p( 'Comments Theme' ); ?></label>
	<div class="col-sm-10">
		<select id="template" name="frontend_template" class="form-select">
			<?php
			foreach ($comments_core->themes as $key => $theme) {
				?>
				<option value="<?php echo $key; ?>" <?php sn_selected( 'frontend_template', $key ); ?>><?php echo $theme->theme_name; ?></option>
				<?php
			}
			?>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="order" class="col-sm-2 col-form-label"><?php lang()->p( 'Comment Order' ); ?></label>
	<div class="col-sm-10">
		<select id="order" name="frontend_order" class="form-select">
			<option value="date_desc" <?php sn_selected( 'frontend_order", "date_desc' ); ?>><?php lang()->p( 'Newest Comments First' ); ?></option>
			<option value="date_asc" <?php sn_selected( 'frontend_order", "date_asc' ); ?>><?php lang()->p( 'Oldest Comments First' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="order" class="col-sm-2 col-form-label"><?php lang()->p( 'Comment Form Position' ); ?></label>
	<div class="col-sm-10">
		<select id="order" name="frontend_form" class="form-select">
			<option value="top" <?php sn_selected( 'frontend_form", "top' ); ?>><?php lang()->p( 'Show Comment Form above Comments' ); ?></option>
			<option value="bottom" <?php sn_selected( 'frontend_form", "bottom' ); ?>><?php lang()->p( 'Show Comment Form below Comments' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="per-page" class="col-sm-2 col-form-label"><?php lang()->p( 'Comments Per Page' ); ?></label>
	<div class="col-sm-10">
		<input type="number" id="per-page" name="frontend_per_page" value="<?php echo sn_config( 'frontend_per_page' ); ?>"
				class="form-control" min="0" step="1" placheolder="<?php lang()->p( 'Use 0 to show all available comments!' ); ?>" />
		<small class="form-text text-muted"><?php lang()->p( 'Use 0 to show all available comments!' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="terms" class="col-sm-2 col-form-label"><?php lang()->p( 'Terms of Use Checkbox' ); ?></label>
	<div class="col-sm-10">
		<select id="terms" name="frontend_terms" class="form-select">
			<option value="disabled" <?php sn_selected( 'frontend_terms", "disabled' ); ?>><?php lang()->p( 'Disabled' ); ?></option>
			<option value="default" <?php sn_selected( 'frontend_terms", "default' ); ?>><?php lang()->p( 'Show Message (See Strings)' ); ?></option>

			<?php foreach ($static as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php sn_selected( 'frontend_terms', $key ); ?>><?php lang()->p( 'Page' ); ?>: <?php echo $value["title"]; ?></option>
			<?php } ?>
		</select>
		<small class="form-text text-muted"><?php lang()->p( 'Show the default GDPR Text or Select your own static terms of use page' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="ajax" class="col-sm-2 col-form-label"><?php lang()->p( 'AJAX Script' ); ?></label>
	<div class="col-sm-10">
		<select id="ajax" name="frontend_ajax" class="form-select">
			<option value="true" <?php sn_selected( 'frontend_ajax', true ); ?>><?php lang()->p( 'Embed AJAX Script' ); ?></option>
			<option value="false" <?php sn_selected( 'frontend_ajax', false ); ?>><?php lang()->p( 'Don\'t use AJAX' ); ?></option>
		</select>
		<small class="form-text text-muted"><?php lang()->p( 'The AJAX Script hands over the request (comment, like, dislike) directly without reloading the page.' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="avatar" class="col-sm-2 col-form-label"><?php lang()->p( 'Default Avatar' ); ?></label>
	<div class="col-sm-10">
		<select id="avatar" name="frontend_avatar" class="form-select">
			<option value="mystery" <?php sn_selected( 'frontend_avatar', 'mystery' ); ?>><?php lang()->p( 'Mystery Men' ); ?></option>
			<option value="none" <?php sn_selected( 'frontend_avatar', 'none' ); ?>><?php lang()->p( 'No Avatar' ); ?></option>
		</select>
	</div>
</div>
