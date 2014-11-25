<?php
include 'functions.php';
$accountId = 106;

$type = "SELECT acctype FROM account where '$accountId'=accID";
$result2 = queryMysql($type);
$row = $result2->fetch_array(MYSQLI_ASSOC);
echo $row['acctype'];
?>