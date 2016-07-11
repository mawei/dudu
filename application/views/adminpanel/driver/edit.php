<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo base_url('adminpanel/driver/edit')?>" >
	<div class='panel panel-default '>
		<div class='panel-heading'>
			<i class='fa fa-table'></i> 司机管理 修改信息
			<div class='panel-tools'>
				<div class='btn-group'>
					<a class="btn " href="<?php echo base_url('adminpanel/driver')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
				</div>
			</div>
		</div>
		<div class='panel-body '>
								<fieldset>
						<legend>基本信息</legend>
													
	<div class="form-group">
				<label for="telephone" class="col-sm-2 control-label form-control-static">手机号码</label>
				<div class="col-sm-9 ">
					<input type="text" name="telephone"  id="telephone"   value='<?php echo isset($data_info['telephone'])?$data_info['telephone']:'' ?>'   class="form-control  validate[required,custom[mobile]]"  placeholder="请输入手机号码" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="truck_type" class="col-sm-2 control-label form-control-static">货车类型</label>
				<div class="col-sm-9 ">
					<input type="text" name="truck_type"  id="truck_type"  value='<?php echo isset($data_info['truck_type'])?$data_info['truck_type']:'' ?>'  class="form-control validate[required]"  placeholder="请输入货车类型" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="truck_size" class="col-sm-2 control-label form-control-static">车长/车重</label>
				<div class="col-sm-9 ">
					<input type="text" name="truck_size"  id="truck_size"  value='<?php echo isset($data_info['truck_size'])?$data_info['truck_size']:'' ?>'  class="form-control validate[required]"  placeholder="请输入车长/车重" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="password" class="col-sm-2 control-label form-control-static">密码</label>
				<div class="col-sm-9 ">
					<input type="password" name="o_password"  id="o_password"    autocomplete="off"  class="form-control password "  placeholder="请输入密码" >
				</div>
			</div>

	<div class="form-group">
				<label for="password" class="col-sm-2 control-label form-control-static">确认密码</label>
				<div class="col-sm-9 ">
					<input type="password" name="password"  id="password"    autocomplete="off" class="form-control   validate[equals[password]]"  placeholder="请再次输入密码" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="truck_head_photo" class="col-sm-2 control-label form-control-static">车头照</label>
				<div class="col-sm-9 ">
					<a id="truck_head_photo_a"  ><img  width="100" id="truck_head_photo_SRC" border="1" src="<?php echo SITE_URL?><?php echo isset($data_info["truck_head_photo"])?"upload".$data_info["truck_head_photo"]:"images/nopic.gif" ?>"/></a>
<input type="hidden" id="truck_head_photo" name="truck_head_photo" value="<?php echo isset($data_info["truck_head_photo"])?$data_info["truck_head_photo"]:"" ?>" /> <a id="truck_head_photo_b" class="btn btn-default btn-sm" > 选择图片 ...</a><span class="help-block">只支持图片上传.</span>
				</div>
			</div>
													
	<div class="form-group">
				<label for="drive_license" class="col-sm-2 control-label form-control-static">车辆驾驶证</label>
				<div class="col-sm-9 ">
					<a id="drive_license_a"  ><img  width="100" id="drive_license_SRC" border="1" src="<?php echo SITE_URL?><?php echo isset($data_info["drive_license"])?"upload".$data_info["drive_license"]:"images/nopic.gif" ?>"/></a>
<input type="hidden" id="drive_license" name="drive_license" value="<?php echo isset($data_info["drive_license"])?$data_info["drive_license"]:"" ?>" /> <a id="drive_license_b" class="btn btn-default btn-sm" > 选择图片 ...</a><span class="help-block">只支持图片上传.</span>
				</div>
			</div>
													
	<div class="form-group">
				<label for="truck_full_photo" class="col-sm-2 control-label form-control-static">全车照</label>
				<div class="col-sm-9 ">
					<a id="truck_full_photo_a"  ><img  width="100" id="truck_full_photo_SRC" border="1" src="<?php echo SITE_URL?><?php echo isset($data_info["truck_full_photo"])?"upload".$data_info["truck_full_photo"]:"images/nopic.gif" ?>"/></a>
<input type="hidden" id="truck_full_photo" name="truck_full_photo" value="<?php echo isset($data_info["truck_full_photo"])?$data_info["truck_full_photo"]:"" ?>" /> <a id="truck_full_photo_b" class="btn btn-default btn-sm" > 选择图片 ...</a><span class="help-block">只支持图片上传.</span>
				</div>
			</div>
													
	<div class="form-group">
				<label for="last_login" class="col-sm-2 control-label form-control-static">最后一次登陆</label>
				<div class="col-sm-9 ">
					<input type="text" name="last_login"  id="last_login"   value='<?php echo isset($data_info['last_login'])?$data_info['last_login']:'' ?>'  class="form-control datetimepicker validate[custom[datetime]]"  placeholder="请输入最后一次登陆" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="status" class="col-sm-2 control-label form-control-static">用户状态</label>
				<div class="col-sm-9 ">
					<select class="form-control  validate[required]"  name="status"  id="status">
				<option value="">==请选择==</option>
								<option value='未认证' <?php if(isset($data_info['status'])&&($data_info['status']=='未认证')) { ?> selected="selected" <?php } ?>            >未认证</option>
				<option value='已认证' <?php if(isset($data_info['status'])&&($data_info['status']=='已认证')) { ?> selected="selected" <?php } ?>            >已认证</option>
				<option value='锁定' <?php if(isset($data_info['status'])&&($data_info['status']=='锁定')) { ?> selected="selected" <?php } ?>            >锁定</option>
</select>
				</div>
			</div>
													
	<div class="form-group">
				<label for="online_status" class="col-sm-2 control-label form-control-static">在线状态</label>
				<div class="col-sm-9 ">
					<input type="text" name="online_status"  id="online_status"  value='<?php echo isset($data_info['online_status'])?$data_info['online_status']:'' ?>'  class="form-control validate[required]"  placeholder="请输入在线状态" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="latitude" class="col-sm-2 control-label form-control-static">纬度</label>
				<div class="col-sm-9 ">
					<input type="text" name="latitude"  id="latitude"  value='<?php echo isset($data_info['latitude'])?$data_info['latitude']:'' ?>'  class="form-control validate[required]"  placeholder="请输入纬度" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="longitude" class="col-sm-2 control-label form-control-static">经度</label>
				<div class="col-sm-9 ">
					<input type="text" name="longitude"  id="longitude"  value='<?php echo isset($data_info['longitude'])?$data_info['longitude']:'' ?>'  class="form-control validate[required]"  placeholder="请输入经度" >
				</div>
			</div>
											</fieldset>
							<div class='form-actions'>
				<button class='btn btn-primary ' type='submit' id="dosubmit">保存</button>
			</div>
</form>
			<script language="javascript" type="text/javascript">
			var is_edit =<?php echo ($is_edit)?"true":"false" ?>;
			var id =<?php echo $id;?>;

			require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
		        require(['<?php echo SITE_URL?>scripts/adminpanel/driver/edit.js']);
		    });
		</script>
	
	