<?php
/**
 * Created by PhpStorm.
 * User: sysadmin
 * Date: 2/3/19
 * Time: 5:02 PM
 */

class MysqlDatabase{
    private $conn;

    function __construct(){
        $this->connect();
    }

    /**
     *
     */
    private function connect(){
        $this->conn = new mysqli(
            "localhost",
            "root",
            "IntoV1nam#@100",
            "School",
            "3306"
        );
        if(!$this->conn)
            die($this->conn->connect_error);

    }

    public function select($sql,$type="select"){
        $resultSet = $this->conn->query($sql);
        switch($type){
            case "insert":
            case "update":
            case "delete":
                return $resultSet;
                break;
            default:
                return $resultSet->fetch_all(1);
        }
    }
}