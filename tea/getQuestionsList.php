<?php
    include '../connectsql.php';
    $selectSql = "SELECT * FROM `questionList`";
    $selectResult = $mysqli->query($selectSql);

    $response = [];
    if (!empty($selectResult)){
        $response['status'] = 1;
        $response['msg'] = '查询成功';
        $i = 0;
        while($row = $selectResult -> fetch_assoc()) {
            $response['questionList'][$i++] = $row;
        }
    } else {
        $response['status'] = -1;
        $response['msg'] = '题库为空';
        $response['questionList'] = '';
    }
    echo json_encode($response,true);
?>