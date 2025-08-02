<?php
/**
 * Text settings tab
 *
 * @package    Post Comments
 * @subpackage Views
 * @category   Forms
 * @since      1.0.0
 */

// Access global variables.
global $comments_plugin;

?>
<h2 class="form-heading"><?php lang()->p( 'Text Settings' ); ?></h2>

<div class="form-group row">
	<label for="sn-terms-of-use" class="col-sm-2 col-form-label"><?php lang()->p( 'Terms of Use' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-terms-of-use" name="string_terms_of_use" value="<?php echo sn_config( 'string_terms_of_use' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_terms_of_use"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-success-1" class="col-sm-2 col-form-label"><?php lang()->p( 'Default Thank You Message' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-success-1" name="string_success_1" value="<?php echo sn_config( 'string_success_1' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_success_1"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-success-2" class="col-sm-2 col-form-label"><?php lang()->p( 'Thank You Message with Subscription' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-success-2" name="string_success_2" value="<?php echo sn_config( 'string_success_2' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_success_2"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-success-3" class="col-sm-2 col-form-label"><?php lang()->p( 'Thank You Message for Voting' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-success-3" name="string_success_3" value="<?php echo sn_config( 'string_success_3' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_success_3"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-1" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Unknown' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-1" name="string_error_1" value="<?php echo sn_config( 'string_error_1' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_1"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-2" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Username' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-2" name="string_error_2" value="<?php echo sn_config( 'string_error_2' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_2"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-3" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Email' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-3" name="string_error_3" value="<?php echo sn_config( 'string_error_3' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_3"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-4" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Text' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-4" name="string_error_4" value="<?php echo sn_config( 'string_error_4' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_4"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-5" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Title' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-5" name="string_error_5" value="<?php echo sn_config( 'string_error_5' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_5"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-6" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Terms' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-6" name="string_error_6" value="<?php echo sn_config( 'string_error_6' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_6"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-7" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Spam' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-7" name="string_error_7" value="<?php echo sn_config( 'string_error_7' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_7"]; ?>" />
	</div>
</div>

<div class="form-group row">
	<label for="sn-error-8" class="col-sm-2 col-form-label"><?php lang()->p( 'Error: Already Voted' ); ?></label>
	<div class="col-sm-10">
		<input type="text" id="sn-error-8" name="string_error_8" value="<?php echo sn_config( 'string_error_8' ); ?>" class="form-control" placeholder="<?php echo $comments_plugin->dbFields["string_error_8"]; ?>" />
	</div>
</div>
