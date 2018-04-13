<?php
    include '../../connectsql.php';
    date_default_timezone_set('Asia/Shanghai');
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $selectSql = "SELECT * FROM `studentmanage` where `username` = '".$username."'";
    file_put_contents('register.txt',date('Y-m-d H:i:s',time())."selectSql=".$selectSql."\r\n",FILE_APPEND );
    $selectResult = $mysqli->query($selectSql);
    $res = $mysqli -> affected_rows; //返回受影响的行数
    $response = [];
    if ($res == 1){
        $response['status'] = -1;
        $response['msg'] = 'sorry,该用户名已注册，请重试';
        $response['time'] = date("Y-m-d H:i:s",time());
    } else {
        $insertSql = "INSERT INTO `studentmanage` (`username`, `password`) VALUES ('".$username."','".$password."')";
        file_put_contents('register.txt',date('Y-m-d H:i:s',time())."insertSql=".$insertSql."\r\n",FILE_APPEND );
        $insertResult = $mysqli->query($insertSql);
        $insertRes = $mysqli->affected_rows;  //返回数据库中影响的行数
        if ($insertRes == 1)
        {
            $response['status'] = 1;
            $response['msg'] = '恭喜您，注册成功';
            $response['time'] = date("Y-m-d H:i:s",time());
        } else {
            $response['status'] = -1;
            $response['msg'] = 'sorry,注册失败，请重试';
            $response['time'] = date("Y-m-d H:i:s",time());

        }

    }
    //echo json_encode($response,for);
    echo json_encode($response,true);
    file_put_contents('register.txt',date('Y-m-d H:i:s',time())."response=".json_encode($response,true)."\r\n",FILE_APPEND );








?>