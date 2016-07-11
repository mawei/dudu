<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-07-01 08:12:12 --> 404 Page Not Found: Upload/1212
ERROR - 2016-07-01 08:12:16 --> 404 Page Not Found: Upload1212/index
ERROR - 2016-07-01 08:12:16 --> 404 Page Not Found: Upload201606271035232541jpg/index
ERROR - 2016-07-01 10:07:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'from `t_aci_driver` where onlinle_status='online'' at line 1 - Invalid query: select truck_type,truck_size, from `t_aci_driver` where onlinle_status='online'
ERROR - 2016-07-01 10:07:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'from `t_aci_driver` where onlinle_status='online'' at line 1 - Invalid query: select truck_type,truck_size, from `t_aci_driver` where onlinle_status='online'
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined index: latitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 200
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined index: longitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 201
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined index: distance /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 202
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined variable: page /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined variable: number /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:08:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '* 0.01745329252) * ( * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((' at line 2 - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos( * 0.01745329252) * ( * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ( * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1) 
									where distance <= 
					  				order by t1.driver_id and t1.onlinle_status='online'
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined index: latitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 200
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined index: longitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 201
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined index: distance /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 202
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined variable: page /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:08:36 --> Severity: Notice --> Undefined variable: number /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:08:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '* 0.01745329252) * ( * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((' at line 2 - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos( * 0.01745329252) * ( * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ( * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1) 
									where distance <= 
					  				order by t1.driver_id and t1.onlinle_status='online'
ERROR - 2016-07-01 10:09:11 --> Severity: Notice --> Undefined index: latitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 200
ERROR - 2016-07-01 10:09:11 --> Severity: Notice --> Undefined variable: page /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:09:11 --> Severity: Notice --> Undefined variable: number /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:09:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '* 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW(' at line 2 - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos( * 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ( * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1) 
									where distance <= 1000000000000
					  				order by t1.driver_id and t1.onlinle_status='online'
ERROR - 2016-07-01 10:09:24 --> Severity: Notice --> Undefined index: latitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 200
ERROR - 2016-07-01 10:09:24 --> Severity: Notice --> Undefined variable: page /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:09:24 --> Severity: Notice --> Undefined variable: number /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:09:24 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '* 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW(' at line 2 - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos( * 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ( * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1) 
									where distance <= 1000000000000
					  				order by t1.driver_id and t1.onlinle_status='online'
ERROR - 2016-07-01 10:09:47 --> Severity: Notice --> Undefined variable: page /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:09:47 --> Severity: Notice --> Undefined variable: number /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 203
ERROR - 2016-07-01 10:09:47 --> Query error: Every derived table must have its own alias - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos(0 * 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * (0 * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1) 
									where distance <= 1000000000000
					  				order by t1.driver_id and t1.onlinle_status='online'
ERROR - 2016-07-01 10:09:55 --> Query error: Every derived table must have its own alias - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos(0 * 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * (0 * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1) 
									where distance <= 1000000000000
					  				order by t1.driver_id and t1.onlinle_status='online'
ERROR - 2016-07-01 10:10:10 --> Query error: Unknown column 't1.driver_id' in 'order clause' - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos(0 * 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * (0 * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1) t2 
									where distance <= 1000000000000
					  				order by t1.driver_id and t1.onlinle_status='online'
ERROR - 2016-07-01 10:10:29 --> Query error: Unknown column 't1.onlinle_status' in 'order clause' - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos(0 * 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * (0 * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1 order by t1.driver_id and t1.onlinle_status='online') t2 
									where distance <= 1000000000000
					  				
ERROR - 2016-07-01 10:10:59 --> Query error: Unknown column 't1.onlinle_status' in 'where clause' - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos(0 * 0.01745329252) * (0 * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * (0 * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1 where t1.onlinle_status='online' order by t1.driver_id ) t2 
									where distance <= 1000000000000
					  				
