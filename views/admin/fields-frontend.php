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
<h2 class="form-heading"><?php sn_e( 'Frontend Settings' ); ?></h2>

<div class="form-group row">
	<label for="filter" class="col-sm-2 col-form-label"><?php sn_e( 'Theme Hook' ); ?></label>
	<div class="col-sm-10">
		<select id="filter" name="frontend_filter" class="form-select">

			<option value="disabled" <?php sn_selected( 'frontend_filter', 'disabled' ); ?>><?php sn_e( 'No Hook' ); ?></option>

			<?php
			// Custom hook from this plugin.
			if ( $theme_compat ) : ?>
			<option value="comments_full" <?php sn_selected( 'frontend_filter', 'comments_full' ); ?>><?php sn_e( "Use 'comments_full'" ); ?></option>
			<?php endif; ?>

			<option value="pageBegin" <?php sn_selected( 'frontend_filter', 'pageBegin' ); ?>><?php sn_e( "Use 'pageBegin'" ); ?></option>

			<option value="pageEnd" <?php sn_selected( 'frontend_filter', 'pageEnd' ); ?>><?php sn_e( "Use 'pageEnd'" ); ?></option>

			<option value="siteBodyBegin" <?php sn_selected( 'frontend_filter', 'siteBodyBegin' ); ?>><?php sn_e( "Use 'siteBodyBegin'" ); ?></option>

			<option value="siteBodyEnd" <?php sn_selected( 'frontend_filter', 'siteBodyEnd' ); ?>><?php sn_e( "Use 'siteBodyEnd'" ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="captcha" class="col-sm-2 col-form-label"><?php sn_e( 'Comment Captcha' ); ?></label>
	<div class="col-sm-10">
		<select id="captcha" name="frontend_captcha" class="form-select">
			<option value="disabled" <?php sn_selected( 'frontend_captcha', 'disabled' ); ?>><?php sn_e( 'Disable Captcha' ); ?></option>
			<option value="purecaptcha" <?php sn_selected( 'frontend_captcha', 'purecaptcha' ); ?>><?php sn_e( 'Use OWASP\'s PureCaptcha' ); ?></option>
			<?php if (function_exists( 'imagettfbbox' )) { ?>
				<option value="gregwar" <?php sn_selected( 'frontend_captcha', 'gregwar' ); ?>><?php sn_e( 'Use Gregway\'s Captcha' ); ?></option>
			<?php } else { ?>
				<option disabled="disabled"><?php sn_e( 'Use Gregway\'s Captcha (GD library is missing!)' ); ?></option>
			<?php } ?>
			<option value="recaptcha" <?php sn_selected( 'frontend_captcha', 'recaptcha' ); ?> disabled="disabled"><?php sn_e( 'Use Googles reCaptcha (Not available yet)' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="template" class="col-sm-2 col-form-label"><?php sn_e( 'Comments Theme' ); ?></label>
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
	<label for="order" class="col-sm-2 col-form-label"><?php sn_e( 'Comment Order' ); ?></label>
	<div class="col-sm-10">
		<select id="order" name="frontend_order" class="form-select">
			<option value="date_desc" <?php sn_selected( 'frontend_order", "date_desc' ); ?>><?php sn_e( 'Newest Comments First' ); ?></option>
			<option value="date_asc" <?php sn_selected( 'frontend_order", "date_asc' ); ?>><?php sn_e( 'Oldest Comments First' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="order" class="col-sm-2 col-form-label"><?php sn_e( 'Comment Form Position' ); ?></label>
	<div class="col-sm-10">
		<select id="order" name="frontend_form" class="form-select">
			<option value="top" <?php sn_selected( 'frontend_form", "top' ); ?>><?php sn_e( 'Show Comment Form above Comments' ); ?></option>
			<option value="bottom" <?php sn_selected( 'frontend_form", "bottom' ); ?>><?php sn_e( 'Show Comment Form below Comments' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="per-page" class="col-sm-2 col-form-label"><?php sn_e( 'Comments Per Page' ); ?></label>
	<div class="col-sm-10">
		<input type="number" id="per-page" name="frontend_per_page" value="<?php echo sn_config( 'frontend_per_page' ); ?>"
				class="form-control" min="0" step="1" placheolder="<?php sn_e( 'Use 0 to show all available comments!' ); ?>" />
		<small class="form-text text-muted"><?php sn_e( 'Use 0 to show all available comments!' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="terms" class="col-sm-2 col-form-label"><?php sn_e( 'Terms of Use Checkbox' ); ?></label>
	<div class="col-sm-10">
		<select id="terms" name="frontend_terms" class="form-select">
			<option value="disabled" <?php sn_selected( 'frontend_terms", "disabled' ); ?>><?php sn_e( 'Disabled' ); ?></option>
			<option value="default" <?php sn_selected( 'frontend_terms", "default' ); ?>><?php sn_e( 'Show Message (See Strings)' ); ?></option>

			<?php foreach ($static as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php sn_selected( 'frontend_terms', $key ); ?>><?php sn_e( 'Page' ); ?>: <?php echo $value["title"]; ?></option>
			<?php } ?>
		</select>
		<small class="form-text text-muted"><?php sn_e( 'Show the default GDPR Text or Select your own static terms of use page' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="ajax" class="col-sm-2 col-form-label"><?php sn_e( 'AJAX Script' ); ?></label>
	<div class="col-sm-10">
		<select id="ajax" name="frontend_ajax" class="form-select">
			<option value="true" <?php sn_selected( 'frontend_ajax', true ); ?>><?php sn_e( 'Embed AJAX Script' ); ?></option>
			<option value="false" <?php sn_selected( 'frontend_ajax', false ); ?>><?php sn_e( 'Don\'t use AJAX' ); ?></option>
		</select>
		<small class="form-text text-muted"><?php sn_e( 'The AJAX Script hands over the request (comment, like, dislike) directly without reloading the page.' ); ?></small>
	</div>
</div>

<div class="form-group row">
	<label for="avatar" class="col-sm-2 col-form-label"><?php sn_e( 'Default Avatar' ); ?></label>
	<div class="col-sm-10">
		<select id="avatar" name="frontend_avatar" class="form-select">
			<option value="static" <?php sn_selected( 'frontend_avatar', 'static' ); ?>><?php sn_e( 'Mystery Men' ); ?></option>
			<option value="none" <?php sn_selected( 'frontend_avatar', 'none' ); ?>><?php sn_e( 'No Avatar' ); ?></option>
		</select>

		<div class="custom-control custom-checkbox mt-1">
			<input type="checkbox" id="moderation-users" name="frontend_avatar_users" value="true"
					class="custom-control-input" <?php sn_checked( 'frontend_avatar_users' ); ?> />
			<label class="custom-control-label" for="moderation-users"><?php sn_e( 'Use & Prefer profile pictures on logged-in Users' ); ?></label>
		</div>
	</div>
</div>
