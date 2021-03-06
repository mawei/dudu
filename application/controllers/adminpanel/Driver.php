<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/../'.'Notification.php';
/**
 * AutoCodeIgniter.com
 *
 * 基于CodeIgniter核心模块自动生成程序
 *
 * 源项目		AutoCodeIgniter
 * 作者：		AutoCodeIgniter.com Dev Team EMAIL:hubinjie@outlook.com QQ:5516448
 * 版权：		Copyright (c) 2015 , AutoCodeIgniter com.
 * 项目名称：司机管理 
 * 版本号：1 
 * 最后生成时间：2016-06-27 14:28:02 
 */
class Driver extends Admin_Controller {
	
    var $method_config;
    function __construct()
	{
		parent::__construct();
		$this->load->model(array('driver_model'));
        $this->load->helper(array('auto_codeIgniter_helper','array'));
        
        $this->method_config['upload'] = array(
										'truck_head_photo'=>array('upload_size'=>10000,'upload_file_type'=>'jpg|png|gif','upload_path'=>'upload','upload_url'=>'upload'),
										'drive_license'=>array('upload_size'=>10000,'upload_file_type'=>'jpg|png|gif','upload_path'=>'upload','upload_url'=>'upload'),
										'truck_full_photo'=>array('upload_size'=>10000,'upload_file_type'=>'jpg|png|gif','upload_path'=>'upload','upload_url'=>'upload'),
										);
  
  
        //保证排序安全性
        $this->method_config['sort_field'] = array(
										'telephone'=>'telephone',
										'truck_type'=>'truck_type',
										'truck_size'=>'truck_size',
										'status'=>'status',
										'online_status'=>'online_status',
										);
	}
    
    /**
     * 默认首页列表
     * @param int $pageno 当前页码
     * @return void
     */
    function index($page_no=0,$sort_id=0)
    {
    	$page_no = max(intval($page_no),1);
        
        $orderby = "driver_id desc";
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
                
        $where ="";
        $_arr = NULL;//从URL GET
        if (isset($_GET['dosubmit'])) {
        	$where_arr = NULL;
			$_arr['keyword'] =isset($_GET['keyword'])?safe_replace(trim($_GET['keyword'])):'';
			if($_arr['keyword']!="") $where_arr[] = "concat(telephone,truck_type,truck_size,online_status) like '%{$_arr['keyword']}%'";
                
			$_arr['status'] = isset($_GET["status"])?trim(safe_replace($_GET["status"])):'';
        	if($_arr['status']!="") $where_arr[] = "status = '".$_arr['status']."'";

                
        
		        
        	if($where_arr)$where = implode(" and ",$where_arr);
        }

        	$data_list = $this->driver_model->listinfo($where,'*',$orderby , $page_no, $this->driver_model->page_size,'',$this->driver_model->page_size,page_list_url('adminpanel/driver/index',true));
        if($data_list)
        {
            	foreach($data_list as $k=>$v)
            	{
					$data_list[$k] = $this->_process_datacorce_value($v);
            	}
        }
    	$this->view('lists',array('require_js'=>true,'data_info'=>$_arr,'order'=>$order,'dir'=>$dir,'data_list'=>$data_list,'pages'=>$this->driver_model->pages));
    }
    
