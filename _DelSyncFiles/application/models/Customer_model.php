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
 * 项目名称：货主管理 MODEL
 * 版本号：1 
 * 最后生成时间：2016-06-27 15:44:01 
 */
class Customer_model extends Base_Model {
	
    var $page_size = 10;
    function __construct()
	{
    	$this->db_tablepre = 't_aci_';
    	$this->table_name = 'customer';
		parent::__construct();
	}
    
    /**
     * 初始化默认值
     * @return array
     */
    function default_info()
    {
    	return array(
		'customer_id'=>0,
		'customer_type'=>'',
		'telephone'=>'',
		'password'=>'',
		'name'=>'',
		'identity'=>'',
		'wuliu_name'=>'',
		'wuliu_license'=>'',
		'company_name'=>'',
		'company_license'=>'',
		'status'=>'',
		'last_login'=>'',
		);
    }
    
    /**
     * 安装SQL表
     * @return void
     */
    function init()
    {
    	$this->query("CREATE TABLE  IF NOT EXISTS `t_aci_customer`
(
`customer_type` varchar(250) DEFAULT NULL COMMENT '货主类型',
`telephone` varchar(250) DEFAULT NULL COMMENT '手机号码',
`password` varchar(50) DEFAULT NULL COMMENT '密码',
`name` varchar(250) DEFAULT NULL COMMENT '姓名',
`identity` varchar(250) DEFAULT NULL COMMENT '身份证号',
`wuliu_name` varchar(250) DEFAULT NULL COMMENT '物流公司名称',
`wuliu_license` varchar(250) DEFAULT NULL COMMENT '物流公司营业执照',
`company_name` varchar(250) DEFAULT NULL COMMENT '企业名称',
`company_license` varchar(250) DEFAULT NULL COMMENT '营业执照',
`status` varchar(250) DEFAULT NULL COMMENT '状态',
`last_login` datetime DEFAULT NULL COMMENT '最后登陆',
`customer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
");
    }
    
        
    /**
     * 货主列表     * @return array
     */
    function customer_list_datasource($where='',$limit = '', $order = '', $group = '', $key='')
    {
    	$datalist = $this->select($where,'customer_id,telephone',$limit,$order,$group,$key);
        return $datalist;
    }
    
    /**
     * 货主列表选择中项值     * @return array
     */
    function customer_list_value($id=0)
    {
    	$data_info = $this->get_one(array('customer_id'=>$id),'telephone');
        if($data_info)
        {
        	return  implode("-",$data_info);
        }
        return NULL;
    }
        }

// END customer_model class

/* End of file customer_model.php */
/* Location: ./customer_model.php */
?>