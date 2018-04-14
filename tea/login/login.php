<?php
    include '../../connectsql.php';
    date_default_timezone_set('Asia/Shanghai');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $selectSql = "SELECT * FROM `teachermanage` where `username` = '".$username."' AND `password` = '".$password."'";
    file_put_contents('login.txt',date('Y-m-d H:i:s',time())."selectSql=".$selectSql."\r\n",FILE_APPEND );
    $selectResult = $mysqli->query($selectSql)->fetch_assoc();

    $response = [];
    if (!empty($selectResult)){
        $response['status'] = 1;
        $response['msg'] = '登录成功';
        $response['time'] = date("Y-m-d H:i:s", time());

    } else {
        $response['status'] = -1;
        $response['msg'] = '账户不存在或密码错误';
        $response['time'] = date("Y-m-d H:i:s", time());
    }
    //echo json_encode($response,for);
    echo json_encode($response,true);
    file_put_contents('login.txt',date('Y-m-d H:i:s',time())."response=".json_encode($response,true)."\r\n",FILE_APPEND );
?>