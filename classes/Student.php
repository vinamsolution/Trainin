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
}