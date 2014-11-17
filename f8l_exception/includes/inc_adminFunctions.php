<?php
include 'functions.php';

function lowBalance(){
    //$result = queryMysql("SELECT username, acctype, balance from account WHERE balance <= 200");
    $result = queryMysql("Call getLowBalance");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td><td>" . $row['acctype'] . "</td><td>$ " . number_format($row['balance'], 2, '.', ',') . "</td></tr>";
    }
}

function offerCC(){
    $result = queryMysql("SELECT username, balance from account WHERE balance > 10000");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td><td>$ " . number_format($row['balance'], 2, '.', ',') . "</td></tr>";
    }
}

function increaseCCLimit(){
    $result = queryMysql("SELECT account.username, account.balance, creditcard.maxlimit from account,creditcard WHERE (account.acctype = 'checking' and "
            . "account.balance > 2 * creditcard.maxlimit and account.username = creditcard.username)");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td><td>$ " . number_format($row['maxlimit'], 2, '.', ',') . 
                "</td><td>$ " . number_format($row['balance']) . "</td></tr>";
    }
}
?>