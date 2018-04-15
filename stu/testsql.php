<?php
    include '../connectsql.php';
    include '../sqllog.php';
    date_default_timezone_set('Asia/Shanghai');
    $sql = $_POST['sql'];
    $sqllog = new SqlLog();
    if (stripos($sql,'select') !==  false ) { //如果是select语句
        $res = $mysqli->query($sql);
        $i=0;
        $response['data'] = [];
        while($row = $res->fetch_assoc()){
            $response['data'][$i++] = $row;
        }
        $response['status'] = 1;
        $response['msg'] = '执行成功';
        $response['time'] = date("Y-m-d H:i:s", time());

    } else {
        if (stripos($sql,'update') !==  false){ //update语句
            $sqllog::setSql($sql);
            $tableName = $sqllog::updateTableNames();
        } else if(stripos($sql,'insert') !==  false){
            $sqllog::setSql($sql);
            $tableName = $sqllog::insertTableNames();
        } else if(stripos($sql,'delete') !==  false){
            $sqllog::setSql($sql);
            $tableName = $sqllog::deleteTableNames();
        } else if(stripos($sql,'create') !== false){

        }

        if(isset($tableName) && !empty($tableName)){
            $sql = "select * from `".$tableName[0]."`";
            $i=0;
            $res = $mysqli->query($sql);
            $response = [];
            while($row = $res->fetch_assoc()){
                $response[$i++]['data'] = $row;
            }
            $response['status'] = 1;
            $response['msg'] = '执行成功';
            $response['time'] = date("Y-m-d H:i:s", time());
        } else {
            $response['status'] = -1;
            $response['msg'] = '执行失败';
            $response['time'] = date("Y-m-d H:i:s", time());
        }
    }
        echo json_encode($response,true);
