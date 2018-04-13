<?php
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $db = 'sqltest';
    $mysqli = new mysqli($host,$user,$password,$db);
    if ($mysqli -> connect_error){
        //die('Connect Error('.$mysqli->connect_errno .')' .$mysqli->connect_error);
        $response = [];
        $response[status] = -1;
        $response['msg'] = '数据库连接失败，失败原因：'.$mysqli->connect_error;
        $response['time'] = date("Y-m-d H:i:s");
        echo json_encode($response,true);
        die();
    }
    //echo 'Success...' . $mysqli->host_info;
?>