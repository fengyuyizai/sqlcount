<?php
    include '../connectsql.php';
    date_default_timezone_set('Asia/Shanghai');
    header('content-type:html/text;charset=UTF-8');
    $code = $_POST['code'];
    $title = $_POST['title'];
    $simmessage = $_POST['simmessage'];
    $detmessage = $_POST['detmessage'];
    $result = $_POST['result'];
    $diffculty = $_POST['diffculty'];
    $type = $_POST['type'];
    if ($type == 'add') {
        $selectSql = "INSERt INTO `questionlist` (title, simmessage, detmessage, result, diffculty) VALUES ('$title', '$simmessage', '$detmessage', '$result', '$diffculty')";
        echo $selectSql;
    } else if ($type == 'update') {
        $selectSql = "UPDATE `questionlist` SET title='$title', simmessage='$simmessage', detmessage='$detmessage', result='$result', diffculty='$diffculty' WHERE code = '$code'";
    } else if ($type == 'delete') {
        $selectSql = "DELETE FROM `questionlist` WHERE code='$code'";
    }
//    print_r($selectSql);
    file_put_contents('questionmanage.txt',date('Y-m-d H:i:s',time())."selectSql=".$selectSql."\r\n",FILE_APPEND );
    $selectResult = $mysqli->query($selectSql);

    $response = [];
    if (!empty($selectResult)){
        $response['status'] = 1;
        $response['msg'] = '执行成功';
        $response['time'] = date("Y-m-d H:i:s", time());

    } else {
        $response['status'] = -1;
        $response['msg'] = '执行失败';
        $response['time'] = date("Y-m-d H:i:s", time());
    }
    //echo json_encode($response,for);
    echo json_encode($response,true);
    file_put_contents('questionmanage.txt',date('Y-m-d H:i:s',time())."response=".json_encode($response,true)."\r\n",FILE_APPEND );
?>