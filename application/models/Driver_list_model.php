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
 * 项目名称：司机列表接口 MODEL
 * 版本号：1 
 * 最后生成时间：2016-06-30 13:27:32 
 */
class Driver_list_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_aci_';
    	$this->table_name = 'driver_list';
		parent::__construct();
	}
    
    /**
     * 初始化默认值
     * @return array
     */
    function default_info()
    {
    	return array(
		'driver_list_id'=>0,
		'driver_id'=>'',
		);
    }
    
    /**
     * 安装SQL表
     * @return void
     */
    function init()
    {
    	$this->query("CREATE TABLE  IF NOT EXISTS `t_aci_driver_list`
(
`driver_id` varchar(250) DEFAULT NULL COMMENT '司机id',
`driver_list_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`driver_list_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
    }
    
        }

// END driver_list_model class

/* End of file driver_list_model.php */
/* Location: ./driver_list_model.php */
?>