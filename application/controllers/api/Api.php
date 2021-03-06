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
		$this->zhaoche_notification_key = "57ac4f0867e58e6f0d000073";
		$this->zhaohuo_notification_key = "57ac4f8467e58ef6d1003707";
		$this->zhaoche_notification_secret = "oe7rsiprejirbmuhszi4hngymrlrzjm9";
		$this->zhaohuo_notification_secret = "ssvowwlptvmoifjylyzbqnxqp2b209mk";
		// 验证˙up
		//$this->auth_token();
	}
	
	// public function index()
	// {
	// $error = "";
	// $this->load->view('login',$error);
	// }

	function zhaoche_notification($alias_type,$alias,$content,$order_id)
	{
		$notification = new Notification($this->zhaoche_notification_key, $this->zhaoche_notification_secret);
		$notification->sendIOSCustomizedcast($alias_type,$alias,$content,$order_id);
	}

	function zhaohuo_notification($alias_type,$alias,$content,$order_id)
	{
		$notification = new Notification($this->zhaohuo_notification_key, $this->zhaohuo_notification_secret);
		$notification->sendIOSCustomizedcast($alias_type,$alias,$content,$order_id);
	}


	public function test_notification()
	{
		$this->zhaoche_notification("customer","13761011304","test","51");
	}


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
	// public function customerLogin() {
	// 	$username = $this->format_get ( 'username' );
	// 	//$authcode = $this->format_get ( 'code' );
	// 	$password = md5 ( $this->key . $this->format_get ( 'password' ) );
		
	// 	$result = $this->db->query ( "select * from `t_aci_customer` where username = '{$username}'" )->result_array ();
		
	// 	if (count ( $result ) >= 1) {
	// 		$result2 = $this->db->query ( "select * from `user` where username = '{$username}' and password='{$password}'" )->result_array ();
	// 		if (count ( $result2 ) >= 1) {
	// 			$array ['id'] = $this->encrypt->encode ( $result2 [0] ['id'], $this->key );
	// 			switch ($array['customer_type']) {
	// 				case '物流公司':
	// 					$array ['name'] = $result2 [0] ['wuliu_name'];
	// 					break;
	// 				case '企业':
	// 					$array ['name'] = $result2 [0] ['company_name'];
	// 					break;
	// 				case '个人':
	// 					$array ['name'] = $result2 [0] ['company_name'];
	// 					break;
					
	// 				default:
	// 					break;
	// 			}
				
	// 			$array ['device_token'] = $result2 [0] ['device_token'];
	// 			$array ['no_secret_id'] = $result2 [0] ['id'];
	// 			$this->output_result ( 0, 'success', $array );
	// 		} else {
	// 			$this->output_result ( - 3, 'failed', '密码错误' );
	// 		}
	// 	} else {
	// 		$this->output_result ( - 2, 'failed', '用户不存在' );
	// 	}
	// }

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
		$data ['end_time'] = $this->format_get ( 'end_time' );
		$data ['truck_type'] = $this->format_get ( 'truck_type' );
		$data ['truck_size'] = $this->format_get ( 'truck_size' );
		$data ['charge'] = $this->format_get ( 'charge' );
		$data ['weight'] = $this->format_get ( 'weight' );
		$data ['unit'] = $this->format_get ( 'unit' );
		$data ['receiver_name'] = $this->format_get ( 'receiver_name' );
		$data ['receiver_telephone'] = $this->format_get ( 'receiver_telephone' );
		$data ['is_need_payment'] = $this->format_get ( 'is_need_payment' );
		$data ['status'] = "未接单";
		$create_time = date("Y-m-d H:i:s",time());
		$date ['create_time'] = "{$create_time}";
		$this->db->insert ( 't_aci_order', $data );
		$order_id = $this->db->insert_id ();
		$start_address_id = $this->format_get("start_address_id");
		$end_address_id = $this->format_get("end_address_id");
		$this->db->query("update `t_aci_address` set order_id='{$order_id}' where address_id in ({$start_address_id},{$end_address_id})");
		$start_address = $this->db->query("select * from `t_aci_address` where address_id={$start_address_id}")->result_array()[0];
		$end_address = $this->db->query("select * from `t_aci_address` where address_id={$end_address_id}")->result_array()[0];
		$requesturl = "http://restapi.amap.com/v3/distance?origins=".$start_address['longitude'].",".$start_address['latitude']."&destination=".$end_address['longitude'].",".$end_address['latitude']."&output=json&key=2259abc9c19f491821619c7beb353fac&type=1";

		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $requesturl);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			$info=curl_exec($ch);
			curl_close($ch);
			$miles = json_decode($info, true)["results"][0]["distance"];
		}catch(Exception $e){
			$miles = sqrt(POW((6370693.5 * cos($start_address['latitude'] * 0.01745329252) * ($end_address['longitude'] * 0.01745329252 - $start_address['longitude'] * 0.01745329252)),2) + POW((6370693.5 * ($end_address['latitude'] * 0.01745329252 - $start_address['latitude'] * 0.01745329252)),2)) * 1.1;
		}
		
		$this->db->query("update `t_aci_order` set miles='{$miles}' where order_id={$order_id}");
		$array["order_id"] = "{$order_id}";
		$this->output_result ( 0, 'success',  $array);		
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
		$this->db->query("update `t_aci_order` set status='未接单',driver_id=NULL ,accept_order_time=NULL where order_id in (select * from (select order_id from `t_aci_order` where status='接单中' and TIMESTAMPDIFF(SECOND,accept_order_time,CURRENT_TIMESTAMP()) >= 600) t1)");

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
			$str = "";
			if($start_city != "" && $start_city != "全市" && $start_city != "全省"){
				$str .= " and t1.city='{$start_city}'";
			}
			if($start_area != "" && $start_area != "全市")
			{
				$str .= " and t1.area='{$start_area}'";
			}
			if($end_city != "" && $end_city != "全市" && $end_city != "全省"){
				$str .= " and t2.city='{$end_city}'";
			}
			if($end_area != "" && $end_area != "全市")
			{
				$str .= " and t2.area='{$end_area}'";
			}
			$query_str = "
			select t4.*,t3.`truck_type`,t3.`truck_size`,t3.start_place,t3.end_place,t3.charge,t3.miles,t3.start_time,t3.end_time,t3.unit from t_aci_order  t3
			JOIN(
				SELECT t1.order_id,
				t1.`latitude` as start_place_latitude,t1.`longitude` as start_place_longitude,t2.`latitude`  as end_place_latitude,t2.`longitude` as end_place_longitude FROM `t_aci_address`  t1  LEFT join `t_aci_address` t2 on t1.order_id=t2.order_id where  t1.state='{$start_state}'" . $str . " and t1.type='出发地'
				and  t2.state='{$end_state}' and t2.type='目的地'
    		) t4 on t3.order_id=t4.order_id where t3.status='未接单' and t3.end_time > now() order by t3.start_time desc
			";
		}else{
			// sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance',
			// 		sqrt(POW((6370693.5 * cos({$maplatitude} * 0.01745329252) * ({$maplongitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$maplatitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'mapdistance',
			$distance = $distance >= 50000 ? 50000 : $distance;
			$query_str = "
			select t4.*,t3.`truck_type`,t3.`truck_size`,t3.start_place,t3.end_place,t3.charge,t3.miles,t3.start_time,t3.end_time,t3.unit from t_aci_order  t3
			JOIN(
				SELECT t1.order_id,0 as 'distance',0 as 'mapdistance',
				t1.`latitude` as start_place_latitude,t1.`longitude` as start_place_longitude FROM `t_aci_address`  t1
				where t1.type='出发地' and t1.latitude between ($maplatitude - 0.1) and ($maplatitude + 0.1) and t1.longitude between ($maplongitude - 0.1) and ($maplongitude + 0.1)
    		) t4 on t3.order_id=t4.order_id where t3.status='未接单' and t4.mapdistance <= $distance and t3.end_time > now() order by t4.distance desc
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
		$distance = $distance >= 50000 ? 50000 : $distance;
		$query = $this->db->query ( " select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos({$latitude} * 0.01745329252) * ({$longitude} * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ({$latitude} * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance',t1.latitude,t1.longitude,t1.course,t1.driver_id,t1.nickname,t1.photo
									from `t_aci_driver` t1 where t1.status='认证成功' order by t1.driver_id ) t2 
									where distance <= $distance
					  				" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	//获取流水
	public function get_orderflow_list() {
		$user_type = $this->format_get("user_type");
		$user_id = $this->encrypt->decode ( $this->format_get ( 'user_id' ), $this->key );
		$number = $this->format_get("number");
		$page = $this->format_get("page");
		$start = ($page - 1) * $number;

		$query = $this->db->query ( "select * from `t_aci_orderflow` where user_id='{$user_id}' and user_type='{$user_type}' order by time desc limit {$start},{$number}" );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	public function get_driver_info_by_id()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$result = $this->db->query( "select nickname,photo,telephone,truck_type,truck_size,truck_head_photo,jiashi_photo,yingyun_photo,drive_license,truck_full_photo,status,status_memo,default_route_id,recommend_code,amount,rest_amount from `t_aci_driver` where driver_id={$driver_id}" )->result_array();
		if(count($result) > 0)
		{
			$this->output_result ( 0, 'success', $result[0] );
		}else{
			$this->output_result ( -1, 'failed', '用户信息有误' );
		}
	}
	
	private function update_amount($order_id){
		$order = $this->db->query("select * from `t_aci_order` where order_id={$order_id}")->result_array()[0];
		$driver = $this->db->query("select * from `t_aci_driver` where driver_id={$order['driver_id']}")->result_array()[0];
		$recommend_user = $this->db->query("select * from `t_aci_customer` where recommend_code='{$driver['be_recommend_code']}'")->result_array();
		if($order['status'] == "货主确认装货完毕")
		{
			$fee = min($order['charge'] * 0.05,300);
			$driver_fee = $order['charge'] - $fee;
			$this->db->query("update `t_aci_driver` set amount = amount + {$driver_fee},rest_amount = rest_amount + {$driver_fee} where driver_id = {$driver['driver_id']}");
			$data['user_id'] = $driver['driver_id'];
			$data['time'] = date("Y-m-d H:i:s",time());
			$data['user_type'] = "driver";
			$data['order_id'] = $order_id;
			$data['amount'] = $driver_fee;
			$data['is_plus'] = "1";
			$data['type'] = "订单收入";
			$this->db->insert('t_aci_orderflow',$data);

			if(count($recommend_user) > 0 && $driver['be_recommend_code'] != "")
			{
				$recommend_fee = $fee*0.2;
				$this->db->query("update `t_aci_customer` set amount = amount + {$recommend_fee},rest_amount = rest_amount + {$recommend_fee} where customer_id = {$recommend_user[0]['customer_id']}");
				$data['user_id'] = $recommend_user[0]['customer_id'];
				$data['time'] = date("Y-m-d H:i:s",time());
				$data['user_type'] = "customer";
				$data['order_id'] = $order_id;
				$data['amount'] = $recommend_fee;
				$data['is_plus'] = "1";
				$data['type'] = "佣金收入";
				$this->db->insert('t_aci_orderflow',$data);
			}
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
		$result = $this->db->query( "select nickname,photo,telephone,status,customer_type,name,identity_photo,status_memo,recommend_code,amount,rest_amount from `t_aci_customer` where customer_id={$customer_id}" )->result_array();
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
			$order = $this->db->query("select * from `t_aci_order` t1 where status='未接单' and order_id={$order_id} and truck_type='{$driver['truck_type']}' and truck_size LIKE '%{$driver['truck_size']}%'")->result_array();

			if(count($order) > 0)
			{
				$this->db->query("update `t_aci_order` set status='接单中' , driver_id={$driver_id} , accept_order_time='{$accept_order_time}' where order_id={$order_id}");



				$customer = $this->db->query("select telephone,device_type from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0];
				$customer_telephone = $customer["telephone"];
				$device_type = $customer["device_type"];				
				$this->zhaoche_notification("customer_".$device_type,$customer_telephone,"您的订单已有货车司机接单,点击查看",$order_id);

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
		$data ['course'] = $this->format_get ( 'course' );
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$this->db->query("update `t_aci_driver` set longitude='{$data ['longitude']}',latitude='{$data ['latitude']}',course='{$data['course']}' where driver_id={$driver_id}");
		$this->output_result ( 0, 'success', 'success' );
	}

	public function get_driver_location()
	{
		$driver_id = $this->format_get ( 'driver_id' );
		$result = $this->db->query("select longitude,latitude from `t_aci_driver` where driver_id={$driver_id}")->result_array();
		$this->output_result ( 0, 'success', $result[0] );
	}


	public function confirm_accept_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='接单中' and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '该订单有误，请联系管理员' );
		}else{
			$this->db->query("update `t_aci_order` set status='已接单' where order_id={$order_id}");
			//$this->update_amount($order_id);
			$driver = $this->db->query("select telephone,device_type from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0];
			$driver_telephone = $driver["telephone"];
			$device_type = $driver["device_type"];
			$this->zhaohuo_notification("driver_" . $device_type,$driver_telephone,"货主已确认您的接单,点击查看",$order_id);

			$this->sms_content($driver_telephone,"【嘟嘟找货】货主已确认您的接单，请尽快联系货主");
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

			$customer = $this->db->query("select telephone,device_type from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("customer_".$device_type,$customer_telephone,"货车司机取消了您的订单,点击查看",$order_id);
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

				$driver = $this->db->query("select telephone,device_type from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0];
				$driver_telephone = $driver["telephone"];
				$device_type = $driver["device_type"];				
				$this->zhaoche_notification("driver_".$device_type,$driver_telephone,"货主已取消订单,点击查看",$order_id);

				$this->sms_content($driver_telephone,"【嘟嘟找货】货主已取消订单，请查看信息");
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

			$customer = $this->db->query("select telephone,device_type from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("customer_".$device_type,$customer_telephone,"货车司机对您的取消订单操作有异义",$order_id);
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

			$customer = $this->db->query("select telephone,device_type from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("driver_".$device_type,$customer_telephone,"货主对您的取消订单操作有异义,点击查看",$order_id);

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

			$customer = $this->db->query("select telephone,device_type from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("customer_".$device_type,$customer_telephone,"货车司机同意您的取消订单操作，点击查看",$order_id);
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

			$customer = $this->db->query("select telephone,device_type from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("driver_".$device_type,$customer_telephone,"货主同意了您的取消订单操作",$order_id);
			$this->sms_content($customer_telephone,"【嘟嘟找货】货主同意您的取消订单操作");
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

			$customer = $this->db->query("select telephone,device_type from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("customer_".$device_type,$customer_telephone,"货车司机已为您装货完毕，点击查看",$order_id);
			$this->sms_content($customer_telephone,"【嘟嘟找车】货车司机已为您装货完毕");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//装货完毕
	// function loading_complete_by_customer()
	// {
	// 	$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
	// 	$order_id = $this->format_get('order_id');
	// 	//$accept_order_time = date("Y-m-d H:i:s",time());
	// 	$r = $this->db->query("select * from `t_aci_order` where order_id={$order_id} and customer_id={$customer_id}")->result_array();
	// 	if(count($r) == 0)
	// 	{
	// 		$this->output_result ( 0, 'failed', '非法操作' );
	// 	}else{
	// 		$this->db->query("update `t_aci_order` set status='货主确认装货完毕' where order_id={$order_id}");

	// 		$customer = $this->db->query("select telephone,device_type from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0];
	// 		$customer_telephone = $customer["telephone"];
	// 		$device_type = $customer["device_type"];			
	// 		$this->zhaoche_notification("driver_".$device_type,$customer_telephone,"货主已确认装货完毕，点击查看",$order_id);

	// 		$this->sms_content($customer_telephone,"【嘟嘟找货】货主已确认装货完毕");
	// 		$this->output_result ( 0, 'success', 'success' );
	// 	}
	// }

	function update_sign()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$field = $this->format_get('field');

		$config ['upload_path'] = getcwd () . '/upload/sign/';
		$config ['file_name'] = 'order_' . random_string () . '-' . $order_id;
		$config ['allowed_types'] = 'gif|jpg|png';

		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		if (! $this->upload->do_upload ( 'sign_image' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 1, 'failed', $this->upload->display_errors () );
		} else {
			$image_path = '/sign/' . $this->upload->data ()['file_name'];
		}
		$this->db->query("update `t_aci_order` set {$field}='{$image_path}' where order_id={$order_id}");
		$this->output_result ( 0, 'success', 'success' );
	}

		//司机任务完成
	function complete_order_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$payment_express_number = $this->format_get('payment_express_number');


		//$accept_order_time = date("Y-m-d H:i:s",time());
		$r = $this->db->query("select * from `t_aci_order` where status='货主确认装货完毕' and order_id={$order_id} and driver_id={$driver_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '请等待用户确认装货完毕' );
		}else{
			$this->db->query("update `t_aci_order` set status='司机完成任务',payment_express_number='{$payment_express_number}' where order_id={$order_id}");

			$customer = $this->db->query("select telephone,device_type from `t_aci_customer` where customer_id={$r[0]['customer_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("customer_".$device_type,$customer_telephone,"货车司机已完成任务，快去确认吧",$order_id);
			$this->sms_content($customer_telephone,"【嘟嘟找车】货车司机已完成任务，快去确认吧");
			$this->output_result ( 0, 'success', 'success' );
		}
	}

	//货主任务完成
	function complete_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');


		$r = $this->db->query("select * from `t_aci_order` where order_id={$order_id} and customer_id={$customer_id}")->result_array();
		if(count($r) == 0)
		{
			$this->output_result ( 0, 'failed', '请等待用户确认装货完毕' );
		}else{
			$this->db->query("update `t_aci_order` set status='已完成' where order_id={$order_id}");
			//$this->update_amount($order_id);
			$customer = $this->db->query("select telephone,device_type from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0];
			$customer_telephone = $customer["telephone"];
			$device_type = $customer["device_type"];			
			$this->zhaoche_notification("driver_".$device_type,$customer_telephone,"恭喜您完成任务",$order_id);
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
		$device_type = $this->format_get ( 'device_type' );


		$result = $this->db->query ( "select * from `t_aci_customer` where telephone = '{$telephone}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$result2 = $this->db->query ( "select * from `t_aci_customer` where telephone = '{$telephone}' and password='{$password}'" )->result_array ();
			if (count ( $result2 ) >= 1) {
				$array ['customer_id'] = $this->encrypt->encode ( $result2 [0] ['customer_id'], $this->key );
				$array ['telephone'] = $result2 [0] ['telephone'];
				$array ['name'] = $result2 [0] ['name'];
				$array ['recommend_code'] = $result2 [0] ['recommend_code'];
				$array ['identity_photo'] = $result2 [0] ['identity_photo'];
				$array ['status'] = $result2 [0] ['status'];
				$array ['status_memo'] = $result2 [0] ['status_memo'];
				$array ['last_login'] = $result2 [0] ['last_login'];
				$array ['customer_type'] = $result2 [0] ['customer_type'];

				if($result2[0]['device_type'] != $device_type)
				{
					$this->db->query("update `t_aci_customer` set device_type='{$device_type}' where customer_id={$result2[0]['customer_id']}");
				}
				$last_login = date("Y-m-d H:i:s",time());
				$this->db->query("update `t_aci_customer` set last_login='{$last_login}' where customer_id={$result2[0]['customer_id']}");

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
		$authcode = $this->format_get ( 'authcode' );
		// $secret_authcode = $this->format_get ( 'secret_authcode' );
		// $secret_telephone = $this->format_get ( 'secret_telephone' );
		$telephone = $this->format_get ( 'telephone' );
		$customer_type = $this->format_get('customer_type');
		$password = $this->format_get('password');
		$be_recommend_code = $this->format_get('be_recommend_code');


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

		if($be_recommend_code != "")
		{
			$count1 = $this->db->query("select count(driver_id) as count from `t_aci_driver` where recommend_code='{$be_recommend_code}'")->result_array()[0]['count'];
			$count2 = $this->db->query("select count(customer_id) as count from `t_aci_customer` where recommend_code='{$be_recommend_code}'")->result_array()[0]['count'];
			if($count1 + $count2 == 0)
			{
				$this->output_result ( - 1, 'failed', '请确认邀请码是否填写正确' );
			}
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
			$recommend_code = $this->randStr(5);
			$count1 = $this->db->query("select count(driver_id) as count from `t_aci_driver` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
			$count2 = $this->db->query("select count(customer_id) as count from `t_aci_customer` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
			while(($count1 + $count2) > 0)
			{
				$recommend_code = randStr(5);
				$count1 = $this->db->query("select count(driver_id) as count from `t_aci_driver` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
				$count2 = $this->db->query("select count(customer_id) as count from `t_aci_customer` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
			}
			$data['recommend_code'] = $recommend_code;
			$data['be_recommend_code'] = $be_recommend_code;
			$data['telephone'] = $telephone;
			$data['password'] = md5 ( $this->key . $password);
			$data['customer_type'] = $customer_type;
			$data['status'] = '未认证';
			$this->db->insert('t_aci_customer',$data);

			$member['username'] = $telephone;
			$member['encrypt'] = random_string('alnum',5);
			$member['password'] = md5(md5($password.$member['encrypt']));
			$member['group_id'] = '3';
			$member['user_id'] = $this->db->insert_id();
			$this->db->insert('t_sys_member',$member);

			$this->output_result ( 0, 'success', '' );
		}
	}

	//车主注册
	public function customer_reset_password() {
		$telephone = $this->format_get ( 'telephone' );
		$authcode = $this->format_get ( 'authcode' );
		// $secret_authcode = $this->format_get ( 'secret_authcode' );
		// $secret_telephone = $this->format_get ( 'secret_telephone' );
		$telephone = $this->format_get ( 'telephone' );
		$password = $this->format_get('password');


		if($telephone == "")
		{
			$this->output_result ( - 1, 'failed', '手机号码不能为空' );
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
			$password = md5 ( $this->key . $password);
			$this->db->query("update `t_aci_customer` set password='{$password}' where telephone='{$telephone}'");
			$this->output_result ( 0, 'success', '' );
		} else {
			$this->output_result ( - 1, 'failed', '该用户不存在' );
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

		$be_recommend_code = $this->format_get('be_recommend_code');

		if($be_recommend_code != "")
		{
			$count1 = $this->db->query("select count(driver_id) as count from `t_aci_driver` where recommend_code='{$be_recommend_code}'")->result_array()[0]['count'];
			$count2 = $this->db->query("select count(customer_id) as count from `t_aci_customer` where recommend_code='{$be_recommend_code}'")->result_array()[0]['count'];
			if($count1 + $count2 == 0)
			{
				$this->output_result ( - 1, 'failed', '请确认邀请码是否填写正确' );
			}
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
			$recommend_code = $this->randStr(5);
			$count1 = $this->db->query("select count(driver_id) as count from `t_aci_driver` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
			$count2 = $this->db->query("select count(customer_id) as count from `t_aci_customer` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
			while(($count1 + $count2) > 0)
			{
				$recommend_code = randStr(5);
				$count1 = $this->db->query("select count(driver_id) as count from `t_aci_driver` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
				$count2 = $this->db->query("select count(customer_id) as count from `t_aci_customer` where recommend_code='{$recommend_code}'")->result_array()[0]['count'];
			}
			$data['recommend_code'] = $recommend_code;
			$data['be_recommend_code'] = $be_recommend_code;
			$data['telephone'] = $telephone;
			$data['password'] = md5 ( $this->key . $password);
			$data['truck_type'] = $truck_type;
			$data['truck_size'] = $truck_size;
			$data['status'] = '未认证';
			$this->db->insert('t_aci_driver',$data);
			$this->output_result ( 0, 'success', '' );
		}
	}

		//车主注册
	public function driver_reset_password() {
		$telephone = $this->format_get ( 'telephone' );
		$authcode = $this->format_get ( 'authcode' );
		// $secret_authcode = $this->format_get ( 'secret_authcode' );
		// $secret_telephone = $this->format_get ( 'secret_telephone' );
		$telephone = $this->format_get ( 'telephone' );
		$password = $this->format_get('password');


		if($telephone == "")
		{
			$this->output_result ( - 1, 'failed', '手机号码不能为空' );
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
			$password = md5 ( $this->key . $password);
			$this->db->query("update `t_aci_driver` set password='{$password}' where telephone='{$telephone}'");
			$this->output_result ( 0, 'success', '' );
		} else {
			$this->output_result ( - 1, 'failed', '该用户不存在' );
		}
	}


	// 车主登陆
	public function driver_login() {
		$telephone = $this->format_get ( 'telephone' );
		$password = md5 ( $this->key . $this->format_get ( 'password' ) );
		$device_type = $this->format_get( 'device_type' );

		$result = $this->db->query ( "select * from `t_aci_driver` where telephone = '{$telephone}'" )->result_array ();
		
		if (count ( $result ) >= 1) {
			$result2 = $this->db->query ( "select * from `t_aci_driver` where telephone = '{$telephone}' and password='{$password}'" )->result_array ();
			if (count ( $result2 ) >= 1) {

				$array ['driver_id'] = $this->encrypt->encode ( $result2 [0] ['driver_id'], $this->key );
				$array ['telephone'] = $result2 [0] ['telephone'];
				$array ['nickname'] = $result2 [0] ['nickname'];
				$array ['photo'] = $result2 [0] ['photo'];
				$array ['truck_size'] = $result2 [0] ['truck_size'];
				$array ['truck_type'] = $result2 [0] ['truck_type'];
				$array ['status'] = $result2 [0] ['status'];
				$array ['status_memo'] = $result2 [0] ['status_memo'];
				$array ['last_login'] = $result2 [0] ['last_login'];
				$array ['recommend_code'] = $result2 [0] ['recommend_code'];

				if($result2[0]['device_type'] != $device_type)
				{
					$this->db->query("update `t_aci_driver` set device_type='{$device_type}' where driver_id={$result2[0]['driver_id']}");
				}
				$last_login = date("Y-m-d H:i:s",time());
				$this->db->query("update `t_aci_driver` set last_login='{$last_login}' where driver_id={$result2[0]['driver_id']}");


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
			$query_str = " select t1.* from `t_aci_order` t1 where t1.customer_id='{$customer_id}' and t1.status not in ('已完成','已取消') order by t1.create_time desc limit {$start},{$number}";
		}else{
			$query_str = " select t1.* from `t_aci_order` t1 where t1.customer_id='{$customer_id}' and t1.status in ('已完成') order by t1.create_time desc limit {$start},{$number}";
		}
		$query = $this->db->query ( $query_str );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	function get_output_orderlist_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$status = $this->format_get( 'status' );
		$time = $this->format_get( 'time');
		$query_str = " select t1.* from `t_aci_order` t1 where t1.customer_id='{$customer_id}'";
		if($status == 1)
		{
			$query_str .= " and t1.status not in ('已完成','已取消') ";
		}else if($status == 2){
			$query_str .= "  and t1.status in ('已完成')";
		}
		if ($time == '7天内')
		{
			$query_str .= " and datediff(now(),create_time) <= 7";
		}
		if ($time == '30天内')
		{
			$query_str .= " and datediff(now(),create_time) <= 30";
		}
		if ($time == '90天内')
		{
			$query_str .= " and datediff(now(),create_time) <= 90";
		}
		$query = $this->db->query ( $query_str );
		$this->output_result ( 0, 'success', $query->result_array () );
	}

	function output_orders_by_customer() 
	{ 
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$mail = $this->format_get( 'mail' );
		$ids = $this->format_get( 'ids');

		$query = $this->db->query("select * from `t_aci_order` WHERE customer_id= {$customer_id} and order_id in ({$ids})"); 
		//$query = mb_convert_encoding("gb2312", "UTF-8", $query); 
		if(!$query) 
			return false; 
		// Starting the PHPExcel library 
		$this->load->library('PHPExcel'); 
		$this->load->library('PHPExcel/IOFactory'); 
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none"); 
		$objPHPExcel->setActiveSheetIndex(0) 
		->setCellValue('A1', 'sss') 
		->setCellValue('B2', 'world!') 
		->setCellValue('C1', 'Hello'); 
		// Field names in the first row 
		$fields['order_id'] = "订单id"; 
		$fields['create_time'] = "创建时间"; 
		$fields['truck_type'] = "货车类型"; 
		$fields['truck_size'] = "货车大小"; 
		$fields['start_place'] = "出发地";
		$fields['end_place'] = "目的地";
		$fields['start_time'] = "出发时间";
		$fields['charge'] = "费用";
		$fields['weight'] = "重量(t)";
		$fields['miles'] = "公里数(km)";
		$col = 0; 

		foreach ($fields as $field) 
		{ 
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field); 
			$col++; 
		} 
		// Fetching the table data 
		$row = 2; 
		foreach($query->result_array() as $data) 
		{ 
			$col = 0; 
			foreach ($fields as $key=>$field) 
			{ 
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data[$key]); 
				$col++; 
			} 
			$row++; 
		} 
		$objPHPExcel->setActiveSheetIndex(0); 
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		//发送标题强制用户下载文件 
		$file_name = getcwd () . '/output/order_' .$customer_id . time() .'.xls';
		$objWriter->save( $file_name );
		
		$this->load->library('email');

		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.126.com';
        $config['smtp_user'] = 'mawei7895123@126.com';//这里写上你的163邮箱账户
		$config['smtp_pass'] = '19880709abc';//这里写上你的163邮箱密码
		$config['mailtype'] = 'html';
		$config['validate'] = true;
		$config['priority'] = 1;
		$config['crlf']  = "\r\n";
		$config['smtp_port'] = 25;
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;

        $this->email->initialize($config);

		$this->email->from('mawei7895123@126.com', '嘟嘟找车');
		$this->email->to($mail);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		$this->email->attach($file_name);
		$this->email->subject('订单导出');
		$this->email->message('附件为导出的相关订单，请您查收');

		$this->email->send();
		$this->output_result ( 0, 'success', '导出成功' );
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
				if($r['accept_remain_time']  >= 600)
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

	function get_current_order_by_customer()
	{
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$query_str = " select t1.* from `t_aci_order` t1 where t1.status not in ('已完成','已取消','司机反对取消订单') and t1.customer_id='{$customer_id}' order by t1.create_time desc";
		$result = $this->db->query ( $query_str )->result_array ();
		if(count($result) > 0)
		{
			$r = $result[0];
			$this->output_result ( 0, 'success', $r );
		}else{
			$this->output_result ( -1, 'failed', '当前没有未处理完订单' );
		}
	}

	function get_order_detail_by_driver()
	{
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$order_id = $this->format_get('order_id');
		$query_str = " select t1.*,TIMESTAMPDIFF(SECOND,t1.accept_order_time,CURRENT_TIMESTAMP()) as accept_remain_time,t2.photo as customer_photo,t2.nickname as customer_nickname,t2.telephone as customer_telephone from `t_aci_order` t1 left join `t_aci_customer` t2 on t1.customer_id=t2.customer_id 
			where t1.order_id='{$order_id}' and (t1.driver_id='{$driver_id}' or t1.driver_id IS NULL or t1.driver_id='')";
		$result = $this->db->query ( $query_str )->result_array ();

		if(count($result) > 0)
		{
			$address = $this->db->query ("select * from `t_aci_address` where order_id='{$order_id}' and type='目的地'")->result_array();
			$r = $result[0];
			if(count($address) > 0)
			{
				$r['end_place_latitude'] = $address[0]['latitude'];
				$r['end_place_longitude'] = $address[0]['longitude'];
			}
			if($r['status'] == '接单中' )
			{
				if($r['accept_remain_time']  >= 600)
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
			$query_str = " select t1.* from `t_aci_order` t1 where t1.driver_id='{$driver_id}' and t1.status not in ('已完成','已取消') order by t1.create_time desc limit {$start},{$number}";
		}else{
			$query_str = " select t1.* from `t_aci_order` t1 where t1.driver_id='{$driver_id}' and t1.status in ('已完成','已取消') order by t1.create_time desc limit {$start},{$number}";
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
		$query = $this->db->query ( $query_str )->result_array ();
		if(count($query) > 0)
		{
			$this->output_result ( 0, 'success', $query[0] );
		}else{
			$this->output_result ( -1, 'error', "请重新设置首选常跑路线" );
		}
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
		if ($this->format_get ( 'method',"" ) == 'reset_password')
		{
			if(count($result) == 0)
			{
				$this->output_result(-1, 'failed', '该手机号未注册');
			}else{
				$this->sms_code ( $mobile, $authcode );
				$this->output_result(0, 'success', $res);
			}
		}else{
			if(count($result) == 0)
			{
				$this->sms_code ( $mobile, $authcode );
				$this->output_result(0, 'success', $res);
			}else{
				$this->output_result(-1, 'failed', '该手机号已注册');
			}
		}
			
	}

	public function get_authcode_by_driver() {
		$mobile = $this->format_get ( 'mobile' );
		$authcode = mt_rand ( 111111, 999999 );
	
		$res['telephone'] = $this->encrypt->encode ( $mobile, $this->key );
		$res['authcode'] = $this->encrypt->encode ( $authcode, $this->key );
	
		$result = $this->db->query ( "select * from `t_aci_driver` where telephone = '{$mobile}'" )->result_array ();
		if ($this->format_get ( 'method',"" ) == 'reset_password')
		{
			if(count($result) == 0)
			{
				$this->output_result(-1, 'failed', '该手机号未注册');
			}else{
				$this->sms_code ( $mobile, $authcode );
				$this->output_result(0, 'success', $res);
			}
		}else{
			if(count($result) == 0)
			{
				$this->sms_code ( $mobile, $authcode );
				$this->output_result(0, 'success', $res);
			}else{
				$this->output_result(-1, 'failed', '该手机号已注册');
			}
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
			$this->output_result ( - 2, 'failed', $this->upload->display_errors () );
		} else {
			$truck_head_image = '/driver/' . $this->upload->data ()['file_name'];
		}
		if (! $this->upload->do_upload ( 'truck_full_image' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 3, 'failed', $this->upload->display_errors () );
		} else {
			$truck_full_image = '/driver/' . $this->upload->data ()['file_name'];
			
		}
		if (! $this->upload->do_upload ( 'yingyun_image' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 3, 'failed', $this->upload->display_errors () );
		} else {
			$yingyun_image = '/driver/' . $this->upload->data ()['file_name'];
			
		}
		if (! $this->upload->do_upload ( 'jiashi_image' )) {
			$data ['log'] = $this->upload->display_errors ();
			$data ['create_time'] = time ();
			$this->db->insert ( 'log', $data );
			$this->output_result ( - 3, 'failed', $this->upload->display_errors () );
		} else {
			$jiashi_image = '/driver/' . $this->upload->data ()['file_name'];
			
		}
		$this->db->query ( "update `t_aci_driver` set drive_license='{$driver_license_image}',truck_head_photo='{$truck_head_image}',truck_full_photo='{$truck_full_image}',yingyun_photo='{$yingyun_image}',jiashi_photo='{$jiashi_image}',status='认证中' where driver_id={$driver_id}" );

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

	public function pay_back()
	{
		require_once(APPPATH."thirdparty/sdk/acp_service.php");
		if (isset ( $_POST ['signature'] )) {	
			//echo com\unionpay\acp\sdk\AcpService::validate ( $_POST ) ? '验签成功' : '验签失败';
			$orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
			$order_id = substr($orderId, 8);
			$respCode = $_POST ['respCode']; //判断respCode=00或A6即可认为交易成功
			if(com\unionpay\acp\sdk\AcpService::validate ( $_POST )&&($respCode == "00" || $respCode == "A6"))
			{
				$this->db->query("update `t_aci_order` set status='货主确认装货完毕' where order_id={$order_id}");
				$r = $this->db->query("select driver_id from `t_aci_order` where order_id={$order_id}")->result_array();
				$driver = $this->db->query("select telephone,device_type from `t_aci_driver` where driver_id={$r[0]['driver_id']}")->result_array()[0];
				$driver_telephone = $driver["telephone"];
				$device_type = $driver["device_type"];			
				$this->zhaohuo_notification("driver_".$device_type,$driver_telephone,"货主已确认装货完毕，点击查看",$order_id);
				$this->update_amount($order_id);
				$this->sms_content($driver_telephone,"【嘟嘟找货】货主已付款");
			}else{
				$this->db->query("update `t_aci_order` set status='已接单' where order_id={$order_id}");
			}

		} else {
			echo '签名为空';
		}
	}

	public function to_cash_by_driver()
	{
		$bank = $this->format_get("bank");
		$driver_id = $this->encrypt->decode ( $this->format_get ( 'driver_id' ), $this->key );
		$bankcard = $this->format_get("bankcard");
		$bankarea = $this->format_get("bankarea");
		$money = $this->format_get("money");
		$name = $this->format_get("name");
		$driver = $this->db->query("select * from `t_aci_driver` where driver_id = {$driver_id}")->result_array()[0];
		if($money > $driver['rest_amount'])
		{
			$this->output_result ( -1, 'failed', '提现金额不能超过余额' );
		}else{
			$data['user_type'] = 'driver';
			$data['user_id'] = $driver_id;
			$data['bank'] = $bank;
			$data['bankcard'] = $bankcard;
			$data['bankarea'] = $bankarea;
			$data['money'] = $money;
			$data['name'] = $name;
			$data['status'] = '未审核'; 
			$data['time'] = date("Y-m-d H:i:s",time());
			$this->db->insert('t_aci_cash',$data);	
			$this->db->query("update `t_aci_driver` set rest_amount=rest_amount-{$money} where driver_id={$driver_id}");	
			$this->output_result ( 0, 'success', '提现成功' );
		}
	}

	public function to_cash_by_customer()
	{
		$bank = $this->format_get("bank");
		$customer_id = $this->encrypt->decode ( $this->format_get ( 'customer_id' ), $this->key );
		$bankcard = $this->format_get("bankcard");
		$bankarea = $this->format_get("bankarea");
		$money = $this->format_get("money");
		$name = $this->format_get("name");
		$customer = $this->db->query("select * from `t_aci_customer` where customer_id = {$customer_id}")->result_array()[0];
		if($money > $customer['rest_amount'])
		{
			$this->output_result ( -1, 'failed', '提现金额不能超过余额' );
		}else{
			$data['user_type'] = 'customer';
			$data['user_id'] = $customer_id;
			$data['bank'] = $bank;
			$data['bankcard'] = $bankcard;
			$data['bankarea'] = $bankarea;
			$data['money'] = $money;
			$data['name'] = $name;
			$data['status'] = '未审核'; 
			$data['time'] = date("Y-m-d H:i:s",time());
			$this->db->insert('t_aci_cash',$data);	
			$this->db->query("update `t_aci_customer` set rest_amount=rest_amount-{$money} where customer_id={$customer_id}");	
			$this->output_result ( 0, 'success', '提现成功' );
		}
	}


	public function pay(){
		require_once(APPPATH."thirdparty/sdk/acp_service.php");
		$params = array(
		
		//以下信息非特殊情况不需要改动
		'version' => '5.0.0',                 //版本号
		'encoding' => 'utf-8',				  //编码方式
		'txnType' => '01',				      //交易类型
		'txnSubType' => '01',				  //交易子类
		'bizType' => '000201',				  //业务类型
		'frontUrl' =>  com\unionpay\acp\sdk\SDK_FRONT_NOTIFY_URL,  //前台通知地址
		'backUrl' => com\unionpay\acp\sdk\SDK_BACK_NOTIFY_URL,	  //后台通知地址
		'signMethod' => '01',	              //签名方法
		'channelType' => '08',	              //渠道类型，07-PC，08-手机
		'accessType' => '0',		          //接入类型
		'currencyCode' => '156',	          //交易币种，境内商户固定156
		
		//TODO 以下信息需要填写
		'merId' => $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
		'orderId' => $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
		'txnTime' => $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
		'txnAmt' => $_POST["txnAmt"],	//交易金额，单位分，此处默认取demo演示页面传递的参数
		// 		'reqReserved' =>'透传信息',        //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据

				//TODO 其他特殊用法请查看 pages/api_05_app/special_use_purchase.php
			);

		com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
		$url = com\unionpay\acp\sdk\SDK_App_Request_Url;

		$result_arr = com\unionpay\acp\sdk\AcpService::post ($params,$url);
		if(count($result_arr)<=0) { //没收到200应答的情况
			return;
		}

		if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
			echo "应答报文验签失败<br>\n";
			return;
		}

		if ($result_arr["respCode"] == "00"){
		    //成功
		    //TODO
		    echo $result_arr["tn"];
		} else {
		    //其他应答码做以失败处理
		     //TODO
		     echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
		}
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

	private function randStr($i){
		$str = "abcdefghijklmnopqrstuvwxyz";
		$finalStr = "";
		for($j=0;$j<$i;$j++)
		{
		    $finalStr .= substr($str,rand(0,25),1);
		}
		return $finalStr;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
