<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
<?php 
	if($this->session->flashdata('success_msg')!='')
	{
		?>
        <div class="row">
        	<div class="col-md-12">
				<div class="alert alert-success" role="alert">
					<?php echo $this->session->flashdata('success_msg');?>
				</div>
			</div>
			
        </div>
<?php }?>

    
  <div class="row">
      <div class="col-md-10">
      	<h4><?php echo lang('rolemanagement');?></h4> 
      </div>
      <div class="col-md-2 text-right">
     	 <a href="<?php echo site_url('admin/rolemanagement/add');?>" class="btn btn-success btn-xlarge" data-placement="top" data-toggle="tooltip" title="Add">
                  <span class="glyphicon glyphicon-plus"></span>
         </a>
     </div>
     
    </div> 
<div class="row"> 
     <div class="col-md-12">  
      <div class="table-responsive">
        <table id="mytable" class="table table-bordred table-striped">
          <thead>
          <th scope="row">#</th>
          <th><?php echo lang('title');?></th>
            <th><?php echo lang('rolekey');?></th>
            <th class="text-center"><?php echo lang('action');?></th>
              </thead>
          <tbody>
          
          <?php
		  	$counter = 1;
		  	foreach($roleslist as $onerole){?>
          	<tr>
            <td scope="row"><?php echo $counter;?></td>
              <td><?php echo $onerole['role_title'];?></td>
              <td><?php echo $onerole['role_key'];?></td>
              <td class="text-center">
              	<a href="<?php echo site_url('admin/rolemanagement/update/'.$onerole['role_id']);?>" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" title="Edit">
                  <span class="glyphicon glyphicon-pencil"></span>
                </a> 
                |
                <?php if($onerole['role_status']){?>
                    <span data-placement="top" data-toggle="tooltip" title="De-Active">
                      <a href="<?php echo site_url('admin/rolemanagement/status/0/'.$onerole['role_id']);?>" class="btn btn-warning btn-xs" data-title="De-Active"><span class="glyphicon glyphicon-ban-circle"></span></a>
                    </span>
                <?php }else{?>
                    <span data-placement="top" data-toggle="tooltip" title="Active">
                      <a href="<?php echo site_url('admin/rolemanagement/status/1/'.$onerole['role_id']);?>" class="btn btn-success btn-xs" data-title="Active"><span class="glyphicon glyphicon-ok"></span></a>
                    </span>
                <?php }?> 
                | 
                <span data-placement="top" data-toggle="tooltip" title="Delete">
                  <button id="<?php echo $onerole['role_id'];?>" class="btn btn-danger btn-xs delete_row" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button>
                </span>
              </td>
            </tr>
          <?php $counter++; }?>
          </tbody>
        </table>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<!--Delete Confirmation POPUP-->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
      </div>
      <div class="modal-footer ">
        <a type="button" class="btn btn-success delete_url" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
