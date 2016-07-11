<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<form class="form-horizontal" role="form" id="validateform" name="validateform" action="<?php echo base_url('api/driver_list/edit')?>" >
	<div class='panel panel-default '>
		<div class='panel-heading'>
			<i class='fa fa-table'></i> 司机列表接口 修改信息
			<div class='panel-tools'>
				<div class='btn-group'>
					<a class="btn " href="<?php echo base_url('api/driver_list')?>"><span class="glyphicon glyphicon-arrow-left"></span> 返回 </a>
				</div>
			</div>
		</div>
		<div class='panel-body '>
								<fieldset>
						<legend>基本信息</legend>
													
	<div class="form-group">
				<label for="driver_id" class="col-sm-2 control-label form-control-static">司机id</label>
				<div class="col-sm-9 ">
					<input type="text" name="driver_id"  id="driver_id"  value='<?php echo isset($data_info['driver_id'])?$data_info['driver_id']:'' ?>'  class="form-control validate[required]"  placeholder="请输入司机id" >
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
		        require(['<?php echo SITE_URL?>scripts/api/driver_list/edit.js']);
		    });
		</script>
	
	