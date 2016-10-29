<?php defined('BASEPATH') or exit('No direct script access allowed.'); ?><?php defined('BASEPATH') or exit('No permission resources.'); ?>
<div class='panel panel-default grid'>
    <div class='panel-heading'>
        <i class='fa fa-table'></i> 订单管理列表
        <div class='panel-tools'>
            <div class='btn-group'>
                 <a class="btn " href="<?php echo base_url('adminpanel/order/add')?>"><span class="glyphicon glyphicon-plus"></span> 添加 </a>             </div>
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

	<!-- <div class="form-group">
				<label for="customer_id" class="col-sm-5 control-label form-control-static">货主</label>
				<div class="col-sm-7 ">
					<?php $options = process_datasource($this->method_config['customer_list_datasource'])?>
					<select class="form-control "  name="customer_id"  id="customer_id">
						<option value="">==不限==</option>
<?php if($options)foreach($options as $option):?>
						<option value='<?php echo $option['val'];?>' <?php if(isset($data_info['customer_id'])&&($data_info['customer_id']==$option['val'])) { ?> selected="selected" <?php } ?>            ><?php echo $option['text'];?></option>
<?php endforeach;?>
					</select>

				</div>
			</div> -->

	<!-- <div class="form-group">
				<label for="driver_id" class="col-sm-5 control-label form-control-static">接单司机</label>
				<div class="col-sm-7 ">
					<?php $options = process_datasource($this->method_config['driver_list_datasource'])?>
					<select class="form-control "  name="driver_id"  id="driver_id">
						<option value="">==不限==</option>
<?php if($options)foreach($options as $option):?>
						<option value='<?php echo $option['val'];?>' <?php if(isset($data_info['driver_id'])&&($data_info['driver_id']==$option['val'])) { ?> selected="selected" <?php } ?>            ><?php echo $option['text'];?></option>
<?php endforeach;?>
					</select>

				</div>
			</div> -->

<!-- <div class="form-group">
<label >出发时间</label>
<input class="form-control datepicker" type="text" value="<?php echo isset($data_info['start_time_1'])?$data_info['start_time_1']:'' ?> " name="start_time_1"  id="start_timestart_time1"  placeholder="开始时间"/> - 
<input class="form-control datepicker" type="text" value="<?php echo isset($data_info['start_time_2'])?$data_info['start_time_2']:'' ?> " name="start_time_2"  id="start_timestart_time2"  placeholder="结束时间"/>
</div> -->

<div class="form-group">
<label for="keywords" class="form-control-static">出价:</label>
<input class="form-control" size="3" type="number"  name="charge_1"  id="chargecharge1" placeholder="出价大于等于范围"/> - <input class="form-control" size="3" type="number"  name="charge_2"  id="chargecharge2" placeholder="出价小于等于范围"/></div>
<button type="submit" name="dosubmit" value="搜索" class="btn btn-success"><i class='glyphicon glyphicon-search'></i></button>        </form>
        </div>
      </div> 
    </div>
          <form method="post" id="form_list"  action="<?php echo base_url('adminpanel/order/delete_all')?>"  > 
    <div class='panel-body '>
    <?php if($data_list):?>
        <table class="table table-hover dataTable" id="checkAll">
          <thead>
            <tr>
              <th>#</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=customer_id&dir=desc'); ?>
              <?php if(($order=='customer_id'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=customer_id&dir=asc'); ?>
              <?php } elseif (($order=='customer_id'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">货主</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=start_place&dir=desc'); ?>
              <?php if(($order=='start_place'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=start_place&dir=asc'); ?>
              <?php } elseif (($order=='start_place'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">出发地</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=end_place&dir=desc'); ?>
              <?php if(($order=='end_place'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=end_place&dir=asc'); ?>
              <?php } elseif (($order=='end_place'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">目的地</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=start_time&dir=desc'); ?>
              <?php if(($order=='start_time'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=start_time&dir=asc'); ?>
              <?php } elseif (($order=='start_time'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">出发时间</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=truck_type&dir=desc'); ?>
              <?php if(($order=='truck_type'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=truck_type&dir=asc'); ?>
              <?php } elseif (($order=='truck_type'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">车型</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=truck_size&dir=desc'); ?>
              <?php if(($order=='truck_size'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=truck_size&dir=asc'); ?>
              <?php } elseif (($order=='truck_size'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">车长/车重</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=charge&dir=desc'); ?>
              <?php if(($order=='charge'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=charge&dir=asc'); ?>
              <?php } elseif (($order=='charge'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">出价</th>
              <th   nowrap="nowrap">重量</th>
                            <?php $css=""; $next_url = base_url('adminpanel/order?order=status&dir=desc'); ?>
              <?php if(($order=='status'&&$dir=='desc')) { ?>
              <?php $css="sorting_desc";$next_url = base_url('adminpanel/order?order=status&dir=asc'); ?>
              <?php } elseif (($order=='status'&&$dir=='asc')) { ?>
              <?php $css="sorting_asc";?>
              <?php } ?><th class="sorting <?php echo $css;?>"   onclick="window.location.href='<?php echo $next_url;?>'"   nowrap="nowrap">状态</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($data_list as $k=>$v):?>
            <tr>
              <td><input type="checkbox" name="pid[]" value="<?php echo $v['order_id']?>" /></td>
                             <td><?php echo $v['customer_id']?></td>
                            <td><?php echo $v['start_place']?></td>
                            <td><?php echo $v['end_place']?></td>
                            <td><?php echo $v['start_time']?></td>
                            <td><?php echo $v['truck_type']?></td>
                            <td><?php echo $v['truck_size']?></td>
                            <td><?php echo $v['charge']?></td>
                            <td><?php echo $v['weight']?></td>
                            <td><?php echo $v['status']?></td>
              <td>
                            	<a href="<?php echo base_url('adminpanel/order/readonly/'.$v['order_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-share-alt"></span> 查看</a>
                                            <a href="<?php echo base_url('adminpanel/order/edit/'.$v['order_id'])?>"  class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit"></span> 修改</a>
                                            <button type="button" class="btn btn-default btn-xs delete-btn" value="<?php echo $v['order_id'];?>"><span class="glyphicon glyphicon-remove"></span> 删除</button>
                
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
        require(['<?php echo SITE_URL?>scripts/adminpanel/order/lists.js']);
    });
</script>
    