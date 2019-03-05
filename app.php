<?php
include_once "classes/Student.php";

$names = array(
    'Christopher',
    'Ryan',
    'Ethan',
    'John',
    'Zoey',
    'Sarah',
    'Michelle',
    'Samantha',
    'Amar'
);

$surnames = array(
    'Walker',
    'Thompson',
    'Anderson',
    'Johnson',
    'Tremblay',
    'Peltier',
    'Cunningham',
    'Simpson',
    'Mercado',
    'Sellers',
    'CP'
);

$name = $names[mt_rand(0, sizeof($names) - 1)] ." ". $surnames[mt_rand(0, sizeof($surnames) - 1)];

$stdObj = new Student();


$stdObj->setDebug(1);

$studentUpdate = array(
    "Id" => mt_rand(1,9),
    "Name" => $name,
    "Dob" => "1999-09-09",
    "status" => mt_rand(1,9),
);
$studentsUpdateStatus = $stdObj->update($studentUpdate);


$studentInsert = array(
    "Name" =>  $name,
    "Email" => strtolower(preg_replace('/\s+/', '', $name."@gmail.com")),
    "Dob" => date("Y-m-d", mt_rand(strtotime("10 September 1976"), strtotime("22 July 2000"))),
    "status" => 1,
); print_r($studentInsert);
$studentsInst   = $stdObj->insert($studentInsert);


$students_list   = $stdObj->select();
print_r($students_list);