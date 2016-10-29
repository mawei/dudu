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
													
<!-- 	<div class="form-group">
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
			</div> -->
													
	<div class="form-group">
				<label for="end_place" class="col-sm-2 control-label form-control-static">目的地</label>
				<div class="col-sm-9 ">
					<input type="text" name="end_place"  id="end_place"  value='<?php echo isset($data_info['end_place'])?$data_info['end_place']:'' ?>'  class="form-control validate[required]"  placeholder="请输入目的地" >
				</div>
			</div>
													
<!-- 	<div class="form-group">
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
					 -->								
	<div class="form-group">
				<label for="start_time" class="col-sm-2 control-label form-control-static">出发时间</label>
				<div class="col-sm-9 ">
					<input type="text" name="start_time"  id="start_time"   value='<?php echo isset($data_info['start_time'])?$data_info['start_time']:'' ?>'  class="form-control datetimepicker  validate[required,custom[datetime]]"  placeholder="请输入出发时间" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="truck_type" class="col-sm-2 control-label form-control-static">车型</label>
				<div class="col-sm-9 ">
					<select class="form-control  validate[required]"  name="truck_type"  id="truck_type">
				<option value="">==请选择==</option>
								<option value='平板货车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='平板货车')) { ?> selected="selected" <?php } ?>            >平板货车</option>
				<option value='高栏货车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='高栏货车')) { ?> selected="selected" <?php } ?>            >高栏货车</option>
				<option value='厢式车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='厢式车')) { ?> selected="selected" <?php } ?>            >厢式车</option>
				<option value='挂车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='挂车')) { ?> selected="selected" <?php } ?>            >挂车</option>
				<option value='自卸车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='自卸车')) { ?> selected="selected" <?php } ?>            >自卸车</option>
				<option value='冷藏车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='冷藏车')) { ?> selected="selected" <?php } ?>            >冷藏车</option>
				<option value='吊车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='吊车')) { ?> selected="selected" <?php } ?>            >吊车</option>
				<option value='叉车' <?php if(isset($data_info['truck_type'])&&($data_info['truck_type']=='叉车')) { ?> selected="selected" <?php } ?>            >叉车</option>
</select>
				</div>
			</div>
													
<!-- 	<div class="form-group">
				<label for="truck_size" class="col-sm-2 control-label form-control-static">车长/车重</label>
				<div class="col-sm-9 ">
					<input type="text" name="truck_size"  id="truck_size"  value='<?php echo isset($data_info['truck_size'])?$data_info['truck_size']:'' ?>'  class="form-control validate[required]"  placeholder="请输入车长/车重" >
				</div>
			</div> -->
				<div class="form-group">
				<label for="truck_size" class="col-sm-2 control-label form-control-static">车重/车长</label>
				<div class="col-sm-9 ">
					<label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size2.8米以下" value="2.8米以下
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'2.8米以下'))) { ?> checked="checked" <?php } ?>            > 2.8米以下</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size3.5米" value="3.5米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'3.5米'))) { ?> checked="checked" <?php } ?>            > 3.5米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size4.2米" value="4.2米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'4.2米'))) { ?> checked="checked" <?php } ?>            > 4.2米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size4.8米" value="4.8米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'4.8米'))) { ?> checked="checked" <?php } ?>            > 4.8米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size5.2米" value="5.2米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'5.2米'))) { ?> checked="checked" <?php } ?>            > 5.2米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size5.8米" value="5.8米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'5.8米'))) { ?> checked="checked" <?php } ?>            > 5.8米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size6.3米" value="6.3米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'6.3米'))) { ?> checked="checked" <?php } ?>            > 6.3米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size7.2米" value="7.2米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'7.2米'))) { ?> checked="checked" <?php } ?>            > 7.2米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size7.5米" value="7.5米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'7.5米'))) { ?> checked="checked" <?php } ?>            > 7.5米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size7.8米" value="7.8米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'7.8米'))) { ?> checked="checked" <?php } ?>            > 7.8米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size8.5米" value="8.5米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'8.5米'))) { ?> checked="checked" <?php } ?>            > 8.5米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size9.2米" value="9.2米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'9.2米'))) { ?> checked="checked" <?php } ?>            > 9.2米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size9.6米" value="9.6米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'9.6米'))) { ?> checked="checked" <?php } ?>            > 9.6米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size13米" value="13米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'13米'))) { ?> checked="checked" <?php } ?>            > 13米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size17.5米" value="17.5米
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'17.5米'))) { ?> checked="checked" <?php } ?>            > 17.5米</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size3T" value="3T
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'3T'))) { ?> checked="checked" <?php } ?>            > 3T</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size5T" value="5T
"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'5T'))) { ?> checked="checked" <?php } ?>            > 5T</label><label class="radio-inline">  <input type="checkbox" class="" name="truck_size[]"  id="truck_size8T" value="8T"   <?php if(isset($data_info['truck_size'])&&(str_exists($data_info['truck_size'],'8T'))) { ?> checked="checked" <?php } ?>            > 8T</label>
				</div>
			</div>
					
	<div class="form-group">
		<label for="weight" class="col-sm-2 control-label form-control-static">重量</label>
		<div class="col-sm-9 ">
			<input type="number" name="weight"  id="weight"  value='<?php echo isset($data_info['weight'])?$data_info['weight']:'' ?>'   class="form-control  validate[required,custom[integer]]" placeholder="请输入重量" >
		</div>
	</div>	

	<div class="form-group">
				<label for="charge" class="col-sm-2 control-label form-control-static">出价</label>
				<div class="col-sm-9 ">
					<input type="number" name="charge"  id="charge"   value='<?php echo isset($data_info['charge'])?$data_info['charge']:'' ?>'   class="form-control  validate[required,custom[price]]" placeholder="请输入出价" >
				</div>
			</div>
													
	
													
<!-- 	<div class="form-group">
				<label for="infomation_charge" class="col-sm-2 control-label form-control-static">信息费</label>
				<div class="col-sm-9 ">
					<input type="number" name="infomation_charge"  id="infomation_charge"   value='<?php echo isset($data_info['infomation_charge'])?$data_info['infomation_charge']:'' ?>'   class="form-control validate[custom[price]]" placeholder="请输入信息费" >
				</div>
			</div> -->
													
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
		<script src="http://webapi.amap.com/maps?v=1.3&key=86a5ab5b85e0393025ffb2726a0e3404"></script>
			<script language="javascript" type="text/javascript">
			var is_edit =<?php echo ($is_edit)?"true":"false" ?>;
			var id =<?php echo $id;?>;

			require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
		        require(['<?php echo SITE_URL?>scripts/adminpanel/order/edit.js']);
		    });

			//地图
		    AMap.plugin('AMap.Autocomplete',function(){//回调函数
		        //实例化Autocomplete
		        var autoOptions = {
		            city: "", //城市，默认全国
		            input:"start_place"//使用联想输入的input的id
		        };
		        autocomplete= new AMap.Autocomplete(autoOptions);
		        //TODO: 使用autocomplete对象调用相关功能
		        AMap.event.addListener(autocomplete, "select", function(e){
			           //TODO 针对选中的poi实现自己的功能
			    });
		    });

		</script>
	
	