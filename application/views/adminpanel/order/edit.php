<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo base_url('adminpanel/order/edit')?>" >
	<div class='panel panel-default '>
		<div class='panel-heading'>
			<i class='fa fa-table'></i> 订单管理 修改信息
			<div class='panel-tools'>
				<div class='btn-group'>
					<a class="btn " href="<?php echo base_url('adminpanel/order')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
				</div>
			</div>
		</div>
		<div class='panel-body '>
								<fieldset>
						<legend>基本信息</legend>
													
<!-- 	<div class="form-group">
				<label for="customer_id" class="col-sm-2 control-label form-control-static">货主</label>
				<div class="col-sm-9 ">
					<?php $options = process_datasource($this->method_config['customer_list_datasource'])?>
					<select class="form-control  validate[required]"  name="customer_id"  id="customer_id">
						<option value="">==请选择==</option>
<?php if($options)foreach($options as $option):?>
						<option value='<?php echo $option['val'];?>' <?php if(isset($data_info['customer_id'])&&($data_info['customer_id']==$option['val'])) { ?> selected="selected" <?php } ?>            ><?php echo $option['text'];?></option>
<?php endforeach;?>
					</select>

				</div>
			</div>
					 -->								
	<div class="form-group">
				<label for="start_place" class="col-sm-2 control-label form-control-static">出发地</label>
				<div class="col-sm-9 ">
					<input type="text" name="start_place"  id="start_place"  value='<?php echo isset($data_info['start_place'])?$data_info['start_place']:'' ?>'  class="form-control validate[required]"  placeholder="请输入出发地" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="start_place_latitude" class="col-sm-2 control-label form-control-static">起始点纬度</label>
				<div class="col-sm-9 ">
					<input type="text" name="start_place_latitude"  id="start_place_latitude"  value='<?php echo isset($data_info['start_place_latitude'])?$data_info['start_place_latitude']:'' ?>'  class="form-control validate[required]"  placeholder="请输入起始点纬度" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="start_place_longitude" class="col-sm-2 control-label form-control-static">起始点经度</label>
				<div class="col-sm-9 ">
					<input type="text" name="start_place_longitude"  id="start_place_longitude"  value='<?php echo isset($data_info['start_place_longitude'])?$data_info['start_place_longitude']:'' ?>'  class="form-control validate[required]"  placeholder="请输入起始点经度" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="end_place" class="col-sm-2 control-label form-control-static">目的地</label>
				<div class="col-sm-9 ">
					<input type="text" name="end_place"  id="end_place"  value='<?php echo isset($data_info['end_place'])?$data_info['end_place']:'' ?>'  class="form-control validate[required]"  placeholder="请输入目的地" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="end_place_latitude" class="col-sm-2 control-label form-control-static">目的地纬度</label>
				<div class="col-sm-9 ">
					<input type="text" name="end_place_latitude"  id="end_place_latitude"  value='<?php echo isset($data_info['end_place_latitude'])?$data_info['end_place_latitude']:'' ?>'  class="form-control validate[required]"  placeholder="请输入目的地纬度" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="end_place_longitude" class="col-sm-2 control-label form-control-static">目的地经度</label>
				<div class="col-sm-9 ">
					<input type="text" name="end_place_longitude"  id="end_place_longitude"  value='<?php echo isset($data_info['end_place_longitude'])?$data_info['end_place_longitude']:'' ?>'  class="form-control validate[required]"  placeholder="请输入目的地经度" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="start_time" class="col-sm-2 control-label form-control-static">出发时间</label>
				<div class="col-sm-9 ">
					<input type="text" name="start_time"  id="start_time"   value='<?php echo isset($data_info['start_time'])?$data_info['start_time']:'' ?>'  class="form-control datetimepicker  validate[required,custom[datetime]]"  placeholder="请输入出发时间" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="truck_type" class="col-sm-2 control-label form-control-static">车型</label>
				<div class="col-sm-9 ">
					<input type="text" name="truck_type"  id="truck_type"  value='<?php echo isset($data_info['truck_type'])?$data_info['truck_type']:'' ?>'  class="form-control validate[required]"  placeholder="请输入车型" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="truck_size" class="col-sm-2 control-label form-control-static">车长/车重</label>
				<div class="col-sm-9 ">
					<input type="text" name="truck_size"  id="truck_size"  value='<?php echo isset($data_info['truck_size'])?$data_info['truck_size']:'' ?>'  class="form-control validate[required]"  placeholder="请输入车长/车重" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="charge" class="col-sm-2 control-label form-control-static">出价</label>
				<div class="col-sm-9 ">
					<input type="number" name="charge"  id="charge"   value='<?php echo isset($data_info['charge'])?$data_info['charge']:'' ?>'   class="form-control  validate[required,custom[price]]" placeholder="请输入出价" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="weight" class="col-sm-2 control-label form-control-static">重量</label>
				<div class="col-sm-9 ">
					<input type="number" name="weight"  id="weight"  value='<?php echo isset($data_info['weight'])?$data_info['weight']:'' ?>'   class="form-control  validate[required,custom[integer]]" placeholder="请输入重量" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="infomation_charge" class="col-sm-2 control-label form-control-static">信息费</label>
				<div class="col-sm-9 ">
					<input type="number" name="infomation_charge"  id="infomation_charge"   value='<?php echo isset($data_info['infomation_charge'])?$data_info['infomation_charge']:'' ?>'   class="form-control validate[custom[price]]" placeholder="请输入信息费" >
				</div>
			</div>
													
<!-- 	<div class="form-group">
				<label for="driver_id" class="col-sm-2 control-label form-control-static">接单司机</label>
				<div class="col-sm-9 ">
					<?php $options = process_datasource($this->method_config['driver_list_datasource'])?>
					<select class="form-control "  name="driver_id"  id="driver_id">
						<option value="">==请选择==</option>
<?php if($options)foreach($options as $option):?>
						<option value='<?php echo $option['val'];?>' <?php if(isset($data_info['driver_id'])&&($data_info['driver_id']==$option['val'])) { ?> selected="selected" <?php } ?>            ><?php echo $option['text'];?></option>
<?php endforeach;?>
					</select>

				</div>
			</div> -->
													
	<!-- <div class="form-group">
				<label for="status" class="col-sm-2 control-label form-control-static">状态</label>
				<div class="col-sm-9 ">
					<input type="text" name="status"  id="status"  value='<?php echo isset($data_info['status'])?$data_info['status']:'' ?>'  class="form-control validate[required]"  placeholder="请输入状态" >
				</div>
			</div> -->
											</fieldset>
							<div class='form-actions'>
				<button class='btn btn-primary ' type='submit' id="dosubmit">保存</button>
			</div>
</form>
			<script language="javascript" type="text/javascript">
			var is_edit =<?php echo ($is_edit)?"true":"false" ?>;
			var id =<?php echo $id;?>;

			require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
		        require(['<?php echo SITE_URL?>scripts/adminpanel/order/edit.js']);
		    });
		</script>
	
	