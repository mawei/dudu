<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<div class='panel panel-default '>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 订单管理 查看信息 
        <div class='panel-tools'>
            <div class='btn-group'>
            	<a class="btn " href="<?php echo base_url('adminpanel/order')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
            </div>
        </div>
    </div>
    <div class='panel-body '>
<div class="form-horizontal"  >
	<fieldset>
        <legend>基本信息</legend>
     
  	  	
	<div class="form-group">
				<label for="customer_id" class="col-sm-2 control-label form-control-static">货主</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['customer_id'])?$data_info['customer_id']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="start_place" class="col-sm-2 control-label form-control-static">出发地</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['start_place'])?$data_info['start_place']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="start_place_latitude" class="col-sm-2 control-label form-control-static">起始点纬度</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['start_place_latitude'])?$data_info['start_place_latitude']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="start_place_longitude" class="col-sm-2 control-label form-control-static">起始点经度</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['start_place_longitude'])?$data_info['start_place_longitude']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="end_place" class="col-sm-2 control-label form-control-static">目的地</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['end_place'])?$data_info['end_place']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="end_place_latitude" class="col-sm-2 control-label form-control-static">目的地纬度</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['end_place_latitude'])?$data_info['end_place_latitude']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="end_place_longitude" class="col-sm-2 control-label form-control-static">目的地经度</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['end_place_longitude'])?$data_info['end_place_longitude']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="start_time" class="col-sm-2 control-label form-control-static">出发时间</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['start_time'])?$data_info['start_time']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="truck_type" class="col-sm-2 control-label form-control-static">车型</label>
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
				<label for="charge" class="col-sm-2 control-label form-control-static">出价</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['charge'])?$data_info['charge']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="weight" class="col-sm-2 control-label form-control-static">重量</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['weight'])?$data_info['weight']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="infomation_charge" class="col-sm-2 control-label form-control-static">信息费</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['infomation_charge'])?$data_info['infomation_charge']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="driver_id" class="col-sm-2 control-label form-control-static">接单司机</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['driver_id'])?$data_info['driver_id']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="status" class="col-sm-2 control-label form-control-static">状态</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['status'])?$data_info['status']:'' ?>
				</div>
			</div>
	    </fieldset>
	</div>
</div>
</div>
