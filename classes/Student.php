<?php
/**
 * Created by PhpStorm.
 * User: sysadmin
 * Date: 2/3/19
 * Time: 7:00 PM
 */
include_once "MysqlDatabase.php";

class Student extends MysqlDatabase
{
    var $Id;
    var $Name;
    var $Email;
    var $Dob;
    var $status;

    function __construct(){
        parent::__construct();
    }

    public function stdentList($Id=0,$limit=5){
        $table_fields  = implode(",",array_keys(get_class_vars(get_called_class())));
        $sql = "select ".$table_fields . " from " . get_class($this);
        $sql = $Id > 0 ? $sql . " where Id=" . $Id . " limit 1" : $sql . " limit $limit";
        return $this->select($sql);
    }

    public function updateStudent($studentData){
        $sql = "update ". get_class($this) . " SET ";
        foreach ($studentData as $key => $value){
            if(array_key_exists($key,get_class_vars(get_called_class()))){
                $sql.= $key. "='" . $value ."',";
            }
        }
        $sql =rtrim($sql,',');
        $sql .=" where ID=".$studentData['Id'];
        return $this->select($sql,"update");
    }
}


$stdObj = new Student();

$stdObj->setDebug(1);

$studentUpdate = array(
    "Id" => 1,
    "Name" => "Amar CP",
    "Email" => "amarcp@yahoo.com",
    "Dob" => "2019-05-31",
    "status" => 7,
);
$studentsUpdateStatus = $stdObj->updateStudent($studentUpdate,"update");
print_r($studentsUpdateStatus);

$students_list   = $stdObj->stdentList();
print_r($students_list);