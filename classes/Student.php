<?php
/**
 * Created by PhpStorm.
 * User: sysadmin
 * Date: 2/3/19
 * Time: 7:00 PM
 */
include_once "MysqlDatabase.php";

class Student extends MysqlDatabase {
    var $Id;
    var $Name;
    var $Email;
    var $Dob;
    var $status;

    function __construct(){
        parent::__construct();
    }

    /**
     * @return array
     */
    public function stdentList() : array {
        return $this->select();
    }

    /**
     * @param array $studentData
     * @return integer
     */
    public function updateStudent($studentData) : int {
        return $this->update($studentData);
    }
}

$stdObj = new Student();


$stdObj->setDebug(1);

$studentUpdate = array(
    "Id" => 1,
    "Name" => "Amar CP",
    "Email" => "amarcp@gmail.com",
    "Dob" => "1986-05-31",
    "status" => 1,
);
$studentsUpdateStatus = $stdObj->updateStudent($studentUpdate);
print_r($studentsUpdateStatus);


$students_list   = $stdObj->stdentList();
print_r($students_list);