    /**
     * 处理数据源结
     * @param array v 
     * @return array
     */
    function _process_datacorce_value($v,$is_edit_model=false)
    {
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
			$_arr['telephone'] = isset($_POST["telephone"])?trim(safe_replace($_POST["telephone"])):exit(json_encode(array('status'=>false,'tips'=>'手机号码必填')));
			if($_arr['telephone']=='')exit(json_encode(array('status'=>false,'tips'=>'手机号码必填')));
			if($_arr['telephone']!=''){
			if(!is_mobile($_arr['telephone']))exit(json_encode(array('status'=>false,'tips'=>'手机号码输入错误')));
			}
			$_arr['truck_type'] = isset($_POST["truck_type"])?trim(safe_replace($_POST["truck_type"])):exit(json_encode(array('status'=>false,'tips'=>'货车类型必填')));
			if($_arr['truck_type']=='')exit(json_encode(array('status'=>false,'tips'=>'货车类型必填')));
			$_arr['truck_size'] = isset($_POST["truck_size"])?trim(safe_replace($_POST["truck_size"])):exit(json_encode(array('status'=>false,'tips'=>'车长/车重必填')));
			if($_arr['truck_size']=='')exit(json_encode(array('status'=>false,'tips'=>'车长/车重必填')));
				$_arr['password'] = isset($_POST["password"])?trim(safe_replace($_POST["password"])):exit(json_encode(array('status'=>false,'tips'=>'密码必填')));;
	$_arr['o_password'] = isset($_POST["o_password"])?trim(safe_replace($_POST["o_password"])):exit(json_encode(array('status'=>false,'tips'=>'密码必填')));;
			if(trim($_arr['o_password'])!=trim($_arr['password'])){
			exit(json_encode(array('status'=>false,'tips'=>'密码两次输入不就致')));;
}
			unset($_arr['o_password']);

			 $_arr['password'] = md5(md5($_arr['password']));
			if($_arr['password']=='')exit(json_encode(array('status'=>false,'tips'=>'密码必填')));
			$_arr['truck_head_photo'] = isset($_POST["truck_head_photo"])?trim(safe_replace($_POST["truck_head_photo"])):'';
			$_arr['drive_license'] = isset($_POST["drive_license"])?trim(safe_replace($_POST["drive_license"])):'';
			$_arr['truck_full_photo'] = isset($_POST["truck_full_photo"])?trim(safe_replace($_POST["truck_full_photo"])):'';
			$_arr['last_login'] = isset($_POST["last_login"])?trim(safe_replace($_POST["last_login"])):'';
			if($_arr['last_login']!=''){
			if(!is_datetime($_arr['last_login']))exit(json_encode(array('status'=>false,'tips'=>'最后一次登陆输入错误')));
			}
			$_arr['status'] = isset($_POST["status"])?trim(safe_replace($_POST["status"])):exit(json_encode(array('status'=>false,'tips'=>'用户状态必填')));
			if($_arr['status']=='')exit(json_encode(array('status'=>false,'tips'=>'用户状态必填')));
			$_arr['online_status'] = isset($_POST["online_status"])?trim(safe_replace($_POST["online_status"])):'';
			$_arr['latitude'] = isset($_POST["latitude"])?trim(safe_replace($_POST["latitude"])):'';
			$_arr['longitude'] = isset($_POST["longitude"])?trim(safe_replace($_POST["longitude"])):'';
			
            $new_id = $this->driver_model->insert($_arr);
            if($new_id)
            {
				exit(json_encode(array('status'=>true,'tips'=>'信息新增成功','new_id'=>$new_id)));
            }else
            {
            	exit(json_encode(array('status'=>false,'tips'=>'信息新增失败','new_id'=>0)));
            }
        }else
        {
        	$this->view('edit',array('require_js'=>true,'is_edit'=>false,'id'=>0,'data_info'=>$this->driver_model->default_info()));
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
        $data_info =$this->driver_model->get_one(array('driver_id'=>$id));
        if(!$data_info)$this->showmessage('信息不存在');
        $status = $this->driver_model->delete(array('driver_id'=>$id));
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
			$where = $this->driver_model->to_sqls($pidarr, '', 'driver_id');
			$status = $this->driver_model->delete($where);
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
        
        $data_info =$this->driver_model->get_one(array('driver_id'=>$id));
    	//如果是AJAX请求
    	if($this->input->is_ajax_request())
		{
        	if(!$data_info)exit(json_encode(array('status'=>false,'tips'=>'信息不存在')));
        	//接收POST参数
			$_arr['telephone'] = isset($_POST["telephone"])?trim(safe_replace($_POST["telephone"])):exit(json_encode(array('status'=>false,'tips'=>'手机号码必填')));
			if($_arr['telephone']=='')exit(json_encode(array('status'=>false,'tips'=>'手机号码必填')));
			if($_arr['telephone']!=''){
			if(!is_mobile($_arr['telephone']))exit(json_encode(array('status'=>false,'tips'=>'手机号码输入错误')));
			}
			$_arr['truck_type'] = isset($_POST["truck_type"])?trim(safe_replace($_POST["truck_type"])):exit(json_encode(array('status'=>false,'tips'=>'货车类型必填')));
			if($_arr['truck_type']=='')exit(json_encode(array('status'=>false,'tips'=>'货车类型必填')));
			$_arr['truck_size'] = isset($_POST["truck_size"])?trim(safe_replace($_POST["truck_size"])):exit(json_encode(array('status'=>false,'tips'=>'车长/车重必填')));
			if($_arr['truck_size']=='')exit(json_encode(array('status'=>false,'tips'=>'车长/车重必填')));
				$_arr['password'] = isset($_POST["password"])?trim(safe_replace($_POST["password"])):exit(json_encode(array('status'=>false,'tips'=>'密码必填')));;
	$_arr['o_password'] = isset($_POST["o_password"])?trim(safe_replace($_POST["o_password"])):exit(json_encode(array('status'=>false,'tips'=>'密码必填')));;
			if(trim($_arr['o_password'])!=trim($_arr['password'])){
			exit(json_encode(array('status'=>false,'tips'=>'密码两次输入不就致')));;
}
			unset($_arr['o_password']);

			 if(trim($_arr['password']) == "")unset($_arr['password']);
			 else $_arr['password'] = md5(md5($_arr['password']));
			$_arr['truck_head_photo'] = isset($_POST["truck_head_photo"])?trim(safe_replace($_POST["truck_head_photo"])):'';
			$_arr['drive_license'] = isset($_POST["drive_license"])?trim(safe_replace($_POST["drive_license"])):'';
			$_arr['truck_full_photo'] = isset($_POST["truck_full_photo"])?trim(safe_replace($_POST["truck_full_photo"])):'';
			$_arr['last_login'] = isset($_POST["last_login"])?trim(safe_replace($_POST["last_login"])):'';
			if($_arr['last_login']!=''){
			if(!is_datetime($_arr['last_login']))exit(json_encode(array('status'=>false,'tips'=>'最后一次登陆输入错误')));
			}
			$_arr['status'] = isset($_POST["status"])?trim(safe_replace($_POST["status"])):exit(json_encode(array('status'=>false,'tips'=>'用户状态必填')));
			if($_arr['status']=='')exit(json_encode(array('status'=>false,'tips'=>'用户状态必填')));
			$_arr['online_status'] = isset($_POST["online_status"])?trim(safe_replace($_POST["online_status"])):'';
			$_arr['latitude'] = isset($_POST["latitude"])?trim(safe_replace($_POST["latitude"])):'';
			$_arr['longitude'] = isset($_POST["longitude"])?trim(safe_replace($_POST["longitude"])):'';
			
            $status = $this->driver_model->update($_arr,array('driver_id'=>$id));
            if($status)
            {
                if($data_info['status'] != $_arr['status'] && $_arr['status'] == "认证成功")
                {
                    $this->sms_content($data_info['telephone'],"【嘟嘟找货】恭喜您已通过车主认证");
                }
                if($data_info['status'] != $_arr['status'] && $_arr['status'] == "认证失败")
                {
                    $this->sms_content($data_info['telephone'],"【嘟嘟找货】您未通过车主认证，请登录app后查看原因后重新认证");
                }
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
        $data_info =$this->driver_model->get_one(array('driver_id'=>$id));
        if(!$data_info)$this->showmessage('信息不存在');
		$data_info = $this->_process_datacorce_value($data_info);
        
        $this->view('readonly',array('require_js'=>true,'data_info'=>$data_info));
    }
  
    
     /**
     * 上传附件
     * @param string $fieldName 字段名
     * @param string $controlId HTML控件ID
     * @param string $callbackJSfunction 是否返回函数
     * @return void
     */
	function upload($isImage=true,$fieldName='',$controlId='',$callbackJSfunction=false)
	{
    	if( isset($this->method_config['upload'][$fieldName]))
        {
        	if(isset($_POST['dosubmit']))
            {
                $upload_path = $this->method_config['upload'][$fieldName]['upload_path'];
               
               
               if($upload_path=='')die('缺少上传参数');
               
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = $this->method_config['upload'][$fieldName]['upload_file_type'];
                $config['max_size'] = $this->method_config['upload'][$fieldName]['upload_size'];
                $config['overwrite']  = FALSE;
                $config['encrypt_name']=false;
                $config['file_name']=date('Ymdhis').random_string('nozero',4);
               
                dir_create($upload_path);//创建正式文件夹
                $this->load->library('upload', $config);
                 
                if ( ! $this->upload->do_upload('upload')) $this->showmessage("上传失败:".$this->upload->display_errors());
                $filedata =  $this->upload->data();
                
                $file_name = $filedata['file_name'];
                $file_size = $filedata['file_size'];
                $image_width = $isImage?$filedata['image_width']:0;
                $image_height =  $isImage?$filedata['image_height']:0;
                $uc_first_id=  ucfirst($controlId);
                $this->showmessage("上传成功！",'','','',$callbackJSfunction?"window.parent.get{$uc_first_id}(\"$file_name\",\"$file_size\",\"$image_width\",\"$image_height\");":"$(window.parent.document).find(\"#$controlId\").val(\"$file_name\");$(\"#dialog\" ).dialog(\"close\")");	
            }else
            {
            	$this->view('upload',array('require_js'=>true,'hidden_menu'=>true,'field_name'=>$fieldName,'control_id'=>$controlId,'upload_url'=>$this->method_config['upload'][$fieldName]['upload_url'],'is_image'=>$isImage));
            }
        }else
        {
        	die('缺少上传参数');
        }
	}

    private function sms_content($mobile, $content) {
        $url = "http://yunpian.com/v1/sms/send.json";
        $encoded_text = urlencode ( "$content" );
        $post_string = "apikey=355e91e02a95574559ebba5a3c1af6c2&text=$content&mobile=$mobile";
        return $this->sock_post ( $url, $post_string );
    }
    
    /**
     * url 为服务的url地址
     * query 为请求串
     */
    function sock_post($url, $query) {
        $data = "";
        $info = parse_url ( $url );
        $fp = fsockopen ( $info ["host"], 80, $errno, $errstr, 30 );
        if (! $fp) {
            return $data;
        }
        $head = "POST " . $info ['path'] . " HTTP/1.0\r\n";
        $head .= "Host: " . $info ['host'] . "\r\n";
        $head .= "Referer: http://" . $info ['host'] . $info ['path'] . "\r\n";
        $head .= "Content-type: application/x-www-form-urlencoded\r\n";
        $head .= "Content-Length: " . strlen ( trim ( $query ) ) . "\r\n";
        $head .= "\r\n";
        $head .= trim ( $query );
        $write = fputs ( $fp, $head );
        $header = "";
        while ( $str = trim ( fgets ( $fp, 4096 ) ) ) {
            $header .= $str;
        }
        while ( ! feof ( $fp ) ) {
            $data .= fgets ( $fp, 4096 );
        }
        return $data;
    }

}

// END driver class

/* End of file driver.php */
/* Location: ./driver.php */
?>