<?php
require_once dirname(__FILE__) . '/../'.'Notification.php';
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Api extends Api_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * 
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {

		parent::__construct();
		$this->load->model(array('driver_model'));
        $this->load->helper(array('auto_codeIgniter_helper','array'));
        
        $this->load->library ( 'session' );
		$this->load->database ();
		$this->load->helper ( 'url' );
		$this->load->library ( 'encrypt' );
		
		$this->key = '&(*&(*';
		$this->UmengKey = "5710924be0f55a8aba000646";
		$this->UmengSecret = "vuqkrc5tc08uolcgvolti87y60uhieyc";
		
		// 验证˙
		// $this->auth_token();
	}
	
	// public function index()
	// {
	// $error = "";
	// $this->load->view('login',$error);
	// }



	public function output_result($code, $message, $data) {
		$result = array ();
		$result ['code'] = $code;
		$result ['message'] = $message;
		$result ['data'] = $data;
		echo json_encode ( $result );
		exit ();
	}
	public function getUsers() {
		$query = $this->db->query ( "select * from `user`" );
		echo json_encode ( $query->result_array () );
	}

	// 货主登陆
	public function customerLogin() {
		$username = $this->format_get ( 'username' );
		//$authcode = $this->format_get ( 'code' );
		$password = md5 ( $this->key . $this->format_get ( 'password' ) );
		
		$result = $this->db->query ( "select * from `t_aci_customer` where username = '{$username}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$result2 = $this->db->query ( "select * from `user` where username = '{$username}' and password='{$password}'" )->result_array ();
			if (count ( $result2 ) >= 1) {
				$array ['id'] = $this->encrypt->encode ( $result2 [0] ['id'], $this->key );
				switch ($array['customer_type']) {
					case '物流公司':
						$array ['name'] = $result2 [0] ['wuliu_name'];
						break;
					case '企业':
						$array ['name'] = $result2 [0] ['company_name'];
						break;
					case '个人':
						$array ['name'] = $result2 [0] ['company_name'];
						break;
					
					default:
						break;
				}
				
				$array ['device_token'] = $result2 [0] ['device_token'];
				$array ['no_secret_id'] = $result2 [0] ['id'];
				$this->output_result ( 0, 'success', $array );
			} else {
				$this->output_result ( - 3, 'failed', '密码错误' );
			}
		} else {
			$this->output_result ( - 2, 'failed', '用户不存在' );
		}
	}

	//上传公司营业执照
	function upload_company_license() {
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$company_name = $this->format_get ( 'company_name' );
		$config ['upload_path'] = getcwd () . '/upload/';
		$config ['file_name'] = 'user_' . random_string () . '-' . $user_id;
		$config ['allowed_types'] = 'gif|jpg|png';
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		if (! $this->upload->do_upload ( 'company_license' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );
		} else {
			$photo = '/upload/' . $this->upload->data ()['file_name'];
		}

		$this->db->query ( "update `t_aci_customer` set company_license='{$photo}',company_name='{$company_name}' where id='{$customer_id}'" );
		$this->output_result ( 0, 'success', $photo );
	}

	//上传公司营业执照
	function upload_wuliu_license() {
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$wuliu_name = $this->format_get ( 'wuliu_name' );
		$config ['upload_path'] = getcwd () . '/upload/';
		$config ['file_name'] = 'user_' . random_string () . '-' . $user_id;
		$config ['allowed_types'] = 'gif|jpg|png';
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		if (! $this->upload->do_upload ( 'wuliu_license' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );
		} else {
			$photo = '/upload/' . $this->upload->data ()['file_name'];
		}

		$this->db->query ( "update `t_aci_customer` set wuliu_license='{$photo}' where id='{$customer_id}'" );
		$this->output_result ( 0, 'success', $photo );
	}

	//上传订单
	// public function create_order(){
	// 	$data ['customer_id'] = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
	// 	$data ['start_place'] = $this->format_get ( 'start_place' );
	// 	$data ['start_place_latitude'] = $this->format_get ( 'start_place_latitude' );
	// 	$data ['start_place_longitude'] = $this->format_get ( 'start_place_longitude' );
	// 	$data ['end_place'] = $this->format_get ( 'end_place' );
	// 	$data ['end_place_latitude'] = $this->format_get ( 'end_place_latitude' );
	// 	$data ['end_place_longitude'] = $this->format_get ( 'end_place_longitude' );
	// 	$data ['strat_time'] = $this->format_get ( 'strat_time' );
	// 	$data ['truck_type'] = $this->format_get ( 'truck_type' );
	// 	$data ['truck_size'] = $this->format_get ( 'truck_size' );
	// 	$data ['charge'] = $this->format_get ( 'charge' );
	// 	$data ['weight'] = $this->format_get ( 'weight' );
	// 	$data ['infomation_charge'] = $this->format_get ( 'infomation_charge' );
	// 	$data ['create_time'] = time ();

		
	// 	$this->db->insert ( 'order', $data );
	// 	$order_id = $this->db->insert_id ();


	// 	$this->output_result ( 0, 'success', $this->db->insert_id () );
		
	// }

	function publish_order() {
		$data['customer_id'] = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		//$data ['start_place'] = str_replace ( "+", "-", $this->format_get ( 'time' ) );
		//$data ['address'] = str_replace ( "+", " ", $this->format_get ( 'address' ) );
		$data ['start_place'] = $this->format_get ( 'start_place' );
		$data ['end_place'] = $this->format_get ( 'end_place' );
		$data ['start_time'] = $this->format_get ( 'start_time' );
		$data ['truck_type'] = $this->format_get ( 'truck_type' );
		$data ['truck_size'] = $this->format_get ( 'truck_size' );
		$data ['charge'] = $this->format_get ( 'charge' );
		$data ['weight'] = $this->format_get ( 'weight' );
		$data ['status'] = "未接单";
		$date ['create_time'] = date("Y-m-d H:i:s",time());
		$this->db->insert ( 't_aci_order', $data );
		$order_id = $this->db->insert_id ();
		$start_address_id = $this->format_get("start_address_id");
		$end_address_id = $this->format_get("end_address_id");
		$this->db->query("update `t_aci_address` set order_id='{$order_id}' where address_id in ({$start_address_id},{$end_address_id})");

		$this->output_result ( 0, 'success', $order_id );		
	}

	// //获取订单列表
	// public function get_order_list() {
	// 	$page = addslashes ( $_GET ['page'] );
	// 	$number = addslashes ( $_GET ['number'] );
	// 	$latitude = addslashes ( $_GET ['latitude'] );
	// 	$longitude = addslashes ( $_GET ['longitude'] );
	// 	//$distance = addslashes( $_GET['distance'] );
	// 	$start = ($page - 1) * $number;
	// 	$query = $this->db->query ( "select t1.*,t2.photo,t2.nickname,
	// 				sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
	// 				from `t_aci_order` t1 left join `t_aci_customer` t2 on t1.customer_id = t2.customer_id order by t1.create_time desc limit {$start},{$number}" );
	// 	$this->output_result ( 0, 'success', $query->result_array () );
	// }

	//按范围获取订单列表（用于地图）
	public function get_order_list() {
		//$page = addslashes ( $_GET ['page'] );
		//$number = addslashes ( $_GET ['number'] );

		//"select * from `t_aci_order` t1 where "
		
		//$distance = addslashes( $_GET['distance'] );

		$latitude =  $this->format_get ('latitude',0);
		$longitude =  $this->format_get ('longitude',0);
		$maplatitude =  $this->format_get ('maplatitude',0);
		$maplongitude =  $this->format_get ('maplongitude',0);
		$distance =  $this->format_get ('distance');

		$start_state =  $this->format_get ('start_state',"");
		$start_city =  $this->format_get ('start_city', "");
		$start_area =  $this->format_get ('start_area',"" );
		$end_state =  $this->format_get ('end_state' ,"");
		$end_city =  $this->format_get ('end_city',"" );
		$end_area =  $this->format_get ('end_area' ,"");
		if($distance == 0){
			$query_str = "
			select t4.*,t3.`truck_type`,t3.`truck_size`,t3.start_place,t3.end_place,t3.charge from t_aci_order  t3
			JOIN(
				SELECT t1.order_id,
				t1.`latitude` as start_place_latitude,t1.`longitude` as start_place_longitude,t2.`latitude`  as end_place_latitude,t2.`longitude` as end_place_longitude FROM `t_aci_address`  t1  LEFT join `t_aci_address` t2 on t1.order_id=t2.order_id where  t1.state='{$start_state}' AND t1.city='{$start_city}' AND t1.area='{$start_area}' and t1.type='出发地'
				and  t2.state='{$end_state}' AND t2.city='{$end_city}' AND t2.area='{$end_area}' and t2.type='目的地'
    		) t4 on t3.order_id=t4.order_id where t3.status='未接单' order by t3.start_time desc
			";
		}else{
			$query_str = "
			select t4.*,t3.`truck_type`,t3.`truck_size`,t3.start_place,t3.end_place,t3.charge from t_aci_order  t3
			JOIN(
				SELECT t1.order_id,
					sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance',
					sqrt(POW((6370693.5 * cos({$maplatitude} * 0.01745329252) * ({$maplongitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$maplatitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'mapdistance',
				t1.`latitude` as start_place_latitude,t1.`longitude` as start_place_longitude FROM `t_aci_address`  t1 
    		) t4 on t3.order_id=t4.order_id where t3.status='未接单' and t4.mapdistance <= $distance order by t4.distance desc
			";
		}
		
		$query = $this->db->query($query_str);
		//$start = ($page - 1) * $number;
		//$query = $this->db->query ( "select t1.*,t2.name,t2.company_name,t2.wuliu_name
					// sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
					// from `t_aci_order` t1 left join `t_aci_customer` t2 on t1.customer_id = t2.customer_id order by t1.create_time desc limit {$start},{$number}" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	//按范围获取货车列表（用于地图）
	public function get_driver_list() {
		$latitude = addslashes ( $_GET ['latitude'] );
		$longitude = addslashes ( $_GET ['longitude'] );
		$distance = addslashes( $_GET['distance'] );
		$query = $this->db->query ( " select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance',t1.latitude,t1.longitude,t1.driver_id
									from `t_aci_driver` t1 where t1.online_status='online' order by t1.driver_id ) t2 
									where distance <= $distance
					  				" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	public function get_driver_info_by_id()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$result = $this->db->query( "select nickname,photo,telephone,truck_type,truck_size,truck_head_photo,drive_license,truck_full_photo,status,status_memo,default_route_id from `t_aci_driver` where driver_id={$driver_id}" )->result_array();
		if(count($result) > 0)
		{
			$this->output_result ( 0, 'success', $result[0] );
		}else{
			$this->output_result ( -1, 'failed', '用户信息有误' );
		}
	}
	


	public function set_default_route()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$route_id = $this->format_get ( 'route_id' );
		$this->db->query("update `t_aci_driver` set default_route_id={$route_id} where driver_id={$driver_id}");
		$this->output_result ( 0, 'success', "修改成功");
	}

	public function get_customer_info_by_id()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$result = $this->db->query( "select nickname,photo,telephone,status,customer_type,name,identity_photo,status_memo from `t_aci_customer` where customer_id={$customer_id}" )->result_array();
		if(count($result) > 0)
		{
			$this->output_result ( 0, 'success', $result[0] );
		}else{
			$this->output_result ( -1, 'failed', '用户信息有误' );
		}
	}

	public function accept_order_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='未接单' and order_id={$order_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( -1, 'failed', '该订单已被抢走，下次记得抢快点哦' );
		}else{
			$driver = $this->db->query("select * from `t_aci_driver` where driver_id={$driver_id}")->result_array()[0];
			$order = $this->db->query("select * from `t_aci_order` t1 where status='未接单' and order_id={$order_id} and truck_type='{$driver['truck_type']}' and truck_size='{$driver['truck_size']}'")->result_array();

			if(count($order) > 0)
			{
				$this->db->query("update `t_aci_order` set status='接单中' , driver_id={$driver_id} , accept_order_time='{$accept_order_time}' where order_id={$order_id}");



				$customer_telephone = $this->db->query("select telephone from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0]['telephone'];

				$this->sms_content($customer_telephone,"【嘟嘟找车】您的订单已有货车司机接单，请在三分钟内进入app进行确认");
				$this->output_result ( 0, 'success', 'success' );
			}else{
				$this->output_result ( -1, 'failed', '您的车辆信息不符合该订单要求' );
			}
		}
	}

	public function update_driver_location()
	{
		$data ['latitude'] = $this->format_get ( 'latitude' );
		$data ['longitude'] = $this->format_get ( 'longitude' );
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$this->db->query("update `t_aci_driver` set longitude='{$data ['longitude']}',latitude='{$data ['latitude']}' where driver_id={$driver_id}");
		$this->output_result ( 0, 'success', 'success' );
	}

	public function confirm_accept_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='接单中' and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '该订单已超过确认时间，请继续等待' );
		}else{
			$this->db->query("update `t_aci_order` set status='已接单' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找货】货主已确认您的接单，请尽快联系车主");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//取消订单
	function cancel_order_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where order_id={$order_id} and driver_id={$driver_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			$this->db->query("update `t_aci_order` set status='司机取消订单' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找车】货车司机已取消订单，请查看信息");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//取消订单
	function cancel_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where order_id={$order_id} and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			if($r[0]['driver_id'] == "")
			{
				$this->db->query("update `t_aci_order` set status='已取消' where order_id={$order_id}");
				$this->output_result ( 0, 'success', 'success' );
			}else{
				$this->db->query("update `t_aci_order` set status='货主取消订单' where order_id={$order_id}");

				$customer_telephone = $this->db->query("select telephone from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0]['telephone'];

				$this->sms_content($customer_telephone,"【嘟嘟找货】货主已取消订单，请查看信息");
				$this->output_result ( 0, 'success', 'success' );
			}
		}
	}

	//反对取消订单
	function against_order_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='货主取消订单' and order_id={$order_id} and driver_id={$driver_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			$this->db->query("update `t_aci_order` set status='司机反对取消订单' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找车】货车司机对您的取消订单操作有异义，请尽快电话联系车主");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//反对取消订单
	function against_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='司机取消订单' and order_id={$order_id} and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			$this->db->query("update `t_aci_order` set status='货主反对取消订单' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找货】货主对您的取消订单操作有异义，请尽快电话联系车主");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//同意取消订单
	function agree_cancel_order_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='货主取消订单' and order_id={$order_id} and driver_id={$driver_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			$this->db->query("update `t_aci_order` set status='未接单',driver_id='' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找车】货车司机同意您的取消订单操作，请重新等待其它车主接单");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//同意取消订单
	function agree_cancel_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='司机取消订单' and order_id={$order_id} and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			$this->db->query("update `t_aci_order` set status='未接单',driver_id='' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找货】货主同意您的取消订单操作，请重新等待其它车主接单");
			$this->output_result ( 0, 'success', 'success' );
		}
	}


	//装货完毕
	function loading_complete_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='已接单' and order_id={$order_id} and driver_id={$driver_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			$this->db->query("update `t_aci_order` set status='司机装货完毕' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找车】货车司机已为您装货完毕");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//装货完毕
	function loading_complete_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where order_id={$order_id} and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '非法操作' );
		}else{
			$this->db->query("update `t_aci_order` set status='货主确认装货完毕' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找货】货主已确认装货完毕");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

		//司机任务完成
	function complete_order_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='货主确认装货完毕' and order_id={$order_id} and driver_id={$driver_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '请等待用户确认装货完毕' );
		}else{
			$this->db->query("update `t_aci_order` set status='司机完成任务' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找车】货车司机已完成任务，快去确认吧");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//货主任务完成
	function complete_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where order_id={$order_id} and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '请等待用户确认装货完毕' );
		}else{
			$this->db->query("update `t_aci_order` set status='已完成' where order_id={$order_id}");

			$customer_telephone = $this->db->query("select telephone from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0]['telephone'];

			$this->sms_content($customer_telephone,"【嘟嘟找货】货主已确认完成任务");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	public function getDriverInfoById()
	{
		$user_id = $this->format_get ( 'driver_id' );
		
		$query = $this->db->query ( "select id, nickname,photo,sex,interest from `user` where id = {$user_id}" );
		if (count ( $query->result_array () ) > 0) {
			
			$result = $query->result_array ()[0];
			$result['no_secret_id'] = $result['id'];
			if ($this->format_get ( 'self_user_id', '' ) != '') {
				$result ['id'] = $this->encrypt->encode ( $result ['id'], $this->key );
				$self_user_id = $this->encrypt->decode ( $this->format_get ( 'self_user_id' ), $this->key );
				$query2 = $this->db->query ( "select * from `follow` where follow_user_id={$self_user_id} and followed_user_id={$user_id} and status=1" );
				if (count ( $query2->result_array () ) > 0) {
					$result ['follow'] = "关注中";
				} else {
					$result ['follow'] = "关注";
				}
			} else {
				$result ['follow'] = "关注";
			}
			$this->output_result ( 0, 'success', $result );
		} else {
			$this->output_result ( - 1, 'failed', '没有该用户' );
		}
	}
	
	public function getUserInfoById() {
		$user_id = $this->format_get ( 'user_id' );
		
		$query = $this->db->query ( "select id, nickname,photo,sex,interest from `user` where id = {$user_id}" );
		if (count ( $query->result_array () ) > 0) {
			
			$result = $query->result_array ()[0];
			$result['no_secret_id'] = $result['id'];
			if ($this->format_get ( 'self_user_id', '' ) != '') {
				$result ['id'] = $this->encrypt->encode ( $result ['id'], $this->key );
				$self_user_id = $this->encrypt->decode ( $this->format_get ( 'self_user_id' ), $this->key );
				$query2 = $this->db->query ( "select * from `follow` where follow_user_id={$self_user_id} and followed_user_id={$user_id} and status=1" );
				if (count ( $query2->result_array () ) > 0) {
					$result ['follow'] = "关注中";
				} else {
					$result ['follow'] = "关注";
				}
			} else {
				$result ['follow'] = "关注";
			}
			$this->output_result ( 0, 'success', $result );
		} else {
			$this->output_result ( - 1, 'failed', '没有该用户' );
		}
	}
	
	// 登陆
	public function login() {
		$username = $this->format_get ( 'username' );
		$password = md5 ( $this->key . $this->format_get ( 'password' ) );
		
		$result = $this->db->query ( "select * from `user` where username = '{$username}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$result2 = $this->db->query ( "select * from `user` where username = '{$username}' and password='{$password}'" )->result_array ();
			if (count ( $result2 ) >= 1) {
				$array ['id'] = $this->encrypt->encode ( $result2 [0] ['id'], $this->key );
				$array ['nickname'] = $result2 [0] ['nickname'];
				$array ['phone'] = $result2 [0] ['username'];
				$array ['photo'] = $result2 [0] ['photo'];
				$array ['sex'] = $result2 [0] ['sex'];
				$array ['device_token'] = $result2 [0] ['device_token'];
				$array ['interest'] = $result2 [0] ['interest'];
				$array ['no_secret_id'] = $result2 [0] ['id'];
				$this->output_result ( 0, 'success', $array );
			} else {
				$this->output_result ( - 3, 'failed', '密码错误' );
			}
		} else {
			$this->output_result ( - 2, 'failed', '用户不存在' );
		}
	}

	// 货主登陆
	public function customer_login() {
		$telephone = $this->format_get ( 'telephone' );
		$password = md5 ( $this->key . $this->format_get ( 'password' ) );


		$result = $this->db->query ( "select * from `t_aci_customer` where telephone = '{$telephone}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$result2 = $this->db->query ( "select * from `t_aci_customer` where telephone = '{$telephone}' and password='{$password}'" )->result_array ();
			if (count ( $result2 ) >= 1) {
				$array ['customer_id'] = $this->encrypt->encode ( $result2 [0] ['customer_id'], $this->key );
				$array ['telephone'] = $result2 [0] ['telephone'];
				$array ['name'] = $result2 [0] ['name'];
				$array ['identity_photo'] = $result2 [0] ['identity_photo'];
				$array ['status'] = $result2 [0] ['status'];
				$array ['status_memo'] = $result2 [0] ['status_memo'];
				$array ['last_login'] = $result2 [0] ['last_login'];
				$array ['customer_type'] = $result2 [0] ['customer_type'];
				$this->output_result ( 0, 'success', $array );
			} else {
				$this->output_result ( - 3, 'failed', '密码错误' );
			}
		} else {
			$this->output_result ( - 2, 'failed', '用户不存在' );
		}
	}

	//货主注册
	public function customer_register() {
		$telephone = $this->format_get ( 'telephone' );
		$authcode = $this->format_get ( 'authcode' );
		// $secret_authcode = $this->format_get ( 'secret_authcode' );
		// $secret_telephone = $this->format_get ( 'secret_telephone' );
		$telephone = $this->format_get ( 'telephone' );
		$customer_type = $this->format_get('customer_type');
		$password = $this->format_get('password');


		if($telephone == "")
		{
			$this->output_result ( - 1, 'failed', '手机号码不能为空' );
		}
		if($customer_type == "")
		{
			$this->output_result ( - 1, 'failed', '货主类型不能为空' );
		}
		if($password == "")
		{
			$this->output_result ( - 1, 'failed', '密码不能为空' );
		}

		$secret_telephone = $this->encrypt->decode ( $this->format_get ( 'secret_telephone' ), $this->key );
		if ($telephone != $secret_telephone) {
			$this->output_result ( - 888, 'failed', '非法操作' );
		}
		$auth_code_secret = $this->encrypt->decode ( $this->format_get ( 'secret_authcode' ), $this->key );
		$authcode = $this->format_get ( 'authcode' );
		if ($authcode != $auth_code_secret) {
			$this->output_result ( - 1, 'failed', '验证码错误' );
		}
		$result = $this->db->query ( "select * from `t_aci_customer` where telephone = '{$telephone}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$this->output_result ( - 1, 'failed', '该用户已注册' );
		} else {
			$data['telephone'] = $telephone;
			$data['password'] = md5 ( $this->key . $password);
			$data['customer_type'] = $customer_type;
			$data['status'] = '未认证';
			$this->db->insert('t_aci_customer',$data);
			$this->output_result ( 0, 'success', '' );
		}
	}

	//车主注册
	public function driver_register() {
		$telephone = $this->format_get ( 'telephone' );
		$authcode = $this->format_get ( 'authcode' );
		// $secret_authcode = $this->format_get ( 'secret_authcode' );
		// $secret_telephone = $this->format_get ( 'secret_telephone' );
		$telephone = $this->format_get ( 'telephone' );
		$truck_type = $this->format_get('truck_type');
		$truck_size = $this->format_get('truck_size');
		$password = $this->format_get('password');


		if($telephone == "")
		{
			$this->output_result ( - 1, 'failed', '手机号码不能为空' );
		}
		if($truck_type == "")
		{
			$this->output_result ( - 1, 'failed', '货车类型不能为空' );
		}
		if($truck_size == "")
		{
			$this->output_result ( - 1, 'failed', '车重／车长不能为空' );
		}
		if($password == "")
		{
			$this->output_result ( - 1, 'failed', '密码不能为空' );
		}

		$secret_telephone = $this->encrypt->decode ( $this->format_get ( 'secret_telephone' ), $this->key );
		if ($telephone != $secret_telephone) {
			$this->output_result ( - 888, 'failed', '非法操作' );
		}
		$auth_code_secret = $this->encrypt->decode ( $this->format_get ( 'secret_authcode' ), $this->key );
		$authcode = $this->format_get ( 'authcode' );
		if ($authcode != $auth_code_secret) {
			$this->output_result ( - 1, 'failed', '验证码错误' );
		}
		$result = $this->db->query ( "select * from `t_aci_driver` where telephone = '{$telephone}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$this->output_result ( - 1, 'failed', '该用户已注册' );
		} else {
			$data['telephone'] = $telephone;
			$data['password'] = md5 ( $this->key . $password);
			$data['truck_type'] = $truck_type;
			$data['truck_size'] = $truck_size;
			$data['status'] = '未认证';
			$this->db->insert('t_aci_driver',$data);
			$this->output_result ( 0, 'success', '' );
		}
	}

	// 车主登陆
	public function driver_login() {
		$telephone = $this->format_get ( 'telephone' );
		$password = md5 ( $this->key . $this->format_get ( 'password' ) );


		$result = $this->db->query ( "select * from `t_aci_driver` where telephone = '{$telephone}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$result2 = $this->db->query ( "select * from `t_aci_driver` where telephone = '{$telephone}' and password='{$password}'" )->result_array ();
			if (count ( $result2 ) >= 1) {
				$array ['driver_id'] = $this->encrypt->encode ( $result2 [0] ['driver_id'], $this->key );
				$array ['telephone'] = $result2 [0] ['telephone'];
				$array ['nickname'] = $result2 [0] ['nickname'];
				$array ['photo'] = $result2 [0] ['photo'];

				// $array ['name'] = $result2 [0] ['name'];
				// $array ['identity'] = $result2 [0] ['identity'];
				// $array ['wuliu_name'] = $result2 [0] ['wuliu_name'];
				// $array ['wuliu_license'] = $result2 [0] ['wuliu_license'];
				// $array ['company_name'] = $result2 [0] ['company_name'];
				// $array ['company_license'] = $result2 [0] ['company_license'];
				$array ['status'] = $result2 [0] ['status'];
				$array ['status_memo'] = $result2 [0] ['status_memo'];
				$array ['last_login'] = $result2 [0] ['last_login'];
				//$array ['customer_type'] = $result2 [0] ['customer_type'];
				$this->output_result ( 0, 'success', $array );
			} else {
				$this->output_result ( - 3, 'failed', '密码错误' );
			}
		} else {
			$this->output_result ( - 2, 'failed', '用户不存在' );
		}
	}




	function create_address()
	{
		$data['order_id'] = $this->format_get ( 'order_id' );
		$data ['type'] = $this->format_get ( 'type' );
		$data ['address'] = $this->format_get ( 'address' );
		$data ['state'] = $this->format_get ( 'state' );
		$data ['city'] = $this->format_get ( 'city' );
		$data ['area'] = $this->format_get ( 'area' );
		$data ['street'] = $this->format_get ( 'street' );
		$data ['latitude'] = $this->format_get ( 'latitude' );
		$data ['longitude'] = $this->format_get ( 'longitude' );
		$this->db->insert ( 't_aci_address', $data );
		$result['id'] = "{$this->db->insert_id ()}";
		$this->output_result ( 0, 'success', $result );		
	}

	function update_address()
	{
		$address_id = $this->format_get ( 'address_id' );
		$data['order_id'] = $this->format_get ( 'order_id' );
		$data ['type'] = $this->format_get ( 'type' );
		$data ['address'] = $this->format_get ( 'address' );
		$data ['state'] = $this->format_get ( 'state' );
		$data ['city'] = $this->format_get ( 'city' );
		$data ['area'] = $this->format_get ( 'area' );
		$data ['street'] = $this->format_get ( 'street' );
		$data ['latitude'] = $this->format_get ( 'latitude' );
		$data ['longitude'] = $this->format_get ( 'longitude' );
		$this->db->update ( 't_aci_address', $data ,"address_id={$address_id}");
		$result['id'] = $address_id;
		$this->output_result ( 0, 'success', $result );		
	}

	function get_orderlist_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$status = $this->format_get( 'status' );
		$start = ($page - 1) * $number;
		if($status == 0)
		{
			$query_str = " select t1.* from `t_aci_order` t1 where t1.customer_id='{$customer_id}' and t1.status not in ('已完成','已取消') limit {$start},{$number}";
		}else{
			$query_str = " select t1.* from `t_aci_order` t1 where t1.customer_id='{$customer_id}' and t1.status in ('已完成','已取消') limit {$start},{$number}";
		}
		$query = $this->db->query ( $query_str );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	function get_order_detail_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$query_str = " select t1.*,TIMESTAMPDIFF(SECOND,t1.accept_order_time,CURRENT_TIMESTAMP()) as accept_remain_time,t2.photo as driver_photo,t2.nickname as driver_nickname,t2.telephone as driver_telephone from `t_aci_order` t1 left join `t_aci_driver` t2 on t1.driver_id=t2.driver_id where t1.order_id='{$order_id}' and t1.customer_id='{$customer_id}'";
		$result = $this->db->query ( $query_str )->result_array ();
		if(count($result) > 0)
		{
			$r = $result[0];

			if($r['status'] == '接单中' )
			{
				if($r['accept_remain_time']  >= 180)
				{
					$this->db->query("update `t_aci_order` set status='未接单',driver_id=NULL ,accept_order_time=NULL where order_id={$order_id}");
					$r['status'] == '未接单';
				}
			}
			$this->output_result ( 0, 'success', $r );
		}else{
			$this->output_result ( 0, 'failed', '非法操作' );
		}
	}

	function get_order_detail_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$query_str = " select t1.*,TIMESTAMPDIFF(SECOND,t1.accept_order_time,CURRENT_TIMESTAMP()) as accept_remain_time,t2.photo as customer_photo,t2.nickname as customer_nickname,t2.telephone as customer_telephone from `t_aci_order` t1 left join `t_aci_customer` t2 on t1.customer_id=t2.customer_id where t1.order_id='{$order_id}' and (t1.driver_id='{$driver_id}' or t1.driver_id IS NULL or t1.driver_id='')";
		$result = $this->db->query ( $query_str )->result_array ();
		if(count($result) > 0)
		{
			$r = $result[0];
			if($r['status'] == '接单中' )
			{
				if($r['accept_remain_time']  >= 180)
				{
					$this->db->query("update `t_aci_order` set status='未接单',driver_id=NULL ,accept_order_time=NULL where order_id={$order_id}");
					$r['status'] == '未接单';
				}
			}
			$this->output_result ( 0, 'success', $r );
		}else{
			$this->output_result ( 0, 'failed', '非法操作' );
		}
	}


	function get_orderlist_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$status = $this->format_get( 'status' );
		$start = ($page - 1) * $number;
		if($status == 0)
		{
			$query_str = " select t1.* from `t_aci_order` t1 where t1.driver_id='{$driver_id}' and t1.status not in ('已完成','已取消') limit {$start},{$number}";
		}else{
			$query_str = " select t1.* from `t_aci_order` t1 where t1.driver_id='{$driver_id}' and t1.status in ('已完成','已取消') limit {$start},{$number}";
		}
		$query = $this->db->query ( $query_str );

		$this->output_result ( 0, 'success', $query->result_array () );
	}

	function get_routes_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$query_str = " select t1.* from `t_aci_general_route` t1 where t1.driver_id='{$driver_id}' ";
		$query = $this->db->query ( $query_str );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	function get_route_info_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$route_id = $this->format_get('route_id');
		$query_str = " select t1.* from `t_aci_general_route` t1 where t1.driver_id='{$driver_id}' and t1.general_route_id='{$route_id}'";
		$query = $this->db->query ( $query_str );
		$this->output_result ( 0, 'success', $query->result_array ()[0] );
	}

	function add_route_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$data['driver_id'] = $driver_id;
		$data['start_state'] = $this->format_get('start_state');
		$data['start_city'] = $this->format_get('start_city');
		$data['start_area'] = $this->format_get('start_area');
		$data['end_state'] = $this->format_get('end_state');
		$data['end_city'] = $this->format_get('end_city');
		$data['end_area'] = $this->format_get('end_area');
		$this->db->insert('t_aci_general_route',$data);
		$this->output_result ( 0, 'success', '添加成功' );
	}

	function delete_route_by_driver(){
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$route_id = $this->format_get('route_id');
		$result = $this->db->query("select * from `t_aci_general_route` where general_route_id={$route_id} and driver_id={$driver_id}")->result_array();
		if(count($result) > 0)
		{
			$this->db->query("delete from `t_aci_general_route` where general_route_id={$route_id} and driver_id={$driver_id}");
			$this->output_result ( 0, 'success', "删除成功" );
		}else{
			$this->output_result ( -1, 'failed', "操作失败，请联系管理员" );
		}
	}

	public function login_authcode(){
		$auth_code_secret = $this->encrypt->decode ( $this->format_get ( 'auth_code_secret' ), $this->key );
		$authcode = $this->format_get ( 'code' );	
		$username = $this->encrypt->decode ( $this->format_get ( 'username' ), $this->key );
		
		//$username = $this->format_get ( 'username' );
		
		if($auth_code_secret == $authcode)
		{
			$result = $this->db->query ( "select * from `user` where username = '{$username}'" )->result_array ();
			if(count($result) > 0)
			{
				$result[0] ['id'] = $this->encrypt->encode ( $result[0] ['id'], $this->key );
				$this->output_result(0, 'success', $result[0]);
			}else{
				$this->output_result(-1, 'failed', '该手机号不存在，请先注册');
			}
		}else{
			$this->output_result(-1, 'failed', '验证码错误');
		}
	}
	
	public function check_username()
	{
		
		$username = $this->format_get ( 'username' );
		$result = $this->db->query ( "select * from `user` where username = '{$username}'" )->result_array ();
		if(count($result) == 0)
		{
			$this->output_result(0, 'success', $this->encrypt->encode ( $username, $this->key ));
		}else{
			$this->output_result(-1, 'failed', '该手机号已注册');
		}
	}
	
	public function register_authcode(){
		$auth_code_secret = $this->encrypt->decode ( $this->format_get ( 'auth_code_secret' ), $this->key );
		$authcode = $this->format_get ( 'code' );
		$device_token = $this->format_get ( 'device_token' );
		$username_secret = $this->encrypt->decode ( $this->format_get ( 'username_secret' ), $this->key );
		
		$username = $this->format_get ( 'username' );
	
		if($username_secret != $username)
		{
			$this->output_result(-1, 'failed', '非法请求');
		}
		if($auth_code_secret == $authcode)
		{
			$result = $this->db->query ( "select * from `user` where username = '{$username}'" )->result_array ();
			if(count($result) == 0)
			{
				$result2 = $this->db->query ( "select * from `user` where device_token = '{$device_token}'" )->result_array ();
				if(count($result2) > 0)
				{
					$time = time();
					$this->db->query("update `user` set username='{username},create_time='$time' where device_token='{$device_token}'");
					$id = $this->encrypt->encode ( $result[0]['id'], $this->key );
				}else{
					$data['username'] = $username;
					$data['create_time'] = time();
					$this->db->insert('user',$data);
					$id = $this->encrypt->encode ( $this->db->insert_id (), $this->key );
				}
				$this->output_result(0, 'success', $id);
			}else{
				$this->output_result(-1, 'failed', '该手机号已注册');
			}
		}else{
			$this->output_result(-1, 'failed', '验证码错误');
		}
	}
	
	public function register_device()
	{
		$device_token = $this->format_get ( 'device_token' );
		$result2 = $this->db->query ( "select * from `user` where device_token = '{$device_token}'" )->result_array ();
		
	}
	
	public function get_authcode() {
		$mobile = $this->format_get ( 'mobile' );
		$authcode = mt_rand ( 111111, 999999 );
	
		$res['telephone'] = $this->encrypt->encode ( $mobile, $this->key );
		$res['authcode'] = $this->encrypt->encode ( $authcode, $this->key );
	
		$result = $this->db->query ( "select * from `t_aci_customer` where telephone = '{$mobile}'" )->result_array ();
		if(count($result) == 0)
		{
			$this->sms_code ( $mobile, $authcode );
			$this->output_result(0, 'success', $res);
		}else{
			$this->output_result(-1, 'failed', '该手机号已注册');
		}
	}

	public function get_authcode_by_driver() {
		$mobile = $this->format_get ( 'mobile' );
		$authcode = mt_rand ( 111111, 999999 );
	
		$res['telephone'] = $this->encrypt->encode ( $mobile, $this->key );
		$res['authcode'] = $this->encrypt->encode ( $authcode, $this->key );
	
		$result = $this->db->query ( "select * from `t_aci_driver` where telephone = '{$mobile}'" )->result_array ();
		if(count($result) == 0)
		{
			$this->sms_code ( $mobile, $authcode );
			$this->output_result(0, 'success', $res);
		}else{
			$this->output_result(-1, 'failed', '该手机号已注册');
		}
	}

	
	function upload_photo_by_driver() {
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$config ['upload_path'] = getcwd () . '/upload/driver/';
		$config ['file_name'] = 'driver_photo_' . random_string () . '-' . $driver_id;
		$config ['allowed_types'] = 'gif|jpg|png';
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		if (! $this->upload->do_upload ( 'driver_photo' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );

		} else {
			$driver_photo = '/driver/' . $this->upload->data ()['file_name'];
		}
		
		$this->db->query ( "update `t_aci_driver` set photo='{$driver_photo}' where driver_id={$driver_id}" );
		$this->output_result ( 0, 'success', $driver_photo );
	}

	function upload_photo_by_customer() {
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$config ['upload_path'] = getcwd () . '/upload/customer/';
		$config ['file_name'] = 'customer_photo_' . random_string () . '-' . $customer_id;
		$config ['allowed_types'] = 'gif|jpg|png';
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		if (! $this->upload->do_upload ( 'customer_photo' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );

		} else {
			$customer_photo = '/customer/' . $this->upload->data ()['file_name'];
		}
		
		$this->db->query ( "update `t_aci_customer` set photo='{$customer_photo}' where customer_id={$customer_id}" );
		$this->output_result ( 0, 'success', $customer_photo );
	}

	function upload_customer_info() {
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$name = $this->format_get ( 'name' );
		$config ['upload_path'] = getcwd () . '/upload/customer/';
		$config ['file_name'] = 'customer_' . random_string () . '-' . $customer_id;
		$config ['allowed_types'] = 'gif|jpg|png';
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		if (! $this->upload->do_upload ( 'user_info' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );
		} else {
			$photo = '/customer/' . $this->upload->data ()['file_name'];
		}
		$this->db->query ( "update `t_aci_customer` set identity_photo='{$photo}',name='{$name}',status='认证中' where customer_id={$customer_id}" );
		$this->output_result ( 0, 'success', $photo );
	}

	function upload_driver_info() {
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$config ['upload_path'] = getcwd () . '/upload/driver/';
		$config ['file_name'] = 'driver_' . random_string () . '-' . $driver_id;
		$config ['allowed_types'] = 'gif|jpg|png';
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		if (! $this->upload->do_upload ( 'driver_license_image' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );

		} else {
			$driver_license_image = '/driver/' . $this->upload->data ()['file_name'];

		}
		if (! $this->upload->do_upload ( 'truck_head_image' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );
		} else {
			$truck_head_image = '/driver/' . $this->upload->data ()['file_name'];
		}
		if (! $this->upload->do_upload ( 'truck_full_image' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );
		} else {
			$truck_full_image = '/driver/' . $this->upload->data ()['file_name'];
			
		}
		$this->db->query ( "update `t_aci_driver` set drive_license='{$driver_license_image}',truck_head_photo='{$truck_head_image}',truck_full_photo='{$truck_full_image}',status='认证中' where driver_id={$driver_id}" );

		$this->output_result ( 0, 'success', '' );
	}

	
	
	public  function change_interest() {
		$userid = $this->encrypt->decode($this->format_get('user_id'),$this->key);
		$interest = $this->format_get('interest');
		$result = $this->db->query("select * from `user` where id={$userid}")->result_array();
		if(count($result) > 0)
		{
			$this->db->query("update `user` set interest='{$interest}' where id={$userid}");
			$this->output_result ( 0, 'success', '修改成功' );
		}else{
			$this->output_result ( 0, 'success', '用户不存在' );
		}
	}
	
	public function get_categories()
	{
		$result = $this->db->query("select * from `category` where is_delete=0")->result_array();
		$this->output_result ( 0, 'success', $result );
	}
	
	public  function update_nickname_by_driver() {
		$driver_id = $this->encrypt->decode($this->format_get('driver_id'),$this->key);
		$nickname = $this->format_get('nickname');
		$result = $this->db->query("select * from `t_aci_driver` where driver_id={$driver_id}")->result_array();
		if(count($result) > 0)
		{
			$this->db->query("update `t_aci_driver` set nickname='{$nickname}' where driver_id={$driver_id}");
			$this->output_result ( 0, 'success', '修改成功' );
		}else{
			$this->output_result ( 0, 'success', '用户不存在' );
		}
	}
	
	public  function update_nickname_by_customer() {
		$customer_id = $this->encrypt->decode($this->format_get('customer_id'),$this->key);
		$nickname = $this->format_get('nickname');
		$result = $this->db->query("select * from `t_aci_customer` where customer_id={$customer_id}")->result_array();
		if(count($result) > 0)
		{
			$this->db->query("update `t_aci_customer` set nickname='{$nickname}' where customer_id={$customer_id}");
			$this->output_result ( 0, 'success', '修改成功' );
		}else{
			$this->output_result ( 0, 'success', '用户不存在' );
		}
	}

	public function complete_userinfo() {
		$userid = $this->encrypt->decode($this->format_get('user_id'),$this->key);
		$nickname = $this->format_get ( 'nickname' );
		$sex = $this->format_get ( 'sex' );
		$interest = $this->format_get ( 'interest' );
		
		if ($sex != "男" && $sex != "女") {
			$this->output_result ( - 1, 'failed', '性别输入有误' );
		} else if ($nickname == '') {
			$this->output_result ( - 2, 'failed', '昵称不能为空' );
		} else if ($interest == '') {
			$this->output_result ( - 3, 'failed', '兴趣不能为空' );
		} 
		else {
			$create_time = time ();
			$userinfo = $this->db->query ( "update `user` set sex='{$sex}',interest='{$interest}',nickname='{$nickname}',create_time='{$create_time}' where id={$userid} " );
			$result = $this->db->query ( "select id, nickname,photo,sex,interest from `user` where id = {$userid}" )->result_array();
			$result[0] ['no_secret_id'] = $result[0] ['id'];
			$result[0] ['id'] = $this->encrypt->encode ( $result[0] ['id'], $this->key );
			 
			$this->output_result(0, 'success', $result[0]);
			// $this->db->query("update `user` set password='{$password}' and nickname='{$nickname}' where userid='{$user_id}'");
		}
	}
	
	public function set_password() {
		$user_id = $this->encrypt->decode($this->format_get('user_id'),$this->key);
		$password1 = $this->format_get ( 'password1' );
		$password2 = $this->format_get ( 'password2' );
	
		if ($password1 != $password2 || $password1 == '') {
			$this->output_result ( - 1, 'failed', '密码不一致' );
		}else {
			$create_time = time ();
			$password = md5 ( $this->key . $password1 );
			$this->db->query("update `user` set password='{$password}' where id={$user_id}");
			$this->output_result ( 0, 'success', '设置成功' );
			// $this->db->query("update `user` set password='{$password}' and nickname='{$nickname}' where userid='{$user_id}'");
		}
	}
	
