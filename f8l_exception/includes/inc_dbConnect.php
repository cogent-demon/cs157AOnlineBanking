<?php
include 'functions.php';
$db_host="localhost"; // Host name
$db_username="f8lexception"; // Mysql username
$db_password="Kim157"; // Mysql password
$db_name="f8lexception"; // Database name

// Connect to server and select database.
$connection = new mysqli($db_host, $db_username, $db_password, $db_name);
if ($connection->connect_error) die ($connection->connect_error);
//$db_connect = mysql_connect("$db_host", "$db_username", "$db_password")or die("cannot connect");
//mysql_select_db("$db_name")or die("cannot select DB");
?>