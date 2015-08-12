<?php

$username = 'russians';
$password = 'SOVIET1993';
$database = 'localhost/xe';
$connect = oci_connect($username, $password,$database);

if(!$connect){
    echo "Sorry, We cannot connect to database";
}
?>