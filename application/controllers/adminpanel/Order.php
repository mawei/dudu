<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * AutoCodeIgniter.com
 *
 * 基于CodeIgniter核心模块自动生成程序
 *
 * 源项目		AutoCodeIgniter
 * 作者：		AutoCodeIgniter.com Dev Team EMAIL:hubinjie@outlook.com QQ:5516448
 * 版权：		Copyright (c) 2015 , AutoCodeIgniter com.
 * 项目名称：订单管理 
 * 版本号：1 
 * 最后生成时间：2016-06-27 16:07:31 
 */
class Order extends Admin_Controller {
	
    var $method_config;
    function __construct()
	{
		parent::__construct();
		$this->load->model(array('Customer_model','Driver_model','order_model'));
        $this->load->helper(array('auto_codeIgniter_helper','array'));
  
  
        //保证排序安全性
        $this->method_config['sort_field'] = array(
										'customer_id'=>'customer_id',
										'start_place'=>'start_place',
										'end_place'=>'end_place',
										'start_time'=>'start_time',
										'truck_type'=>'truck_type',
										'truck_size'=>'truck_size',
										'charge'=>'charge',
										'driver_id'=>'driver_id',
										'status'=>'status',
										);
	 	$this->method_config['customer_list_datasource'] = $this->Customer_model->customer_list_datasource();
	 	$this->method_config['driver_list_datasource'] = $this->Driver_model->driver_list_datasource();
	}
    
    /**
     * 默认首页列表
     * @param int $pageno 当前页码
     * @return void
     */
    function index($page_no=0,$sort_id=0)
    {
        $user_name = $this->session->userdata('user_name');
        $group_id = $this->session->userdata('group_id');
        $customer_id = $this->session->userdata('user_id');


    	$page_no = max(intval($page_no),1);
        
        $orderby = "order_id desc";
        $dir = $order=  NULL;
		$order=isset($_GET['order'])?safe_replace(trim($_GET['order'])):'';
		$dir=isset($_GET['dir'])?safe_replace(trim($_GET['dir'])):'asc';
        
        if(trim($order)!="")
        {
        	//如果找到得
        	if(isset($this->method_config['sort_field'][strtolower($order)]))
            {
            	if(strtolower($dir)=="asc")
            		$orderby = $this->method_config['sort_field'][strtolower($order)]." asc," .$orderby;
                 else
            		$orderby = $this->method_config['sort_field'][strtolower($order)]." desc," .$orderby;
            }
        }
        $where = "";
        if($group_id == "3") $where = "customer_id = ".$customer_id;
        $_arr = NULL;//从URL GET
        if (isset($_GET['dosubmit'])) {
        	$where_arr = NULL;
			$_arr['keyword'] =isset($_GET['keyword'])?safe_replace(trim($_GET['keyword'])):'';
			if($_arr['keyword']!="") $where_arr[] = "concat(start_place,end_place,truck_type,truck_size,status) like '%{$_arr['keyword']}%'";
                
			$_arr['customer_id'] = isset($_GET["customer_id"])?trim(safe_replace($_GET["customer_id"])):'';
        	if($_arr['customer_id']!="") $where_arr[] = "customer_id = '".$_arr['customer_id']."'";

        	$_arr['driver_id'] = isset($_GET["driver_id"])?trim(safe_replace($_GET["driver_id"])):'';
        	if($_arr['driver_id']!="") $where_arr[] = "driver_id = '".$_arr['driver_id']."'";

        	$_arr['start_time_1'] =isset($_GET['start_time_1'])?safe_replace(trim($_GET['start_time_1'])):'';
        	$_arr['start_time_2'] =isset($_GET['start_time_2'])?safe_replace(trim($_GET['start_time_2'])):'';
            if($_arr['start_time_1']!="") $where_arr[] = "(start_time >= '".$_arr['start_time_1']."')";
        	if($_arr['start_time_2']!="") $where_arr[] = "(start_time <= '".$_arr['start_time_2']." 23:59:59')";
                
        	
        	$_arr['charge_1'] =isset($_GET['charge_1'])?intval($_GET['charge_1']):'';
        	$_arr['charge_2'] =isset($_GET['charge_2'])?intval($_GET['charge_2']):'';
            if($_arr['charge_1']!="") $where_arr[] = "(charge >= ".$_arr['charge_1'].")";
        	if($_arr['charge_2']!="") $where_arr[] = "(charge <= ".$_arr['charge_2'].")";
            if($group_id == "3") $where_arr[] = "(customer_id = ".$customer_id.")";
        	if($where_arr)$where = implode(" and ",$where_arr);
        }

        	$data_list = $this->order_model->listinfo($where,'*',$orderby , $page_no, $this->order_model->page_size,'',$this->order_model->page_size,page_list_url('adminpanel/order/index',true));
        if($data_list)
        {
            	foreach($data_list as $k=>$v)
            	{
					$data_list[$k] = $this->_process_datacorce_value($v);
            	}
        }
    	$this->view('lists',array('require_js'=>true,'data_info'=>$_arr,'order'=>$order,'dir'=>$dir,'data_list'=>$data_list,'pages'=>$this->order_model->pages));
    }
    
