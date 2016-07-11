<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * AutoCodeIgniter.com
 *
 * 基于CodeIgniter核心模块自动生成程序
 *
 * 源项目		AutoCodeIgniter
 * 作者：		AutoCodeIgniter.com Dev Team
 * 版权：		Copyright (c) 2015 , AutoCodeIgniter com.
 * 项目名称：司机管理 MODEL
 * 版本号：1 
 * 最后生成时间：2016-06-27 14:28:02 
 */
class Driver_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_aci_';
    	$this->table_name = 'driver';
		parent::__construct();
	}
    
    /**
     * 初始化默认值
     * @return array
     */
    function default_info()
    {
    	return array(
		'driver_id'=>0,
		'telephone'=>'',
		'truck_type'=>'',
		'truck_size'=>'',
		'password'=>'',
		'truck_head_photo'=>'',
		'drive_license'=>'',
		'truck_full_photo'=>'',
		'last_login'=>'',
		'status'=>'',
		'online_status'=>'',
		'latitude'=>'',
		'longitude'=>'',
		);
    }
    
    /**
     * 安装SQL表
     * @return void
     */
    function init()
    {
    	$this->query("CREATE TABLE  IF NOT EXISTS `t_aci_driver`
(
`telephone` varchar(50) DEFAULT NULL COMMENT '手机号码',
`truck_type` varchar(250) DEFAULT NULL COMMENT '货车类型',
`truck_size` varchar(250) DEFAULT NULL COMMENT '车长/车重',
`password` varchar(50) DEFAULT NULL COMMENT '密码',
`truck_head_photo` varchar(250) DEFAULT NULL COMMENT '车头照',
`drive_license` varchar(250) DEFAULT NULL COMMENT '车辆驾驶证',
`truck_full_photo` varchar(250) DEFAULT NULL COMMENT '全车照',
`last_login` datetime DEFAULT NULL COMMENT '最后一次登陆',
`status` varchar(250) DEFAULT NULL COMMENT '用户状态',
`online_status` varchar(250) DEFAULT NULL COMMENT '在线状态',
`latitude` varchar(250) DEFAULT NULL COMMENT '纬度',
`longitude` varchar(250) DEFAULT NULL COMMENT '经度',
`driver_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`driver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
    }
    
        
    /**
     * 司机列表     * @return array
     */
    function driver_list_datasource($where='',$limit = '', $order = '', $group = '', $key='')
    {
    	$datalist = $this->select($where,'driver_id,telephone',$limit,$order,$group,$key);
        return $datalist;
    }
    
    /**
     * 司机列表选择中项值     * @return array
     */
    function driver_list_value($id=0)
    {
    	$data_info = $this->get_one(array('driver_id'=>$id),'telephone');
        if($data_info)
        {
        	return  implode("-",$data_info);
        }
        return NULL;
    }
        }

// END driver_model class

/* End of file driver_model.php */
/* Location: ./driver_model.php */
?>