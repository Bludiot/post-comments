<?php
/**
 * Email settings tab
 *
 * @package    Post Comments
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

?>
<h2 class="form-heading"><?php lang()->p( 'Email Settings' ); ?></h2>

<div class="alert alert-info"><?php lang()->p( 'The Subscription system isn\'t available yet.' ); ?></div>
<div class="form-group row">
	<label for="subscription" class="col-sm-3 col-form-label text-muted"><?php lang()->p( 'Email Subscription' ); ?></label>
	<div class="col-sm-9">
		<select id="subscription" name="subscription" class="form-control custom-select">
			<option value="true" <?php selected( 'subscription', true ); ?>><?php lang()->p( 'Enable' ); ?></option>
			<option value="false" <?php selected( 'subscription', false ); ?>><?php lang()->p( 'Disable' ); ?></option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="subscription-from" class="col-sm-3 col-form-label text-muted"><?php lang()->p( 'Email from address' ); ?></label>
	<div class="col-sm-9">
		<input type="text" id="subscription-from" name="subscription_from" value="<?php echo sn_config( 'subscription_from' ); ?>"
				class="form-control" placeholder="<?php lang()->p( 'Email from address' ); ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="subscription-reply" class="col-sm-3 col-form-label text-muted"><?php lang()->p( 'Email reply to address' ); ?></label>
	<div class="col-sm-9">
		<input type="text" id="subscription-reply" name="subscription_reply" value="<?php echo sn_config( 'subscription_reply' ); ?>"
				class="form-control" placeholder="<?php lang()->p( 'Email reply to address' ); ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="subscription-optin" class="col-sm-3 col-form-label text-muted"><?php lang()->p( 'Email body (Opt-In)' ); ?></label>
	<div class="col-sm-9">
		<select id="subscription-optin" name="subscription_optin" class="form-control custom-select">
			<option value="default" <?php selected( 'subscription_optin', 'default' ); ?>><?php lang()->p( 'Use default subscription email' ); ?></option>
			<?php foreach ($static as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php selected( 'subscription_optin', $key ); ?>><?php lang()->p( 'Page' ); ?>: <?php echo $value["title"]; ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="subscription-ticker" class="col-sm-3 col-form-label text-muted"><?php lang()->p( 'Email body (notification)' ); ?></label>
	<div class="col-sm-9">
		<select id="subscription-ticker" name="subscription_ticker" class="form-control custom-select">
			<option value="default" <?php selected( 'subscription_ticker', 'default' ); ?>><?php lang()->p( 'Use default notification email' ); ?></option>
			<?php foreach ( $static as $key => $value ) { ?>
				<option value="<?php echo $key; ?>" <?php selected( 'subscription_ticker', $key ); ?>><?php lang()->p( 'Page' ); ?>: <?php echo $value["title"]; ?></option>
			<?php } ?>
		</select>
		<small class="form-text text-muted"><?php lang()->p( 'Read more about a custom notification emails %s', array( '<a href="#" target="_blank">' . sn__( 'here' ) . '</a>' ) ); ?></small>
	</div>
</div>
