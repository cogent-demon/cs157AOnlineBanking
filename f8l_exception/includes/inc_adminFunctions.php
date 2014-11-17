<?php
include 'functions.php';

function lowBalance(){
    $result = queryMysql("SELECT username, acctype, balance from account WHERE balance <= 200");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td><td>" . $row['acctype'] . "</td><td>$" . $row['balance'] . "</td></tr>";
    }
}
?>