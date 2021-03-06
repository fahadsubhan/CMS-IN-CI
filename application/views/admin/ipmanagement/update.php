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
				<h1>Update Ip Address which you want to add in the White list</h1>
			</div>
			<?php
			$action_url = site_url('admin/ipmanagement/update/'.$ipID); 
			$attributes = array('class' => 'clsname', 'id' => 'idname');
			echo form_open($action_url, $attributes) 
			?>
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title"  value="<?php echo $ipDetails['title'];?>" placeholder="Enter White List IP Title">
				</div>
				<div class="form-group">
					<label for="ip_address">Ip Address</label>
					<input type="text" class="form-control" id="ip_address" name="ip_address"  value="<?php echo $ipDetails['ip_address'];?>" placeholder="Enter IP Address">
				</div>
                
                <div class="form-group">
					<input type="checkbox" id="is_active" name="is_active" <?php echo ($ipDetails['is_active'])?'checked="checked"':'';?>> <label for="is_active">Is Active ?</label>
				</div>
                <input type="hidden" name="ip_id" value="<?php echo $ipID;?>" />
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Save">
				</div>
			<?php echo form_close() ?>
		</div>
	</div><!-- .row -->
</div><!-- .container -->