<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 货主管理列表
        <div class='panel-tools'>
            <div class='btn-group'>
                 <a class="btn " href="<?php echo base_url('adminpanel/customer/add')?>"><span class="glyphicon glyphicon-plus"></span> 添加 </a>             </div>
            <div class='badge'><?php echo count($data_list)?></div>
        </div>
    </div>
        <div class='panel-filter '>
      <div class='row'>
        <div class='col-md-12'>
        <form class="form-inline" role="form" method="get">
          
<div class="form-group">
<label for="keyword" class="control-label form-control-static">关键词</label>
<input class="form-control" type="text" name="keyword"  value="<?php echo isset($data_info['keyword'])? $data_info['keyword']:"";?>" id="keyword" placeholder="请输入关键词"/></div>

	<div class="form-group">
				<label for="status" class="col-sm-5 control-label form-control-static">状态</label>
				<div class="col-sm-7 ">
					<select class="form-control "  name="status"  id="status">
				<option value="">==不限==</option>
								<option value='未认证' <?php if(isset($data_info['status'])&&($data_info['status']=='未认证')) { ?> selected="selected" <?php } ?>            >未认证</option>
				<option value='已认证' <?php if(isset($data_info['status'])&&($data_info['status']=='已认证')) { ?> selected="selected" <?php } ?>            >已认证</option>
				<option value='锁定' <?php if(isset($data_info['status'])&&($data_info['status']=='锁定')) { ?> selected="selected" <?php } ?>            >锁定</option>
</select>
				</div>
			</div>
<button type="submit" name="dosubmit" value="搜索" class="btn btn-success"><i class='glyphicon glyphicon-search'></i></button>        </form>
        </div>
      </div> 
    </div>
          <form method="post" id="form_list"  action="<?php echo base_url('adminpanel/customer/delete_all')?>"  > 
    <div class='panel-body '>
    <?php if($data_list):?>
        <table class="table table-hover dataTable" id="checkAll">
          <thead>
            <tr>
              <th>#</th>
                            <?php $css=""; $next_url = base_url('adminpanel/customer?order=customer_type&dir=desc'); ?>
              <?php if(($order=='customer_type'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/customer?order=customer_type&dir=asc'); ?>
              <?php } elseif (($order=='customer_type'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">货主类型</th>
                            <?php $css=""; $next_url = base_url('adminpanel/customer?order=telephone&dir=desc'); ?>
              <?php if(($order=='telephone'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/customer?order=telephone&dir=asc'); ?>
              <?php } elseif (($order=='telephone'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">手机号码</th>
              <th   nowrap="nowrap">姓名</th>
              <th   nowrap="nowrap">物流公司名称</th>
              <th   nowrap="nowrap">企业名称</th>
                            <?php $css=""; $next_url = base_url('adminpanel/customer?order=status&dir=desc'); ?>
              <?php if(($order=='status'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/customer?order=status&dir=asc'); ?>
              <?php } elseif (($order=='status'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">状态</th>
                            <?php $css=""; $next_url = base_url('adminpanel/customer?order=last_login&dir=desc'); ?>
              <?php if(($order=='last_login'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/customer?order=last_login&dir=asc'); ?>
              <?php } elseif (($order=='last_login'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">最后登陆</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($data_list as $k=>$v):?>
            <tr>
              <td><input type="checkbox" name="pid[]" value="<?php echo $v['customer_id']?>" /></td>
                             <td><?php echo $v['customer_type']?></td>
                            <td><?php echo $v['telephone']?></td>
                            <td><?php echo $v['name']?></td>
                            <td><?php echo $v['wuliu_name']?></td>
                            <td><?php echo $v['company_name']?></td>
                            <td><?php echo $v['status']?></td>
                            <td><?php echo $v['last_login']?></td>
              <td>
                            	<a href="<?php echo base_url('adminpanel/customer/readonly/'.$v['customer_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-share-alt"></span> 查看</a>
                                            <a href="<?php echo base_url('adminpanel/customer/edit/'.$v['customer_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit"></span> 修改</a>
                                            <button type="button" class="btn btn-default btn-xs delete-btn" value="<?php echo $v['customer_id'];?>"><span class="glyphicon glyphicon-remove"></span> 删除</button>
                
              </td>
            </tr>
            <?php endforeach;?>
            
          </tbody>
        </table> 
    	</div>
      <div class="panel-footer">
        <div class="pull-left">
          <div class="btn-group">
                  <button type="button" class="btn btn-default" id="reverseBtn"><span class="glyphicon glyphicon-ok"></span> 反选</button>
            <button type="button" id="deleteBtn"  class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 删除勾选</button>
                 </div>
      </div>
        <div class="pull-right">
        <?php echo $pages;?>
        </div>
      </div> 
      </form>  
  </div>
<?php else:?>
    <div class="no-result">-- 暂无数据 -- </div>
<?php endif;?>

	    <script language="javascript" type="text/javascript">
    require(['<?php echo SITE_URL?>scripts/common.js'], function (common) {
        require(['<?php echo SITE_URL?>scripts/adminpanel/customer/lists.js']);
    });
</script>
    