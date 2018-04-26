<?php

date_default_timezone_set('Asia/Shanghai');
    include '../Connect.php';
    include '../Config.php';
    $connect = new Connect();
    $connResult = $connect->connect(HOST,USER,PASSWORD,DB);
    if ($connResult) {
		// $arr = array(1001,1002,1003);
		// $json = json_encode($arr);
		// $sql = "insert into `stumessage`(`questionList`)value('".$json."')";
		$sql  = "select * from `stumessage`";
		$res = $connResult->query($sql);
		while (!$row = $res->fetch_assoc()) {
			if (!empty($row['questionList'])) {
				var_dump(json_decode($row['questionList'],true));
			}
		}

		print_r($res);
	} else {
		die('数据库链接失败');
	}