<?php
/**
 * Created by PhpStorm.
 * User: sysadmin
 * Date: 2/3/19
 * Time: 7:00 PM
 */

include_once "MysqlDatabase.php";

class Student extends MysqlDatabase {
   
    var $id;
    var $name;
    var $age;
    var $gender;
    var $city;
    var $address;
    var $education;
    var $grade;

    function __construct(){
        parent::__construct();
    }

    /**
     * @param int $Id
     * @param int $limit
     * @return array
     */
    public function stdentList($id=0, $limit=5) : array {
        $table_fields  = implode(",",array_keys(get_class_vars(get_called_class())));
        $sql = "select ".$table_fields . " from " . get_class($this);
        $sql = $id > 0 ? $sql . " where id=" . $id . " limit 1" : $sql . " limit $limit";
        return $this->select($sql);
    }

    /**
     * @param array $studentData
     * @return integer
     */
    public function updateStudent($studentData) : int {
        $sql = "update ". get_class($this) . " SET ";
        foreach ($studentData as $key => $value){
            if(array_key_exists($key,get_class_vars(get_called_class()))){
                $sql.= $key. "='" . $value ."',";
            }
        }
        $sql =rtrim($sql,',');
        $sql .=" where id=".$studentData['id'];
        return $this->select($sql,"update");
    }
    
    /**
     * @param array $studentData
     * @return integer
     */
    public function insertStudent($studentData) : int {
        $sql = "insert into ". get_class($this) . " SET ";
        foreach ($studentData as $key => $value){
            if(array_key_exists($key,get_class_vars(get_called_class()))){
                $sql.= $key. "='" . $value ."',";
            }
        }
        $sql =rtrim($sql,',');
        return $this->select($sql,"insert");
    }
}
?>
