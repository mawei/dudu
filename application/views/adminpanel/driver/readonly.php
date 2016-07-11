<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<div class='panel panel-default '>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 司机管理 查看信息 
        <div class='panel-tools'>
            <div class='btn-group'>
            	<a class="btn " href="<?php echo base_url('adminpanel/driver')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
            </div>
        </div>
    </div>
    <div class='panel-body '>
<div class="form-horizontal"  >
	<fieldset>
        <legend>基本信息</legend>
     
  	  	
	<div class="form-group">
				<label for="telephone" class="col-sm-2 control-label form-control-static">手机号码</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['telephone'])?$data_info['telephone']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="truck_type" class="col-sm-2 control-label form-control-static">货车类型</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['truck_type'])?$data_info['truck_type']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="truck_size" class="col-sm-2 control-label form-control-static">车长/车重</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['truck_size'])?$data_info['truck_size']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="truck_head_photo" class="col-sm-2 control-label form-control-static">车头照</label>
				<div class="col-sm-9 ">
					<img src='<?php echo SITE_URL;?><?php echo  isset($data_info['truck_head_photo'])?('upload/'.$data_info['truck_head_photo']):'' ?>' width="100" />
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="drive_license" class="col-sm-2 control-label form-control-static">车辆驾驶证</label>
				<div class="col-sm-9 ">
					<img src='<?php echo SITE_URL;?><?php echo  isset($data_info['drive_license'])?('upload/'.$data_info['drive_license']):'' ?>' width="100" />
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="truck_full_photo" class="col-sm-2 control-label form-control-static">全车照</label>
				<div class="col-sm-9 ">
					<img src='<?php echo SITE_URL;?><?php echo  isset($data_info['truck_full_photo'])?('upload/'.$data_info['truck_full_photo']):'' ?>' width="100" />
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="last_login" class="col-sm-2 control-label form-control-static">最后一次登陆</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['last_login'])?$data_info['last_login']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="status" class="col-sm-2 control-label form-control-static">用户状态</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['status'])?$data_info['status']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="online_status" class="col-sm-2 control-label form-control-static">在线状态</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['online_status'])?$data_info['online_status']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="latitude" class="col-sm-2 control-label form-control-static">纬度</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['latitude'])?$data_info['latitude']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="longitude" class="col-sm-2 control-label form-control-static">经度</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['longitude'])?$data_info['longitude']:'' ?>
				</div>
			</div>
	    </fieldset>
	</div>
</div>
</div>
