<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
<?php if($regsuccess){?>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Thank you for registering your new account!</h1>
			</div>
			<p>You have successfully register.</p>
		</div>
	</div><!-- .row -->
<?php } else {?> 
    <div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php echo validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php echo $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Register</h1>
			</div>
			<?php
			$action_url = site_url('/user/register'); 
			$attributes = array('class' => 'clsname', 'id' => 'idname');
			echo form_open($action_url, $attributes) 
			?>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username"  value="<?php echo $this->input->post('username');?>" placeholder="Enter a username">
					<p class="help-block">At least 4 characters, letters or numbers only</p>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="user_email" name="user_email"  value="<?php echo $this->input->post('user_email');?>" placeholder="Enter your email">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
					<p class="help-block">At least 6 characters</p>
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirm password</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
					<p class="help-block">Must match your password</p>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Register">
				</div>
			<?php echo form_close() ?>
		</div>
	</div><!-- .row -->
<?php }?>
</div><!-- .container -->