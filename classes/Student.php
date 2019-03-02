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
        if($Id>0){
            $sql.=" where Id=". $Id ." limit 1";
        }else
            $sql.=" limit $limit";
        return $this->select($sql);
    }
}


$stdObj = new Student();

//$sql_update ="UPDATE `Student` SET `Name` = 'Amar CP' WHERE `Student`.`Id` = 1";
//$students_update = $stdObj->select($sql_update,"update");
//print_r($students_update);

$sql_select ="SELECT * FROM Student";
$students_list   = $stdObj->stdentList();
print_r($students_list);
