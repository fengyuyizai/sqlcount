<?php
    include '../connectsql.php';
    include '../sqllog.php';
    date_default_timezone_set('Asia/Shanghai');
    $sql = $_POST['sql'];
    $sqllog = new SqlLog();
    if (stripos($sql,'select') !==  false ) { //如果是select语句
        $sqllog::setSql($sql);
        $tableName = $sqllog::selectTableNames();
        //$response['data'] = getFields($tableName[0],0);
        //$data = getFields($tableName[0],0);
        $response['status'] = 1;
        $response['msg'] = '执行成功';
        $response['time'] = date("Y-m-d H:i:s", time());
        $response['data'] = [];
        if(isset($tableName) && !empty($tableName)){ //返回表名信息   
            $res = $mysqli->query($sql);
            $content = [];
            $field = [];
            if (!empty($res)) {       //select语句执行成功
                $j=0;     
                while($row = $res->fetch_assoc()){
                    $content[$j++] = $row;
                }

                $getFieldSql = "show fields from $tableName[0]";
                $fieldResult = $mysqli->query($getFieldSql);
                $i = 0;
                
                if (!empty($fieldResult)) {  //字段名查询成功
                    while($row = $fieldResult->fetch_assoc()){
                        $field[$i++] = $row['Field'];                
                    }

                } else {  //字段名查询失败
                    $response['status'] = -1;
                    $response['msg'] = $mysqli->errno.':'.$mysqli->error;
                } 
                

            } else {                   //select语句执行失败
                $response['status'] = -1;
                $response['msg'] = $mysqli->errno.':'.$mysqli->error;
            }
            $response['data']['content'] = $content;
            $response['data']['field'] = $field;
            
        } else {                                     //表名查询失败
            $response['status'] = -1;
            $response['msg'] = '表名查询失败';
        }
        // if (isset($data['field']['error']) && !empty($data['field']['error'])) {
        //     $response['msg'] = $data['field']['error'];
        //     $response['status'] = -1;
        //     unset($data['field']['error']);
        //     $response['data'] = $data;
        // }
        // if(isset($data['content']['error']) && !empty($data['content']['error'])){
        //     if (strpos($response['msg'],'成功')) {  //field查询成功
        //         $response['msg'] = $data['content']['error'];
        //         unset($data['content']['error']);
        //         $response['data']['content'] = $data;

        //     } else {                               
        //         if (isset($data['field']) && !empty($data['field'])) {  //field查询失败
        //            $response['msg'] .= ';'.$data['content']['error'];
        //            unset($data['content']['error']);
        //            $response['data']['content'] = $data['content'];
        //         }
                

        //     }
        //     $response['status'] = -1;
        // }
    } else {
       
        //if (!empty($res)) {
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
                $sqllog::setSql($sql);
                $tableName = $sqllog::createTableNames();
                if (isset($tableName) && !empty($tableName)) {
                    $response['status'] = 1;
                    $response['msg'] = '执行成功';
                    $response['time'] = date("Y-m-d H:i:s", time());
                    $response['data'] = [];
                    $field = [];
                    $content = [];
                    $result = $mysqli->query($sql);

                    if (!empty($result)) {  //表创建成功
                        $getFieldSql = "show fields from $tableName[0]";
                        $fieldResult = $mysqli->query($getFieldSql);
                        $i = 0;
                        
                        if (!empty($fieldResult)) {  //字段名查询成功
                            while($row = $fieldResult->fetch_assoc()){
                                $field[$i++] = $row['Field'];                
                            }

                        } else {  //字段名查询失败
                            $response['status'] = -1;
                            $response['msg'] = $mysqli->errno.':'.$mysqli->error;
                        } 



                    } else {  //表创建失败
                        $response['status'] = -1;
                        $response['msg'] = $mysqli->errno.':'.$mysqli->error;
                    }
                    $response['data']['content'] = $content;
                    $response['data']['field'] = $field;

                    
                    echo json_encode($response,true);
                    exit;
                } else {
                    $response['status'] = -1;
                    $response['msg'] = '表名查询失败';
                    $response['time'] = date("Y-m-d H:i:s", time());
                    $response['data'] = [];
                    echo json_encode($response,true);
                    exit;
                }     
            }
            $result = $mysqli->query($sql);
            $res = $mysqli->affected_rows;
            if (!empty($res)  && $res != 0) {
                $response['status'] = 1;
                $response['msg'] = '执行成功';
                $response['time'] = date("Y-m-d H:i:s", time());
                $response['data'] = [];


                if(isset($tableName) && !empty($tableName)){ //返回表名信息  
                    $sql = "select * from $tableName[0]";
                    $res = $mysqli->query($sql);
                    $content = [];
                    $field = [];
                    if (!empty($res)) {       //查询全部语句执行成功
                        $j=0;     
                        while($row = $res->fetch_assoc()){
                            $content[$j++] = $row;
                        }

                        $getFieldSql = "show fields from $tableName[0]";
                        $fieldResult = $mysqli->query($getFieldSql);
                        $i = 0;
                        
                        if (!empty($fieldResult)) {  //字段名查询成功
                            while($row = $fieldResult->fetch_assoc()){
                                $field[$i++] = $row['Field'];                
                            }
                        } else {  //字段名查询失败
                            $response['status'] = -1;
                            $response['msg'] = $mysqli->errno.':'.$mysqli->error;
                        }
                    } else {                   //查询全部语句执行失败
                        $response['status'] = -1;
                        $response['msg'] = $mysqli->errno.':'.$mysqli->error;
                    }
                    $response['data']['content'] = $content;
                    $response['data']['field'] = $field;
                    
                } else {                                     //表名查询失败
                    $response['status'] = -1;
                    $response['msg'] = '表名查询失败';
                }
            }  else {
                $response['status'] = -1;
                $response['msg'] = $mysqli->errno.':'.$mysqli->error;
                $response['time'] = date("Y-m-d H:i:s", time());
                $response['data'] = [];
            }
    }
        echo json_encode($response,true);

        // function getFields($tableName,$type=1){
        //     include '../connectsql.php';
        //     $getFieldSql = "show fields from $tableName";
        //     $fieldResult = $mysqli->query($getFieldSql);
        //     $i = 0;
        //     $field = [];
        //     if (!empty($fieldResult)) {
        //         while($row = $fieldResult->fetch_assoc()){
        //             $field[$i++] = $row['Field'];                
        //         }
        //     }
        //     if (empty($field)) {
        //         $field['error'] = $mysqli->errno.':'.$mysqli->error;
        //     }
            
            
        //     if($type == 1){
        //         $getContentSql = "select * from `".$tableName."`";
        //         $contentResult = $mysqli->query($getContentSql);
        //         $j = 0;
        //         $content = [];
        //         while($row = $contentResult->fetch_assoc()){
               
        //             $content[$j++] = $row;
                    
        //         }
        //         if (empty($content)) {
        //             $content['error'] = $mysqli->errno.':'.$mysqli->error;
        //         }

        //     } else if($type == 0){
        //         Global $sql;
        //         $res = $mysqli->query($sql);
        //         $j=0;
        //         $content = [];
        //         while($row = $res->fetch_assoc()){
        //             $content[$j++] = $row;
        //         }

        //     } else {
        //         $content = [];
        //     }
            
        //     $tmp = array('field'=>$field,'content'=>$content);
        //     return $tmp;
        // }





