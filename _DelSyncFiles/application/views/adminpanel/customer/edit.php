<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo base_url('adminpanel/customer/edit')?>" >
	<div class='panel panel-default '>
		<div class='panel-heading'>
			<i class='fa fa-table'></i> 货主管理 修改信息
			<div class='panel-tools'>
				<div class='btn-group'>
					<a class="btn " href="<?php echo base_url('adminpanel/customer')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
				</div>
			</div>
		</div>
		<div class='panel-body '>
								<fieldset>
						<legend>基本信息</legend>
													
	<div class="form-group">
				<label for="customer_type" class="col-sm-2 control-label form-control-static">货主类型</label>
				<div class="col-sm-9 ">
					<input type="text" name="customer_type"  id="customer_type"  value='<?php echo isset($data_info['customer_type'])?$data_info['customer_type']:'' ?>'  class="form-control validate[required]"  placeholder="请输入货主类型" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="telephone" class="col-sm-2 control-label form-control-static">手机号码</label>
				<div class="col-sm-9 ">
					<input type="text" name="telephone"  id="telephone"  value='<?php echo isset($data_info['telephone'])?$data_info['telephone']:'' ?>'  class="form-control validate[required]"  placeholder="请输入手机号码" >
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
				<label for="name" class="col-sm-2 control-label form-control-static">姓名</label>
				<div class="col-sm-9 ">
					<input type="text" name="name"  id="name"  value='<?php echo isset($data_info['name'])?$data_info['name']:'' ?>'  class="form-control validate[required]"  placeholder="请输入姓名" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="identity" class="col-sm-2 control-label form-control-static">身份证号</label>
				<div class="col-sm-9 ">
					<input type="text" name="identity"  id="identity"  value='<?php echo isset($data_info['identity'])?$data_info['identity']:'' ?>'  class="form-control validate[required]"  placeholder="请输入身份证号" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="wuliu_name" class="col-sm-2 control-label form-control-static">物流公司名称</label>
				<div class="col-sm-9 ">
					<input type="text" name="wuliu_name"  id="wuliu_name"  value='<?php echo isset($data_info['wuliu_name'])?$data_info['wuliu_name']:'' ?>'  class="form-control validate[required]"  placeholder="请输入物流公司名称" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="wuliu_license" class="col-sm-2 control-label form-control-static">物流公司营业执照</label>
				<div class="col-sm-9 ">
					<a id="wuliu_license_a"  ><img  width="100" id="wuliu_license_SRC" border="1" src="<?php echo SITE_URL?><?php echo isset($data_info["wuliu_license"])?"upload".$data_info["wuliu_license"]:"images/nopic.gif" ?>"/></a>
<input type="hidden" id="wuliu_license" name="wuliu_license" value="<?php echo isset($data_info["wuliu_license"])?$data_info["wuliu_license"]:"" ?>" /> <a id="wuliu_license_b" class="btn btn-default btn-sm" > 选择图片 ...</a><span class="help-block">只支持图片上传.</span>
				</div>
			</div>
													
	<div class="form-group">
				<label for="company_name" class="col-sm-2 control-label form-control-static">企业名称</label>
				<div class="col-sm-9 ">
					<input type="text" name="company_name"  id="company_name"  value='<?php echo isset($data_info['company_name'])?$data_info['company_name']:'' ?>'  class="form-control validate[required]"  placeholder="请输入企业名称" >
				</div>
			</div>
													
	<div class="form-group">
				<label for="company_license" class="col-sm-2 control-label form-control-static">营业执照</label>
				<div class="col-sm-9 ">
					<a id="company_license_a"  ><img  width="100" id="company_license_SRC" border="1" src="<?php echo SITE_URL?><?php echo isset($data_info["company_license"])?"upload".$data_info["company_license"]:"images/nopic.gif" ?>"/></a>
<input type="hidden" id="company_license" name="company_license" value="<?php echo isset($data_info["company_license"])?$data_info["company_license"]:"" ?>" /> <a id="company_license_b" class="btn btn-default btn-sm" > 选择图片 ...</a><span class="help-block">只支持图片上传.</span>
				</div>
			</div>
													
	<div class="form-group">
				<label for="status" class="col-sm-2 control-label form-control-static">状态</label>
				<div class="col-sm-9 ">
					<select class="form-control "  name="status"  id="status">
				<option value="">==请选择==</option>
								<option value='未认证' <?php if(isset($data_info['status'])&&($data_info['status']=='未认证')) { ?> selected="selected" <?php } ?>            >未认证</option>
				<option value='已认证' <?php if(isset($data_info['status'])&&($data_info['status']=='已认证')) { ?> selected="selected" <?php } ?>            >已认证</option>
				<option value='锁定' <?php if(isset($data_info['status'])&&($data_info['status']=='锁定')) { ?> selected="selected" <?php } ?>            >锁定</option>
</select>
				</div>
			</div>
													
	<div class="form-group">
				<label for="last_login" class="col-sm-2 control-label form-control-static">最后登陆</label>
				<div class="col-sm-9 ">
					<input type="text" name="last_login"  id="last_login"   value='<?php echo isset($data_info['last_login'])?$data_info['last_login']:'' ?>'  class="form-control datetimepicker validate[custom[datetime]]"  placeholder="请输入最后登陆" >
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
		        require(['<?php echo SITE_URL?>scripts/adminpanel/customer/edit.js']);
		    });
		</script>
	
	