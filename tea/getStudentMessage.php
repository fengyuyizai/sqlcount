<?php
    include '../connectsql.php';
    date_default_timezone_set('Asia/Shanghai');
    $selectSql = "SELECT * FROM `stumessage`";
    file_put_contents('getstuExport.txt',date('Y-m-d H:i:s',time())."selectSql=".$selectSql."\r\n",FILE_APPEND );
    $selectResult = $mysqli->query($selectSql);

    $response = [];
    if (!empty($selectResult)){
        $response['status'] = 1;
        $response['msg'] = '查询成功';
        $i = 0;
        while ($row = $selectResult -> fetch_assoc()) {
            $response['studentList'][$i++] = $row;
        }
        $response['time'] = date("Y-m-d H:i:s", time());
    } else {
        $response['status'] = -1;
        $response['msg'] = '查询失败';
        $response['time'] = date("Y-m-d H:i:s", time());
    }
    //echo json_encode($response,for);
    echo json_encode($response,true);
    file_put_contents('getstuExport.txt',date('Y-m-d H:i:s',time())."response=".json_encode($response,true)."\r\n",FILE_APPEND );
?>