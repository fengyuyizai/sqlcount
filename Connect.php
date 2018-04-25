<?php
//数据库连接类
class Connect{
    //public $sql;
    private $conn;
    public function __construct(){
        
    }
    public function connect($host,$user,$password,$db){
        $this->conn = new mysqli($host,$user,$password,$db);
        if ($this->conn->errno) {
            $msg = 'Connect Error '.$this->conn->errno.':'.$this->conn->error;
            return $msg;
            die();
        } else {
            return $this->conn;
        }
    }

}


 