    /**
     * 处理数据源结
     * @param array v 
     * @return array
     */
    function _process_datacorce_value($v,$is_edit_model=false)
    {
			if(isset($v['customer_id']))
            {
            	//如果编辑模式
            	if($is_edit_model)
            		$v['customer_id_text'] = $this->Customer_model->customer_list_value($v["customer_id"]);                    
                else
                	$v['customer_id'] = $this->Customer_model->customer_list_value($v["customer_id"]);                    
             }
                    
			if(isset($v['driver_id']))
            {
            	//如果编辑模式
            	if($is_edit_model)
            		$v['driver_id_text'] = $this->Driver_model->driver_list_value($v["driver_id"]);                    
                else
                	$v['driver_id'] = $this->Driver_model->driver_list_value($v["driver_id"]);                    
             }
                    
         return $v;
    }
     /**
     * 新增数据
     * @param AJAX POST 
     * @return void
     */
    function add()
    {
    	//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
        	//接收POST参数
			// $_arr['customer_id'] = isset($_POST["customer_id"])?trim(safe_replace($_POST["customer_id"])):exit(json_encode(array('status'=>false,'tips'=>'货主必填')));
			// if($_arr['customer_id']=='')exit(json_encode(array('status'=>false,'tips'=>'货主必填')));
			$_arr['start_place'] = isset($_POST["start_place"])?trim(safe_replace($_POST["start_place"])):exit(json_encode(array('status'=>false,'tips'=>'出发地必填')));
			if($_arr['start_place']=='')exit(json_encode(array('status'=>false,'tips'=>'出发地必填')));
			$_arr['start_place_latitude'] = isset($_POST["start_place_latitude"])?trim(safe_replace($_POST["start_place_latitude"])):'';
			$_arr['start_place_longitude'] = isset($_POST["start_place_longitude"])?trim(safe_replace($_POST["start_place_longitude"])):'';
			$_arr['end_place'] = isset($_POST["end_place"])?trim(safe_replace($_POST["end_place"])):exit(json_encode(array('status'=>false,'tips'=>'目的地必填')));
			if($_arr['end_place']=='')exit(json_encode(array('status'=>false,'tips'=>'目的地必填')));
			$_arr['end_place_latitude'] = isset($_POST["end_place_latitude"])?trim(safe_replace($_POST["end_place_latitude"])):'';
			$_arr['end_place_longitude'] = isset($_POST["end_place_longitude"])?trim(safe_replace($_POST["end_place_longitude"])):'';
			$_arr['start_time'] = isset($_POST["start_time"])?trim(safe_replace($_POST["start_time"])):exit(json_encode(array('status'=>false,'tips'=>'出发时间必填')));
			if($_arr['start_time']=='')exit(json_encode(array('status'=>false,'tips'=>'出发时间必填')));
			if($_arr['start_time']!=''){
			if(!is_datetime($_arr['start_time']))exit(json_encode(array('status'=>false,'tips'=>'出发时间输入错误')));
			}
			$_arr['truck_type'] = isset($_POST["truck_type"])?trim(safe_replace($_POST["truck_type"])):exit(json_encode(array('status'=>false,'tips'=>'车型必填')));
			if($_arr['truck_type']=='')exit(json_encode(array('status'=>false,'tips'=>'车型必填')));
            $_arr['truck_size'] = isset($_POST["truck_size"])?$_POST["truck_size"]:'';
            if(is_array($_arr['truck_size'])) $_arr['truck_size'] = implode(",",$_arr['truck_size']);
			if($_arr['truck_size']=='')exit(json_encode(array('status'=>false,'tips'=>'车长/车重必填')));
			$_arr['charge'] = isset($_POST["charge"])?trim(safe_replace($_POST["charge"])):exit(json_encode(array('status'=>false,'tips'=>'出价必填')));
			if($_arr['charge']=='')exit(json_encode(array('status'=>false,'tips'=>'出价必填')));
			if($_arr['charge']!=''){
			if(!is_price($_arr['charge']))exit(json_encode(array('status'=>false,'tips'=>'出价输入错误')));
			}
			$_arr['weight'] = isset($_POST["weight"])?trim(safe_replace($_POST["weight"])):exit(json_encode(array('status'=>false,'tips'=>'重量必填')));
			if($_arr['weight']=='')exit(json_encode(array('status'=>false,'tips'=>'重量必填')));
			if($_arr['weight']!=''){
			if(!is_number($_arr['weight']))exit(json_encode(array('status'=>false,'tips'=>'重量输入错误')));
			}
			// $_arr['infomation_charge'] = isset($_POST["infomation_charge"])?trim(safe_replace($_POST["infomation_charge"])):'';
			// if($_arr['infomation_charge']!=''){
			// if(!is_price($_arr['infomation_charge']))exit(json_encode(array('status'=>false,'tips'=>'信息费输入错误')));
			// }
			// $_arr['driver_id'] = isset($_POST["driver_id"])?trim(safe_replace($_POST["driver_id"])):'';
			$_arr['status'] = "未接单";

            //地点
            $start_place['state'] = isset($_POST["start_state"])?trim(safe_replace($_POST["start_state"])):exit(json_encode(array('status'=>false,'tips'=>'出发地请从自动提示框中选择')));
            $start_place['city'] = isset($_POST["start_city"])?trim(safe_replace($_POST["start_city"])):exit(json_encode(array('status'=>false,'tips'=>'出发地请从自动提示框中选择')));
            $start_place['area'] = isset($_POST["start_area"])?trim(safe_replace($_POST["start_area"])):exit(json_encode(array('status'=>false,'tips'=>'出发地请从自动提示框中选择')));
            $start_place['latitude'] = isset($_POST["start_latitude"])?trim(safe_replace($_POST["start_latitude"])):exit(json_encode(array('status'=>false,'tips'=>'出发地请从自动提示框中选择')));
            $start_place['longitude'] = isset($_POST["start_longitude"])?trim(safe_replace($_POST["start_longitude"])):exit(json_encode(array('status'=>false,'tips'=>'出发地请从自动提示框中选择')));
            $start_place['address'] = $start_place['state'] == $start_place['city'] ? $start_place['state'] . $start_place['area'] . $start_place['street'] : $start_place['state'] . $start_place['city'] . $start_place['area'] . $start_place['street'];
            $start_place['type'] = "出发地";
            if($start_place['state'] == '')exit(json_encode(array('status'=>false,'tips'=>'出发地请从自动提示框中选择')));


            //地点
            $end_place['state'] = isset($_POST["end_state"])?trim(safe_replace($_POST["end_state"])):exit(json_encode(array('status'=>false,'tips'=>'目的地请从自动提示框中选择')));
            $end_place['city'] = isset($_POST["end_city"])?trim(safe_replace($_POST["end_city"])):exit(json_encode(array('status'=>false,'tips'=>'目的地请从自动提示框中选择')));
            $end_place['area'] = isset($_POST["end_area"])?trim(safe_replace($_POST["end_area"])):exit(json_encode(array('status'=>false,'tips'=>'目的地请从自动提示框中选择')));
            $end_place['latitude'] = isset($_POST["end_latitude"])?trim(safe_replace($_POST["end_latitude"])):exit(json_encode(array('status'=>false,'tips'=>'目的地请从自动提示框中选择')));
            $end_place['longitude'] = isset($_POST["end_longitude"])?trim(safe_replace($_POST["end_longitude"])):exit(json_encode(array('status'=>false,'tips'=>'目的地请从自动提示框中选择')));
            $end_place['address'] = $end_place['state'] == $end_place['city'] ? $end_place['state'] . $end_place['area'] . $end_place['street'] : $end_place['state'] . $end_place['city'] . $end_place['area'] . $end_place['street'];
            $end_place['type'] = "目的地";
			if($end_place['state'] == '')exit(json_encode(array('status'=>false,'tips'=>'目的地请从自动提示框中选择')));

            $new_id = $this->order_model->insert($_arr);
            if($new_id)
            {
                $start_place['order_id'] = $new_id;
                $end_place['order_id'] = $new_id;
                $this->db->insert('t_aci_address',$start_place);
                $this->db->insert('t_aci_address',$end_place);
				exit(json_encode(array('status'=>true,'tips'=>'信息新增成功','new_id'=>$new_id)));
            }else
            {
            	exit(json_encode(array('status'=>false,'tips'=>'信息新增失败','new_id'=>0)));
            }
        }else
        {
        	$this->view('edit',array('require_js'=>true,'is_edit'=>false,'id'=>0,'data_info'=>$this->order_model->default_info()));
        }
    }
     /**
     * 删除单个数据
     * @param int id 
     * @return void
     */
    function delete_one($id=0)
    {
    	$id = intval($id);
        $data_info =$this->order_model->get_one(array('order_id'=>$id));
        if(!$data_info)$this->showmessage('信息不存在');
        $status = $this->order_model->delete(array('order_id'=>$id));
        if($status)
        {
        	$this->showmessage('删除成功');
        }else
        	$this->showmessage('删除失败');
    }

    /**
     * 删除选中数据
     * @param post pid 
     * @return void
     */
    function delete_all()
    {
        if(isset($_POST))
		{
			$pidarr = isset($_POST['pid']) ? $_POST['pid'] : $this->showmessage('无效参数', HTTP_REFERER);
			$where = $this->order_model->to_sqls($pidarr, '', 'order_id');
			$status = $this->order_model->delete($where);
			if($status)
			{
				$this->showmessage('操作成功', HTTP_REFERER);
			}else 
			{
				$this->showmessage('操作失败');
			}
		}
    }
     /**
     * 修改数据
     * @param int id 
     * @return void
     */
    function edit($id=0)
    {
    	$id = intval($id);
        
        $data_info =$this->order_model->get_one(array('order_id'=>$id));
    	//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
        	if(!$data_info)exit(json_encode(array('status'=>false,'tips'=>'信息不存在')));
        	//接收POST参数
			$_arr['customer_id'] = isset($_POST["customer_id"])?trim(safe_replace($_POST["customer_id"])):exit(json_encode(array('status'=>false,'tips'=>'货主必填')));
			if($_arr['customer_id']=='')exit(json_encode(array('status'=>false,'tips'=>'货主必填')));
			$_arr['start_place'] = isset($_POST["start_place"])?trim(safe_replace($_POST["start_place"])):exit(json_encode(array('status'=>false,'tips'=>'出发地必填')));
			if($_arr['start_place']=='')exit(json_encode(array('status'=>false,'tips'=>'出发地必填')));
			$_arr['start_place_latitude'] = isset($_POST["start_place_latitude"])?trim(safe_replace($_POST["start_place_latitude"])):'';
			$_arr['start_place_longitude'] = isset($_POST["start_place_longitude"])?trim(safe_replace($_POST["start_place_longitude"])):'';
			$_arr['end_place'] = isset($_POST["end_place"])?trim(safe_replace($_POST["end_place"])):exit(json_encode(array('status'=>false,'tips'=>'目的地必填')));
			if($_arr['end_place']=='')exit(json_encode(array('status'=>false,'tips'=>'目的地必填')));
			$_arr['end_place_latitude'] = isset($_POST["end_place_latitude"])?trim(safe_replace($_POST["end_place_latitude"])):'';
			$_arr['end_place_longitude'] = isset($_POST["end_place_longitude"])?trim(safe_replace($_POST["end_place_longitude"])):'';
			$_arr['start_time'] = isset($_POST["start_time"])?trim(safe_replace($_POST["start_time"])):exit(json_encode(array('status'=>false,'tips'=>'出发时间必填')));
			if($_arr['start_time']=='')exit(json_encode(array('status'=>false,'tips'=>'出发时间必填')));
			if($_arr['start_time']!=''){
			if(!is_datetime($_arr['start_time']))exit(json_encode(array('status'=>false,'tips'=>'出发时间输入错误')));
			}
			$_arr['truck_type'] = isset($_POST["truck_type"])?trim(safe_replace($_POST["truck_type"])):exit(json_encode(array('status'=>false,'tips'=>'车型必填')));
			if($_arr['truck_type']=='')exit(json_encode(array('status'=>false,'tips'=>'车型必填')));
			$_arr['truck_size'] = isset($_POST["truck_size"])?trim(safe_replace($_POST["truck_size"])):exit(json_encode(array('status'=>false,'tips'=>'车长/车重必填')));
			if($_arr['truck_size']=='')exit(json_encode(array('status'=>false,'tips'=>'车长/车重必填')));
			$_arr['charge'] = isset($_POST["charge"])?trim(safe_replace($_POST["charge"])):exit(json_encode(array('status'=>false,'tips'=>'出价必填')));
			if($_arr['charge']=='')exit(json_encode(array('status'=>false,'tips'=>'出价必填')));
			if($_arr['charge']!=''){
			if(!is_price($_arr['charge']))exit(json_encode(array('status'=>false,'tips'=>'出价输入错误')));
			}
			$_arr['weight'] = isset($_POST["weight"])?trim(safe_replace($_POST["weight"])):exit(json_encode(array('status'=>false,'tips'=>'重量必填')));
			if($_arr['weight']=='')exit(json_encode(array('status'=>false,'tips'=>'重量必填')));
			if($_arr['weight']!=''){
			if(!is_number($_arr['weight']))exit(json_encode(array('status'=>false,'tips'=>'重量输入错误')));
			}
			$_arr['infomation_charge'] = isset($_POST["infomation_charge"])?trim(safe_replace($_POST["infomation_charge"])):'';
			if($_arr['infomation_charge']!=''){
			if(!is_price($_arr['infomation_charge']))exit(json_encode(array('status'=>false,'tips'=>'信息费输入错误')));
			}
			$_arr['driver_id'] = isset($_POST["driver_id"])?trim(safe_replace($_POST["driver_id"])):'';
			$_arr['status'] = isset($_POST["status"])?trim(safe_replace($_POST["status"])):'';
			
            $status = $this->order_model->update($_arr,array('order_id'=>$id));
            if($status)
            {
				exit(json_encode(array('status'=>true,'tips'=>'信息修改成功')));
            }else
            {
            	exit(json_encode(array('status'=>false,'tips'=>'信息修改失败')));
            }
        }else
        {
        	if(!$data_info)$this->showmessage('信息不存在');
            $data_info = $this->_process_datacorce_value($data_info,true);
        	$this->view('edit',array('require_js'=>true,'data_info'=>$data_info,'is_edit'=>true,'id'=>$id));
        }
    }
 
  
     /**
     * 只读查看数据
     * @param int id 
     * @return void
     */
    function readonly($id=0)
    {
    	$id = intval($id);
        $data_info =$this->order_model->get_one(array('order_id'=>$id));
        if(!$data_info)$this->showmessage('信息不存在');
		$data_info = $this->_process_datacorce_value($data_info);
        
        $this->view('readonly',array('require_js'=>true,'data_info'=>$data_info));
    }

}

// END order class

/* End of file order.php */
/* Location: ./order.php */
?>