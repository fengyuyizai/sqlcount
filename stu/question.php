<?php
    include '../connectsql.php';
    date_default_timezone_set('Asia/Shanghai');
    $code = $_POST['code'];
    $selectSql = "SELECT * FROM `questionlist` where `code` = '".$code."'";
    file_put_contents('question.txt',date('Y-m-d H:i:s',time())."selectSql=".$selectSql."\r\n",FILE_APPEND );
    $selectResult = $mysqli->query($selectSql)->fetch_assoc();

    $response = [];
    if (!empty($selectResult)){
        $response['status'] = 1;
        $response['msg'] = '查找成功';
        $response['question'] = $selectResult;
    } else {
        $response['status'] = -1;
        $response['msg'] = '查找失败';
        $response['question'] = '';
    }
    echo json_encode($response,true);
    file_put_contents('question.txt',date('Y-m-d H:i:s',time())."response=".json_encode($response,true)."\r\n",FILE_APPEND );
?>