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
    private  function connect() : void {
        $this->conn = new mysqli(
            "localhost",
            "root",
            "root",
            "School",
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
     * @param Int $Id
     * @param Int $limit
     * @return array
     */
    public function select($Id=0,$limit=5) : array {
        $nonUsed = array(0=>"conn",1=>"debug");
        $classVariables = array_keys(get_class_vars(get_called_class()));
        $usableVaraibles = array_diff($classVariables,$nonUsed);
        $table_fields  = implode(",",$usableVaraibles);
        $sql = "select " . $table_fields . " from ".get_called_class();
        $sql = $Id > 0 ? $sql . " where Id=" . $Id ." limit 1": $sql ."";
        $sql .= " order by id desc limit $limit ";
        if($this->debug==1)
            echo "\n Query : ". $sql ."\n";
        $resultSet = $this->conn->query($sql);
        return $resultSet->fetch_all(1);
    }

    /**
     * @param array $data
     * @return int
     */
    public function update($data) : int {
        $sql = "update ". get_called_class() . " SET ";
        foreach ($data as $key => $value){
            if(array_key_exists($key,get_class_vars(get_called_class()))){
                $sql.= $key. "='" . $value ."',";
            }
        }
        $sql =rtrim($sql,',');
        $sql .=" where Id=".$data['Id'];
        if($this->debug==1)
            echo "\n Query : ". $sql ."\n";
        return $this->conn->query($sql);
    }

    /**
     * @param int $data
     * @return int
     */
    public function delete($Id) : int {
        $sql = "delete from ". get_called_class();
        $sql .=" where Id=".$Id;
        if($this->debug==1)
            echo "\n Query : ". $sql ."\n";
        return $this->conn->query($sql);
    }    

    /**
     * @param array $data
     * @return int
     */
    public function insert($data) : int {
        $sql = "Insert into ". get_called_class() . " SET ";
        foreach ($data as $key => $value){
            if(array_key_exists($key,get_class_vars(get_called_class()))){
                $sql.= $key. "='" . $value ."',";
            }
        }
        $sql =rtrim($sql,',');
        if($this->debug==1)
            echo "\n Query : ". $sql ."\n";
        return $this->conn->query($sql);
    }
}