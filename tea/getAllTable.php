<?php
    date_default_timezone_set('Asia/Shanghai');
    include '../Connect.php';
    include '../Config.php';
    $connect = new Connect();
    $db = 'teatest';
    $connResult = $connect->connect(HOST,USER,PASSWORD,$db);
    if ($connResult) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $table = $_POST['tableName'];
            $sql = 'select * from `'.$table.'`';
            $getFieldSql = "show fields from `$table`";

            $selectTable = $connResult->query($sql);
            $fieldResult = $connResult->query($getFieldSql);

            $field = array();
            $content = array();
            $response['status'] = 1;
            $response['msg'] = '查询成功';

            $i = 0;
            if (!empty($fieldResult)) {  //字段名查询成功
                while($row = $fieldResult->fetch_assoc()){
                    $field[$i++] = $row['Field'];                
                }
            } else {
                $response['status'] = 0;
                $response['msg'] = '查询失败';
            }

            $j = 0;
            if(!empty($selectTable)) {   // 查询表内容
                while($trItem = $selectTable->fetch_assoc()) {
                    $content[$j++] = $trItem;
                }
            } else {
                $response['status'] = 0;
                $response['msg'] = '查询失败';
            }

            $response['data']['field'] = $field;
            $response['data']['content'] = $content;
        }
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            
            $sql = 'SHOW TABLES';
            $res = $connResult->query($sql);
            if(!empty($res)) {
                $response['status'] = '1';
                $response['msg'] = '查询成功';
                while($row = $res -> fetch_row()) {
                    $response['tableList'][] = $row[0];
                }
//                print_r($response['tableList']);
            } else {
                $response['status'] = '0';
                $response['msg'] = '查询失败';
            }
        }
        echo json_encode($response, true);
    }
    
?>
