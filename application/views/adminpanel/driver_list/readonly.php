<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<div class='panel panel-default '>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 司机列表接口 查看信息 
        <div class='panel-tools'>
            <div class='btn-group'>
            	<a class="btn " href="<?php echo base_url('adminpanel/driver_list')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
            </div>
        </div>
    </div>
    <div class='panel-body '>
<div class="form-horizontal"  >
	<fieldset>
        <legend>基本信息</legend>
     
  	  	
	<div class="form-group">
				<label for="driver_id" class="col-sm-2 control-label form-control-static">司机id</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['driver_id'])?$data_info['driver_id']:'' ?>
				</div>
			</div>
	    </fieldset>
	</div>
</div>
</div>
