<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
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
				<h1><?php echo lang('addnewrole');?></h1>
			</div>
			<?php
			$action_url = site_url('admin/rolemanagement/add'); 
			$attributes = array('class' => 'clsname', 'id' => 'idname');
			echo form_open($action_url, $attributes) 
			?>
				<div class="form-group">
					<label for="title">Role Title</label>
					<input type="text" class="form-control" id="role_title" name="role_title"  value="<?php echo $this->input->post('role_title');?>" placeholder="Enter Role Title Here">
				</div>
                
                <div class="form-group">
					<label for="title">Role Key</label>
					<input type="text" class="form-control" id="role_key" name="role_key"  value="<?php echo $this->input->post('role_key');?>" placeholder="Enter Role Key">
                    <p>Space Not Allowed, Must be unique and Minimum 4 Characters</p>
				</div>
                
                
                <div class="form-group">
					<input type="checkbox" id="role_status" name="role_status" checked="checked"> <label for="role_status">Enable ?</label>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="<?php echo lang('save');?>">
				</div>
			<?php echo form_close() ?>
		</div>
	</div><!-- .row -->
</div><!-- .container -->