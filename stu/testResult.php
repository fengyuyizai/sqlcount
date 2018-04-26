<?php
date_default_timezone_set('Asia/Shanghai');

    include '../Connect.php';
    include '../Config.php';
    include '../Sqllog.php';
    $connect = new Connect();
    $connResult = $connect->connect(HOST,USER,PASSWORD,DB);
    $response = array();
    if ($connResult) {  
    	if($_POST){
    		$postCode = $_POST['code'];
    		$postField = $_POST['field'];
    		$username = $_POST['username'];
    		$postContentArr = array();
    		if (!empty($_POST['content'])) {
    			$postContent = $_POST['content'];
    			$postContentArr = array(json_encode($postContent,true));
    			//var_dump(array($postContent));
    		}   		
    		$postFieldArr = array(json_encode($postField,true));
    		if (!empty($postCode)) {
    			$sql = "select * from `questionlist` where code=$postCode";
	    		$result = $connResult->query($sql)->fetch_assoc();
	    		if (!empty($result['field'])) {
	    			if (!empty($result['content'])) {
	    				$fieldArr = array($result['field']);
	    				$contentArr = array($result['content']);
	    				// var_dump($postContentArr);
	    				// echo '2222222222';
	    				// var_dump($contentArr);
	    				// echo '3333333';


	    				if (!array_diff($postFieldArr,$fieldArr)) {  //==
	    					if(!empty($postContentArr)){
	    						ksort($postContentArr);
	    						ksort($contentArr);
	    						$result = true;
	    						foreach ($postContentArr as $postkey => $postvalue) {
	    							foreach ($contentArr as $key => $value) {
	    								// print_r($postkey);
	    								// echo '111111111';
	    								// print_r($key);
	    								// echo '2222222';
	    								// print_r($postvalue);
	    								// echo '333333333';
	    								// print_r($value);
	    								if($postkey != $key || $postvalue != $value){
	    									$result = false;break 2;
	    								}
	    							}
	    						}
	    						if ($result == true) {

	    							$sql = "select * from `stumessage` where `username`=$username";
	    							$res = $connResult->query($sql)->fetch_assoc();
	    							if(!empty($res['questionList'])){
	    								$questionlist = json_decode($res['questionList'],true);
	    								if(!in_array($postCode, $questionlist)){
	    									array_push($questionlist,$postCode);
		    								$newList  = json_encode($questionlist);
		    								$sql = "update `stumessage` set `questionList`='".$newList."'where `username`='".$username."'";
		    								// print_r($sql);
		    								$result = $connResult->query($sql);
		    								if(!empty($result)){
		    									$response['status'] = 1;
								    			$response['msg'] = 'success';
								    			$response['time'] = date("Y-m-d H:i:s", time());
		    								}

	    								} else {
	    									$response['status'] = 0;
							    			$response['msg'] = '请勿重复';
							    			$response['time'] = date("Y-m-d H:i:s", time());
	    								}
	    								

	    							} else {
	    								$response['status'] = 0;
						    			$response['msg'] = '信息有误，请重试';
						    			$response['time'] = date("Y-m-d H:i:s", time());
						    		}
	    							
	    						} else {
	    							$response['status'] = 0;
					    			$response['msg'] = 'fail';
					    			$response['time'] = date("Y-m-d H:i:s", time());
	    						}

	    					} else {
	    						$response['status'] = 0;
				    			$response['msg'] = 'fail';
				    			$response['time'] = date("Y-m-d H:i:s", time());
	    					}
	    				} else {
	    					$response['status'] = 0;
			    			$response['msg'] = 'fail';
			    			$response['time'] = date("Y-m-d H:i:s", time());
	    				}
    				
	    				
	    			} else {
	    				$fieldArr = array($result['field']);
	    				if (!array_diff($fieldArr, $postFieldArr)) {
	    					if (count($postContentArr) == 0) {
	    						$sql = "select * from `stumessage` where `username`='$username'";
	    						// print_r($sql);
    							$res = $connResult->query($sql)->fetch_assoc();
    							if(!empty($res['questionList'])){
    								$questionlist = json_decode($res['questionList'],true);
    							} else {
    								$questionlist = array();
    							}
								if(!in_array($postCode, $questionlist)){
									array_push($questionlist,$postCode);
									// var_dump($questionlist);
    								$newList  = json_encode($questionlist);
    								$sql = "update `stumessage` set `questionList`='".$newList."'where `username`='".$username."'";
    								// print_r($sql);
    								$result = $connResult->query($sql);
    								if(!empty($result)){
    									$response['status'] = 1;
						    			$response['msg'] = 'success';
						    			$response['time'] = date("Y-m-d H:i:s", time());
    								}

								} else {
									$response['status'] = 0;
					    			$response['msg'] = '请勿重复';
					    			$response['time'] = date("Y-m-d H:i:s", time());
								}
	    					} else {
	    						$response['status'] = 0;
				    			$response['msg'] = 'fail';
				    			$response['time'] = date("Y-m-d H:i:s", time());
	    					}
	    				}
	    			}
	    		} else {
	    			$response['status'] = 0;
	    			$response['msg'] = '信息有误，请重试';
	    			$response['time'] = date("Y-m-d H:i:s", time());
	    		}
    		}
    		

    		echo json_encode($response);

    	}



    }else {
    	die('数据库连接失败');
    }  

