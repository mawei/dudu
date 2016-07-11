<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<div class='panel panel-default '>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 货主管理 查看信息 
        <div class='panel-tools'>
            <div class='btn-group'>
            	<a class="btn " href="<?php echo base_url('adminpanel/customer')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
            </div>
        </div>
    </div>
    <div class='panel-body '>
<div class="form-horizontal"  >
	<fieldset>
        <legend>基本信息</legend>
     
  	  	
	<div class="form-group">
				<label for="customer_type" class="col-sm-2 control-label form-control-static">货主类型</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['customer_type'])?$data_info['customer_type']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="telephone" class="col-sm-2 control-label form-control-static">手机号码</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['telephone'])?$data_info['telephone']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="name" class="col-sm-2 control-label form-control-static">姓名</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['name'])?$data_info['name']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="identity" class="col-sm-2 control-label form-control-static">身份证号</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['identity'])?$data_info['identity']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="wuliu_name" class="col-sm-2 control-label form-control-static">物流公司名称</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['wuliu_name'])?$data_info['wuliu_name']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="wuliu_license" class="col-sm-2 control-label form-control-static">物流公司营业执照</label>
				<div class="col-sm-9 ">
					<img src='<?php echo SITE_URL;?><?php echo  isset($data_info['wuliu_license'])?('upload/'.$data_info['wuliu_license']):'' ?>' width="100" />
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="company_name" class="col-sm-2 control-label form-control-static">企业名称</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['company_name'])?$data_info['company_name']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="company_license" class="col-sm-2 control-label form-control-static">营业执照</label>
				<div class="col-sm-9 ">
					<img src='<?php echo SITE_URL;?><?php echo  isset($data_info['company_license'])?('upload/'.$data_info['company_license']):'' ?>' width="100" />
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="status" class="col-sm-2 control-label form-control-static">状态</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['status'])?$data_info['status']:'' ?>
				</div>
			</div>
	  	
	<div class="form-group">
				<label for="last_login" class="col-sm-2 control-label form-control-static">最后登陆</label>
				<div class="col-sm-9 form-control-static ">
					<?php echo isset($data_info['last_login'])?$data_info['last_login']:'' ?>
				</div>
			</div>
	    </fieldset>
	</div>
</div>
</div>
