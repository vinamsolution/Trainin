<?php
/**
 * Created by PhpStorm.
 * User: sysadmin
 * Date: 10/3/19
 * Time: 12:27 PM
 */

include_once "classes/VerifyEmail.php";

//$ve = new hbattat\VerifyEmail("teja4550@yahoo.co.in","anil@blackpost.net");

$ve = new hbattat\VerifyEmail("neeraj_komal@yahoo.com","anil@blackpost.net");


print_r($ve->verify());

print_r($ve->get_errors());

print_r($ve->get_debug());