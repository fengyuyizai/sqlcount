<?php
    include '../Connect.php';
    include '../Config.php';
    $connect = new Connect();
    $connResult = $connect->connect(HOST,USER,PASSWORD,DB);
    //var_dump($connResult);exit;
    $response = array();
    if ($connResult) {
    	//print_r($_POST);exit;
    	if($_POST){
    		$content = '';
            if (!empty($_POST['content'])) {
                // $content = addslashes(json_encode($_POST['content']));
        		$content = json_encode($_POST['content'],true);
            }
            // $field = json_encode($_POST['field'],JSON_FORCE_OBJECT);
    		$field = json_encode($_POST['field'],true);
    		$code = $_POST['code'];
    		$sql = "select * from `questionlist` where `code`=$code limit 1";
    		//print_r($sql);
    		$result = $connResult->query($sql);
    		//var_dump($result);
    		if(!empty($result)){
				$sql = "update `questionlist` set `content`='".$content."',`field`='".$field."' where code=".$code;
                print_r($sql);
				$updateResult = $connResult->query($sql);

				$updateRes = $connResult->affected_rows;
				if ($updateRes == 1) {
					$response['status'] = 1;
				    $response['msg'] = '执行成功';
				    $response['time'] = date("Y-m-d H:i:s", time());
				} else {
					$response['status'] = 0;
				    $response['msg'] = '执行失败';
				    $response['time'] = date("Y-m-d H:i:s", time());
				}

    		} else {
    			$response['status'] = 0;
    			$response['msg'] = '信息有误，请重试';
    			$response['time'] = date("Y-m-d H:i:s", time());
    		}
    		echo json_encode($response);

    	}
    }else {
    	die('数据库连接失败');
    }








     // $enjson = addslashes(json_encode($arr));  
     //    $insert = array('id'=>'','array'=>$enjson);  
     //    insert($table,$insert);  
     //    $value = select($table);  
     //    echo '<h3 style="color:red"><方式插入数据库中的内容:></h3>';  
     //    var_dump($value);  
     //    $deunjson = json_decode($value,true);  
     //    echo '<h3 style="color:red"><最终提取后处理的内容：></h3>';  
     //    var_dump($deunjson);  












