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
 * 项目名称：订单管理 MODEL
 * 版本号：1 
 * 最后生成时间：2016-06-27 16:07:31 
 */
class Order_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_aci_';
    	$this->table_name = 'order';
		parent::__construct();
	}
    
    /**
     * 初始化默认值
     * @return array
     */
    function default_info()
    {
    	return array(
		'order_id'=>0,
		'customer_id'=>'',
		'start_place'=>'',
		'start_place_latitude'=>'',
		'start_place_longitude'=>'',
		'end_place'=>'',
		'end_place_latitude'=>'',
		'end_place_longitude'=>'',
		'start_time'=>'',
		'truck_type'=>'',
		'truck_size'=>'',
		'charge'=>'',
		'weight'=>'',
		'infomation_charge'=>'',
		'driver_id'=>'',
		'status'=>'',
		);
    }
    
    /**
     * 安装SQL表
     * @return void
     */
    function init()
    {
    	$this->query("CREATE TABLE  IF NOT EXISTS `t_aci_order`
(
`customer_id` varchar(250) DEFAULT NULL COMMENT '货主',
`start_place` varchar(250) DEFAULT NULL COMMENT '出发地',
`start_place_latitude` varchar(250) DEFAULT NULL COMMENT '起始点纬度',
`start_place_longitude` varchar(250) DEFAULT NULL COMMENT '起始点经度',
`end_place` varchar(250) DEFAULT NULL COMMENT '目的地',
`end_place_latitude` varchar(250) DEFAULT NULL COMMENT '目的地纬度',
`end_place_longitude` varchar(250) DEFAULT NULL COMMENT '目的地经度',
`start_time` datetime DEFAULT NULL COMMENT '出发时间',
`truck_type` varchar(250) DEFAULT NULL COMMENT '车型',
`truck_size` varchar(250) DEFAULT NULL COMMENT '车长/车重',
`charge` decimal(10,2) DEFAULT '0.00' COMMENT '出价',
`weight` int(11) DEFAULT '0' COMMENT '重量',
`infomation_charge` decimal(10,2) DEFAULT '0.00' COMMENT '信息费',
`driver_id` varchar(250) DEFAULT NULL COMMENT '接单司机',
`status` varchar(250) DEFAULT NULL COMMENT '状态',
`order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
    }
    
        }

// END order_model class

/* End of file order_model.php */
/* Location: ./order_model.php */
?>