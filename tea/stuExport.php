<?php
    include '../connectsql.php';
    date_default_timezone_set('Asia/Shanghai');
    $username = $_POST['username'];
    $selectSql = "SELECT * FROM `stuExport` where `username` = '".$username."'";
    file_put_contents('stuExport.txt',date('Y-m-d H:i:s',time())."selectSql=".$selectSql."\r\n",FILE_APPEND );
    $selectResult = $mysqli->query($selectSql)->fetch_assoc();

    $response = [];
    if (!empty($selectResult)){
        $response['status'] = 1;
        $response['msg'] = '查询成功';
        $response['data'] = $selectResult;
        $response['time'] = date("Y-m-d H:i:s", time());

    } else {
        $response['status'] = -1;
        $response['msg'] = '查询失败';
        $response['time'] = date("Y-m-d H:i:s", time());
    }
    //echo json_encode($response,for);
    echo json_encode($response,true);
    file_put_contents('stuExport.txt',date('Y-m-d H:i:s',time())."response=".json_encode($response,true)."\r\n",FILE_APPEND );
?>