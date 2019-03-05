<?php
/**
 * Created by PhpStorm.
 * User: sysadmin
 * Date: 2/3/19
 * Time: 5:02 PM
 */

class MysqlDatabase{
    private $conn;
    private $debug;

    function __construct(){
        $this->connect();
    }

    /**
     *
     */
    private function connect() : void {
        $this->conn = new mysqli(
            "localhost",
            "root",
            "vinam@123",
            "student",
            "3306"
        );
        if(!$this->conn)
            die($this->conn->connect_error);

    }

    /**
     * @param integer $debug
     */
    public function setDebug($debug): void {
        $this->debug = $debug;
    }

    /**
     * @param string $sql
     * @param string $type
     * @return integer/array
     */
    public function select($sql, $type="select") {
        if($this->debug==1)
          //  echo "\n Query : ". $sql ."\n";
        $resultSet = $this->conn->query($sql);
        switch($type){
            case "insert":
           // $resultSet = $this->conn->query($sql);
            case "update":
            case "delete":
                return $resultSet;
                break;
            default:
                return $resultSet->fetch_all(1);
        }
    }
}