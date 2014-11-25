<?php
$dbhost = 'localhost';
$dbname = 'f8lexception';
$dbuser = 'f8lexception';
$dbpassword = 'Kim157';

$connection = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
if ($connection->connect_error) die ($connection->connect_error);

function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query){
    global $connection;
    $result = $connection->query($query);
    if (!$result) {
        echo $query;
        die ($connection->error);
    }
    return $result;
}

function destroySession(){
    $_SESSION = array();
    
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
    
    session_destroy();
}

function sanitizeString($var){
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
}
?>