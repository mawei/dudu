<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-07-08 07:36:24 --> 404 Page Not Found: api//index
ERROR - 2016-07-08 07:36:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2016-07-08 07:36:40 --> Severity: Notice --> Undefined index: latitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 200
ERROR - 2016-07-08 07:36:40 --> Severity: Notice --> Undefined index: longitude /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 201
ERROR - 2016-07-08 07:36:40 --> Severity: Notice --> Undefined index: distance /Applications/XAMPP/xamppfiles/htdocs/dudu/application/controllers/api/Api.php 202
ERROR - 2016-07-08 07:36:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '* 0.01745329252) * ( * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((' at line 2 - Invalid query:  select * from (select t1.truck_type,t1.truck_size,
									sqrt(POW((6370693.5 * cos( * 0.01745329252) * ( * 0.01745329252 - t1.longitude * 0.01745329252)),2) + POW((6370693.5 * ( * 0.01745329252 - t1.latitude * 0.01745329252)),2)) as 'distance'
									from `t_aci_driver` t1 where t1.online_status='online' order by t1.driver_id ) t2 
									where distance <= 
					  				
ERROR - 2016-07-08 08:15:52 --> 404 Page Not Found: api/Api/register