// 	public function get_messages() {
// 		$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
// 		$page = addslashes ( $_GET ['page'] );
// 		$number = addslashes ( $_GET ['number'] );
// 		$start = ($page - 1) * $number;
// 		$query = $this->db->query ( "select * from `message` where user_id={$user_id} order by create_time desc limit {$start},{$number}" );
// 		$this->output_result ( 0, 'success', $query->result_array () );
// 	}
	public function get_activity() {
		$activity_id = $this->format_get ( 'id' );
		if ($this->format_get ( 'user_id' ) == "0") {
			$user_id = "0";
		} else {
			$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		}
		
		$latitude = addslashes ( $_GET ['latitude'] );
		$longitude = addslashes ( $_GET ['longitude'] );
		$result = $this->db->query ( "select t1.*,t2.photo,t2.nickname,
					sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
					from `activity` t1 left join `user` t2 on t1.creater_id = t2.id where t1.id = '{$activity_id}'" )->result_array ()[0];
		$result ["apply_number"] = $this->db->query ( "select count(id) as count from `attend` where activity_id = {$activity_id}" )->result_array ()[0]['count'];
		
		$apply = $this->db->query ( "select * from `attend` where activity_id = {$activity_id} and user_id={$user_id}" )->result_array ();
		$result ["is_apply"] = count ( $apply ) > 0 ? "1" : "0";
		
		$collect = $this->db->query ( "select * from `collect` where activity_id = {$activity_id} and user_id={$user_id}" )->result_array ();
		$result ["is_collect"] = count ( $collect ) > 0 ? "1" : "0";
		
		$this->output_result ( 0, 'success', $result );
	}
	
	public function get_recommand_place() {
		$category = $this->format_get ( 'category' );
		$latitude = addslashes ( $_GET ['latitude'] );
		$longitude = addslashes ( $_GET ['longitude'] );
		
		$result = $this->db->query ( "
				select t2.address as name FROM
				(
				select t1.address,t1.cover_distance,
				sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
				from `place` t1 where category='{$category}' and datediff(t1.expire_date,now()) >= 0
				order by level
				) t2
				where  t2.distance < t2.cover_distance
				limit 1
				" )->result_array ();
		if(count($result) > 0)
		{
			$this->output_result ( 0, 'success', $result[0]['name'] );
		}else{
			$this->output_result ( 0, 'success', "" );
		}
	
				
	}
	
	function create_activity() {
		$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$data ['time'] = str_replace ( "+", "-", $this->format_get ( 'time' ) );
		$data ['address'] = str_replace ( "+", " ", $this->format_get ( 'address' ) );
		$data ['remain_number'] = $this->format_get ( 'remain_number' );
		$data ['sex_limit'] = $this->format_get ( 'sex_limit' );
		$data ['memo'] = $this->format_get ( 'memo' );
		$data ['create_time'] = time ();
		$data ['creater_id'] = $user_id;
		$data ['category'] = $this->format_get ( 'category' );
		$data ['longitude'] = $this->format_get ( 'longitude' );
		$data ['latitude'] = $this->format_get ( 'latitude' );
		
		$this->db->insert ( 'activity', $data );
		$this->db->insert_id ();
		
		$this->output_result ( 0, 'success', $this->db->insert_id () );
		
		
	}
	
	function test_notification()
	{
		$notification = new Notification($this->UmengKey, $this->UmengSecret);
		$notification->sendIOSListcast("***在你周边发起了羽毛球活动", "33992a3218007b7323f207f296b4873fc20c40684c3fa41e089d15fdf6e1cd01");
		// $demo = new Demo("your appkey", "your app master secret");
		// $demo->sendAndroidUnicast();
	}
	
	function report_activity() {
		$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$data ['activity_id'] = $this->format_get ( 'activity_id' );
		$data ['content'] = $this->format_get ( 'content' );
		$data ['user_id'] = $user_id;
		$data ['create_time'] = time ();
		
		$result = $this->db->query ( "select * from `report` where user_id={$user_id} and activity_id={$data['activity_id']}" )->result_array ();
		if (count ( $result ) > 0) {
			$this->output_result ( -1, 'failed', "已举报该活动" );
		} else {
			$this->db->insert ( 'report', $data );
			$this->output_result ( 0, 'success', "举报成功" );
		}
	}
	function join_activity() {
		$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$data ['activity_id'] = $this->format_get ( 'activity_id' );
		$data ['user_id'] = $user_id;
		$data ['create_time'] = time ();
		$res = $this->db->query ( "select * from `activity` where creater_id={$user_id} and id={$data['activity_id']}" )->result_array ();
		if (count ( $res ) > 0) {
			$this->output_result ( -1, 'failed', "这活动是你自己发起的！" );
		}
		$number_res = $this->db->query ( "select * from `activity` where id={$data['activity_id']} and apply_number >= remain_number" )->result_array ();
		if (count ( $number_res ) > 0) {
			$this->output_result ( -2, 'failed', "活动名额已满，换一个吧" );
		}
		
		$result = $this->db->query ( "select * from `attend` where user_id={$user_id} and activity_id={$data['activity_id']}" )->result_array ();
		if (count ( $result ) > 0) {
			$this->output_result ( 0, 'success', "已报名该活动" );
		} else {
			$r = $this->db->query ( "select * from `activity` where id={$data['activity_id']}" )->result_array ()[0];
			if($r['sex_limit'] != "不限性别")
			{
				$user_sex = $this->db->query ( "select * from `user` where id={$data['user_id']}" )->result_array ()[0]['sex'];
				if(mb_substr($r['sex_limit'], 1,1,'utf-8') == $user_sex)
				{
					$this->db->insert ( 'attend', $data );
					$this->db->query ( "update `activity` set apply_number = apply_number + 1 where id={$data['activity_id']}" );
					$this->output_result ( 0, 'success', "报名成功" );
				}else{
					$this->output_result ( -1, 'failed', "该项目只".$r['sex_limit'].",嘿嘿" );
				}	
			}
			
			$this->db->insert ( 'attend', $data );
			$this->db->query ( "update `activity` set apply_number = apply_number + 1 where id={$data['activity_id']}" );
			$this->output_result ( 0, 'success', "报名成功" );
		}
	}
	function collect_activity() {
		$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$data ['activity_id'] = $this->format_get ( 'activity_id' );
		$data ['user_id'] = $user_id;
		$data ['create_time'] = time ();
		
		$result = $this->db->query ( "select * from `collect` where user_id={$user_id} and activity_id={$data['activity_id']}" )->result_array ();
		if (count ( $result ) > 0) {
			$this->output_result ( 0, 'success', "已收藏该活动" );
		} else {
			$this->db->insert ( 'collect', $data );
			$this->output_result ( 0, 'success', "收藏成功" );
		}
	}
	function get_apply_users() {
		$activity_id = $this->format_get ( 'activity_id' );
		$result = $this->db->query ( "select t2.photo,t2.nickname,t2.id,t2.id as no_secret_id,t2.sex from `attend` t1 join `user` t2 on t1.user_id=t2.id  where activity_id={$activity_id}" )->result_array ();
		$this->output_result ( 0, 'success', $result );
	}
	function get_activities() {
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$search_text = addslashes ( $_GET ['search_text'] );
		$time = addslashes ( $_GET ['time'] );
		$category = addslashes ( $_GET ['category'] );
		$start = ($page - 1) * $number;
		$latitude = addslashes ( $_GET ['latitude'] );
		$longitude = addslashes ( $_GET ['longitude'] );
		$query_str = "select t1.*,t2.photo,t2.nickname,
					sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
					from `activity` t1 left join `user` t2 on t1.creater_id = t2.id where";
		
		if ($time == "今天") {
			$query_str .= " DATEDIFF(t1.time,NOW()) = 0";
		} else if ($time == "明天") {
			$query_str .= " DATEDIFF(t1.time,NOW()) = 1";
		} else if ($time == "后天") {
			$query_str .= " DATEDIFF(t1.time,NOW()) = 2";
		} else if ($time == "一周内") {
			$query_str .= " DATEDIFF(t1.time,NOW()) <= 7";
		} else if ($time == "一个月内") {
			$query_str .= " DATEDIFF(t1.time,NOW()) <= 30";
		}
		$query_str .= " and DATEDIFF(t1.time,NOW()) > -1";
		if ($category != "所有活动") {
			$query_str .= " and category='{$category}'";
		}
		$query_str .= " and t1.apply_number <> t1.remain_number";
		$query_str .= " and t1.is_delete=0";
		//$query_str .= " and distance <= 50000";
		if($search_text != "")
		{
			$query_str .= " and (t2.nickname like '%{$search_text}%' or t1.memo like '%{$search_text}%' or t1.address like '%{$search_text}%')";
		}
		$query_str .= " order by distance asc, t1.time asc limit {$start},{$number}";
		$query = $this->db->query ( $query_str );
		
		$this->output_result ( 0, 'success', $query->result_array () );
	}
	public function get_activity_by_creater() {
		$userid = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$latitude = addslashes ( $_GET ['latitude'] );
		$longitude = addslashes ( $_GET ['longitude'] );
		$start = ($page - 1) * $number;
		$query = $this->db->query ( "select t1.*,t2.photo,t2.nickname,
					sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
					from `activity` t1 left join `user` t2 on t1.creater_id = t2.id where t1.creater_id='{$userid}' order by t1.create_time desc limit {$start},{$number}" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}
	public function get_activity_by_attend() {
		$userid = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$latitude = addslashes ( $_GET ['latitude'] );
		$longitude = addslashes ( $_GET ['longitude'] );
		$start = ($page - 1) * $number;
		$query = $this->db->query ( "select t2.*,t3.photo,t3.nickname,
					sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t2.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t2.latitude * 0.01745329252)),2)) as 'distance'
					from `attend` t1 join `activity` t2 on t1.activity_id=t2.id join `user` t3 on t3.id = t2.creater_id  where t1.user_id='{$userid}' order by t2.create_time desc limit {$start},{$number}" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}
	public function get_activity_by_collect() {
		$userid = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$latitude = addslashes ( $_GET ['latitude'] );
		$longitude = addslashes ( $_GET ['longitude'] );
		$start = ($page - 1) * $number;
		$query = $this->db->query ( "select t2.*,t3.photo,t3.nickname,
				sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t2.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t2.latitude * 0.01745329252)),2)) as 'distance'
				from `collect` t1 join `activity` t2 on t1.activity_id=t2.id join `user` t3 on t3.id = t2.creater_id  where t1.user_id='{$userid}' order by t2.create_time desc limit {$start},{$number}" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}
	
	public function delete_activity() {
		$userid = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$activity_id = $this->format_get('activity_id');
		$delete_reason = $this->format_get('delete_reason');
		$this->db->query("update `activity` set is_delete=1,delete_reason='{$delete_reason}' where id={$activity_id} and creater_id={$userid} ");
		$this->output_result ( 0, 'success', '删除成功' );
	}
	
	
	
	public function follow() {
		$follow_user_id = $this->encrypt->decode ( $this->format_get ( 'self_user_id' ), $this->key );
		$followed_user_id = addslashes ( $_GET ['user_id'] );
		$query = $this->db->query ( "select * from `follow` where follow_user_id={$follow_user_id} and followed_user_id={$followed_user_id}" )->result_array ();
		if (count ( $query ) > 0) {
			$this->db->query ( "update `follow` set status=1 where follow_user_id={$follow_user_id} and followed_user_id={$followed_user_id}" );
			$this->output_result ( 0, 'success', '成功关注' );
		} else {
			$data ['follow_user_id'] = $follow_user_id;
			$data ['followed_user_id'] = $followed_user_id;
			$data ['create_time'] = time ();
			$data ['status'] = 1;
			$this->db->insert ( 'follow', $data );
			$this->output_result ( 0, 'success', '成功关注' );
		}
	}
	public function cancel_follow() {
		$follow_user_id = $this->encrypt->decode ( $this->format_get ( 'self_user_id' ), $this->key );
		$followed_user_id = addslashes ( $_GET ['user_id'] );
		$query = $this->db->query ( "select * from `follow` where follow_user_id={$follow_user_id} and followed_user_id={$followed_user_id}" )->result_array ();
		if (count ( $query ) > 0) {
			$this->db->query ( "update `follow` set status=0 where follow_user_id={$follow_user_id} and followed_user_id={$followed_user_id}" );
			$this->output_result ( 0, 'success', '已取消关注' );
		} else {
			$this->output_result ( 0, 'success', '已取消关注' );
		}
	}
	public function send_message() {
		$data ['content'] = addslashes ( $_GET ['content'] );
		$data ['user_id'] = $this->encrypt->decode ( $this->format_get ( 'self_user_id' ), $this->key );
		$data ['to_user_id'] = addslashes ( $_GET ['user_id'] );
		$data ['create_time'] = time ();
		$this->db->insert ( 'message', $data );
		$this->output_result ( 0, 'success', 'success' );
	}


	public function get_follows() {
		$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$start = ($page - 1) * $number;
		
		$result = $this->db->query ( "select t2.id,t2.id as no_secret_id, t2.photo,t2.nickname from `follow` t1 left join `user` t2 on t1.followed_user_id=t2.id where follow_user_id={$user_id} and status=1 limit {$start},{$number}" )->result_array ();
		$this->output_result ( 0, 'success', $result );
	}
	public function get_messages() {
		$self_id = $this->encrypt->decode ( $this->format_get ( 'self_user_id' ), $this->key );
		$user_id = $this->format_get ( 'user_id' );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$start = ($page - 1) * $number;
		
		$query = $this->db->query ( "
			select 
				t2.nickname as user_nickname,
				t2.photo as user_photo,
				t3.nickname as to_user_nickname,
				t3.photo as to_user_photo,
				t1.content,
				t1.create_time 
				from `message` t1 
				left join `user` t2 on t1.user_id=t2.id 
				left join `user` t3 on t1.to_user_id=t3.id 
				where (t1.user_id={$self_id} and t1.to_user_id={$user_id} ) 
				or (t1.user_id={$user_id} and t1.to_user_id={$self_id} )
				order by t1.create_time desc
				limit {$start},{$number}
				" );
		
		$this->output_result ( 0, 'success', $query->result_array () );
	}
	public function get_message_list() {
		$userid = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$start = ($page - 1) * $number;
		
		$query = $this->db->query ( "
				select
				t3.user_id,
				t3.content, 
				t2.nickname,
				t2.photo,
				t3.create_time 
				from 
					(select 
						case when t1.user_id={$userid} then t1.to_user_id else t1.user_id END as user_id,
						t1.create_time,t1.content from 
						(select * from `message` ORDER by create_time DESC) t1 
					where t1.user_id={$userid} or t1.to_user_id={$userid} 
					GROUP by case when user_id>t1.to_user_id THEN t1.user_id*1000000000 + t1.to_user_id ELSE t1.to_user_id*1000000000 + t1.user_id END  
					order by t1.create_time DESC
					) 
				t3 left join `user` t2 on t2.id=t3.user_id
				limit {$start},{$number}
				" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}
	public function get_follow_list() {
		$userid = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$page = addslashes ( $_GET ['page'] );
		$number = addslashes ( $_GET ['number'] );
		$query = $this->db->query ( "
			select t2.id, t2.nickname,t2.photo from `follow` t1 left join `user` t2 on t1.followed_user_id=t2.id where follow_user_id = {$userid}
		" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}
	private function sms_code($mobile, $code) {
		$content = "【一隼网络】您的验证码是{$code}";
		$url = "http://yunpian.com/v1/sms/send.json";
		$encoded_text = urlencode ( "$content" );
		$post_string = "apikey=355e91e02a95574559ebba5a3c1af6c2&text=$content&mobile=$mobile";
		return $this->sock_post ( $url, $post_string );
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
	private function format_get($param, $default = "") {
		return (isset ( $_GET [$param] ) && $_GET [$param] != "") ? urldecode ( addslashes ( str_replace ( '+', '%2B', urlencode ( $_GET [$param] ) ) ) ) : $default;
	}
	private function format_post($param, $default = "") {
		return (isset ( $_POST [$param] ) && $_POST [$param] != "") ? urldecode ( addslashes ( str_replace ( '+', '%2B', urlencode ( $_POST [$param] ) ) ) ) : $default;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
