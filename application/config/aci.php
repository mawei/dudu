<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['aci_status'] = array (
  'systemVersion' => '1.2.0',
  'installED' => true,
);
$config['aci_module'] = array (
  'welcome' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'welcome',
    'modulePath' => '',
    'moduleCaption' => '首页',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => '',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => '',
        'controller' => 'welcome',
        'method' => '',
        'caption' => '欢迎界面',
      ),
    ),
  ),
  'adminpanel' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'user',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '后台管理中心',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/user',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'index',
        'caption' => '管理中心-首页',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'login',
        'caption' => '管理中心-登录',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'logout',
        'caption' => '管理中心-注销',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'profile',
        'method' => 'change_pwd',
        'caption' => '管理中心-修改密码',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'login',
        'caption' => '管理中心-登录',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'go',
        'caption' => '管理中心-URL转向',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'manage',
        'method' => 'cache',
        'caption' => '管理中心-全局缓存',
      ),
    ),
  ),
  'user' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'user',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '用户 / 用户组管理',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/user',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'index',
        'caption' => '用户管理-列表',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'check_username',
        'caption' => '用户管理-检测用户名',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'delete',
        'caption' => '用户管理-删除',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'lock',
        'caption' => '用户管理-锁定',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'edit',
        'caption' => '用户管理-编辑',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'add',
        'caption' => '用户管理-新增',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'upload',
        'caption' => '用户管理-上传图像',
      ),
      7 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'index',
        'caption' => '用户组管理-列表',
      ),
      8 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'setting',
        'caption' => '用户组管理-权限设置',
      ),
      9 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'add',
        'caption' => '用户组管理-新增',
      ),
      10 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'edit',
        'caption' => '用户组管理-编辑',
      ),
      11 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'delete_one',
        'caption' => '用户组管理-删除',
      ),
      12 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'user',
        'method' => 'user_window',
        'caption' => '用户-弹窗',
      ),
      13 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'role',
        'method' => 'group_window',
        'caption' => '用户组-弹窗',
      ),
    ),
  ),
  'moduleMenu' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'moduleMenu',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '菜单管理',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/moduleMenu',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'index',
        'caption' => '菜单管理-列表',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'add',
        'caption' => '菜单管理-新增',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'edit',
        'caption' => '菜单管理-编辑',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'delete',
        'caption' => '菜单管理-删除',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleMenu',
        'method' => 'set_menu',
        'caption' => '菜单管理-设置菜单',
      ),
    ),
  ),
  'moduleManage' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'module',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '模块安装管理',
    'description' => '由autoCodeigniter 系统的模块',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/moduleManage',
    'system' => true,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleManage',
        'method' => 'index',
        'caption' => '模块管理',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'index',
        'caption' => '模块管理-开始',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'check',
        'caption' => '模块管理-检查',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'setup',
        'caption' => '模块管理-安装',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'uninstall',
        'caption' => '模块管理-卸载',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'reinstall',
        'caption' => '模块管理-重新安装',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'moduleInstall',
        'method' => 'delete',
        'caption' => '模块管理-删除',
      ),
    ),
  ),
  'helloWorld' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2015-10-09 20:10:10',
    'moduleName' => 'helloWorld',
    'modulePath' => 'adminpanel',
    'moduleCaption' => 'Hello World',
    'description' => '这里一个演示模块，来自于吸心大法第三章',
    'fileList' => NULL,
    'works' => true,
    'moduleUrl' => 'adminpanel/helloWorld',
    'system' => false,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'helloWorld',
        'method' => 'index',
        'menu_name' => NULL,
        'caption' => NULL,
      ),
    ),
  ),
  'customer' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2016-06-27 16:31:55',
    'moduleName' => 'customer',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '货主管理',
    'description' => '由autoCodeigniter 自动生成的模块',
    'fileList' => 
    array (
      0 => 'application/views/adminpanel/customer/edit.php',
      1 => 'scripts/adminpanel/customer/edit.js',
      2 => 'application/views/adminpanel/customer/readonly.php',
      3 => 'application/views/adminpanel/customer/lists.php',
      4 => 'scripts/adminpanel/customer/lists.js',
      5 => 'application/views/adminpanel/customer/choose.php',
      6 => 'application/views/adminpanel/customer/upload.php',
      7 => 'application/controllers/adminpanel/Customer.php',
      8 => 'application/models/Customer_model.php',
    ),
    'works' => true,
    'moduleUrl' => 'adminpanel/customer',
    'system' => false,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'index',
        'menu_name' => '管理货主管理',
        'caption' => '管理货主管理',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'index',
        'menu_name' => '货主管理列表',
        'caption' => '货主管理列表',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'add',
        'menu_name' => '新增',
        'caption' => '新增',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'edit',
        'menu_name' => '修改',
        'caption' => '修改',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'choose',
        'menu_name' => '选择弹窗',
        'caption' => '选择弹窗',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'delete_one',
        'menu_name' => '删除单个',
        'caption' => '删除单个',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'delete_all',
        'menu_name' => '删除多个',
        'caption' => '删除多个',
      ),
      7 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'readonly',
        'menu_name' => '查看',
        'caption' => '查看',
      ),
      8 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'customer',
        'method' => 'upload',
        'menu_name' => '上传',
        'caption' => '上传',
      ),
    ),
  ),
  'driver' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2016-06-27 15:04:53',
    'moduleName' => 'driver',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '司机管理',
    'description' => '由autoCodeigniter 自动生成的模块',
    'fileList' => 
    array (
      0 => 'application/views/adminpanel/driver/edit.php',
      1 => 'scripts/adminpanel/driver/edit.js',
      2 => 'application/views/adminpanel/driver/readonly.php',
      3 => 'application/views/adminpanel/driver/lists.php',
      4 => 'scripts/adminpanel/driver/lists.js',
      5 => 'application/views/adminpanel/driver/choose.php',
      6 => 'application/views/adminpanel/driver/upload.php',
      7 => 'application/controllers/adminpanel/Driver.php',
      8 => 'application/models/Driver_model.php',
    ),
    'works' => true,
    'moduleUrl' => 'adminpanel/driver',
    'system' => false,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'index',
        'menu_name' => '管理司机管理',
        'caption' => '管理司机管理',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'index',
        'menu_name' => '司机管理列表',
        'caption' => '司机管理列表',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'add',
        'menu_name' => '新增',
        'caption' => '新增',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'edit',
        'menu_name' => '修改',
        'caption' => '修改',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'choose',
        'menu_name' => '选择弹窗',
        'caption' => '选择弹窗',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'delete_one',
        'menu_name' => '删除单个',
        'caption' => '删除单个',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'delete_all',
        'menu_name' => '删除多个',
        'caption' => '删除多个',
      ),
      7 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'readonly',
        'menu_name' => '查看',
        'caption' => '查看',
      ),
      8 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'driver',
        'method' => 'upload',
        'menu_name' => '上传',
        'caption' => '上传',
      ),
    ),
  ),
  'api' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2016-06-30 15:25:46',
    'moduleName' => 'api',
    'modulePath' => 'api',
    'moduleCaption' => '司机接口',
    'description' => '由autoCodeigniter 自动生成的模块',
    'fileList' => 
    array (
      0 => 'application/controllers/api/api.php',
    ),
    'works' => true,
    'moduleUrl' => 'api/api',
    'system' => false,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'get_driver_list',
        'menu_name' => '管理司机接口',
        'caption' => '管理司机接口',
      ),
      1 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'index',
        'menu_name' => '司机接口列表',
        'caption' => '司机接口列表',
      ),
      2 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'customer_register',
        'menu_name' => '货主注册',
        'caption' => '货主注册',
      ),
      3 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'customer_login',
        'menu_name' => '货主登陆',
        'caption' => '货主登陆',
      ),
      4 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'driver_register',
        'menu_name' => '司机注册',
        'caption' => '司机注册',
      ),
      5 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'driver_login',
        'menu_name' => '司机登陆',
        'caption' => '司机登陆',
      ),
      6 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'publish_order',
        'menu_name' => '发单',
        'caption' => '发单',
      ),
      7 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'create_address',
        'menu_name' => '创建地址',
        'caption' => '创建地址',
      ),
      8 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'update_address',
        'menu_name' => '更新地址',
        'caption' => '更新地址',
      ),
      9 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'get_orderlist_by_customer',
        'menu_name' => '获取货主订单列表',
        'caption' => '获取货主订单列表',
      ),
      10 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'get_orderlist_by_driver',
        'menu_name' => '获取司机订单列表',
        'caption' => '获取司机订单列表',
      ),
      11 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'update_address2',
        'menu_name' => '更新地址',
        'caption' => '更新地址',
      ),
      12 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'get_order_list',
        'menu_name' => '获取订单列表（地图）',
        'caption' => '获取订单列表（地图）',
      ),
      13 => 
      array (
        'folder' => 'api',
        'controller' => 'api',
        'method' => 'get_authcode',
        'menu_name' => '获取验证码',
        'caption' => '获取验证码',
      ),
      
    ),
  ),
  'order' => 
  array (
    'version' => '1',
    'charset' => 'utf-8',
    'lastUpdate' => '2016-06-27 16:29:50',
    'moduleName' => 'order',
    'modulePath' => 'adminpanel',
    'moduleCaption' => '订单管理',
    'description' => '由autoCodeigniter 自动生成的模块',
    'fileList' => 
    array (
      0 => 'application/views/adminpanel/order/edit.php',
      1 => 'scripts/adminpanel/order/edit.js',
      2 => 'application/views/adminpanel/order/readonly.php',
      3 => 'application/views/adminpanel/order/lists.php',
      4 => 'scripts/adminpanel/order/lists.js',
      5 => 'application/views/adminpanel/order/choose.php',
      6 => 'application/controllers/adminpanel/Order.php',
      7 => 'application/models/Order_model.php',
    ),
    'works' => true,
    'moduleUrl' => 'adminpanel/order',
    'system' => false,
    'coder' => '胡子锅',
    'website' => 'http://',
    'moduleDetails' => 
    array (
      0 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'index',
        'menu_name' => '管理订单管理',
        'caption' => '管理订单管理',
      ),
      1 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'index',
        'menu_name' => '订单管理列表',
        'caption' => '订单管理列表',
      ),
      2 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'add',
        'menu_name' => '新增',
        'caption' => '新增',
      ),
      3 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'edit',
        'menu_name' => '修改',
        'caption' => '修改',
      ),
      4 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'choose',
        'menu_name' => '选择弹窗',
        'caption' => '选择弹窗',
      ),
      5 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'delete_one',
        'menu_name' => '删除单个',
        'caption' => '删除单个',
      ),
      6 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'delete_all',
        'menu_name' => '删除多个',
        'caption' => '删除多个',
      ),
      7 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'readonly',
        'menu_name' => '查看',
        'caption' => '查看',
      ),
      8 => 
      array (
        'folder' => 'adminpanel',
        'controller' => 'order',
        'method' => 'upload',
        'menu_name' => '上传',
        'caption' => '上传',
      ),
    ),
  ),
);

/* End of file aci.php */
/* Location: ./application/config/aci.php */
