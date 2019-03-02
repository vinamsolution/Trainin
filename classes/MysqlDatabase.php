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

$obj = new MysqlDatabase();

$sql_update ="UPDATE `Student` SET `Name` = 'Amar CP' WHERE `Student`.`Id` = 1";

$sql_select ="SELECT * FROM Student";
$students_list   = $obj->select($sql_select);
$students_update = $obj->select($sql_update,"update");
print_r($students_list);
print_r($students_update);