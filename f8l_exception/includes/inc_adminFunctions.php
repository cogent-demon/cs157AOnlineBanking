<?php
include 'functions.php';

function getLowBalance($num){
    $result = queryMysql("Call getLowBalance('$num')");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td><td>" . $row['acctype'] . "</td><td>$ " . number_format($row['balance'], 2, '.', ',') . "</td></tr>";
    }
}

function getOfferCC($num){
    //$result = queryMysql("SELECT username, balance from account WHERE balance > 10000");
    $result = queryMysql("Call offerCreditCard('$num')");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td></tr>";
    }
}

function getIncreaseCCLimit($num){
    $result = queryMysql("CALL increaseCCLimit('$num')");
    
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td><td>$ " . number_format($row['maxlimit'], 2, '.', ',') . 
                "</td><td>$ " . number_format($row['totalbalance'], 2, '.', ',') . "</td></tr>";
    }
}

function getNumAccounts(){
    echo <<<_END
    <h2 class='tabletitle'>Number of Open Accounts</h2>
    <table id='numaccounts'>
        <tr>
            <th>Account Type</th>
            <th>Numer of Accounts</th>
        </tr>
_END;
    $sql = "select acctype, count(*) from(
            select username,acctype from account
            union
            select username, acctype from creditcard
            union
            select username,acctype from loan) acl
            group by acctype";
    $result = queryMysql($sql);
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['acctype'] . "</td><td>" . $row['count(*)'] ."</td></tr>";
    }
}

function getLoyalCustomers(){
    echo <<<_END
    <h2 class='tabletitle'>Loyal Customers</h2>
    <table id='loyalcustomers'>
        <tr>
            <th>Username</th>
        </tr>
_END;
    $result = queryMysql("Call loyaltyProgram(@mylist)");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>" . $row['username'] . "</td></tr>";
    }
}

function getUserAccounts(){
    echo <<<_END
    <h2 class='tabletitle'>User Accounts</h2>
    <table id='loyalcustomers'>
        <tr>
            <th>Username</th>
            <th>Account Type</th>
            <th>Number of Credit Cards</th>
            <th>Number of Loans</th>
        </tr>
_END;
    $sql = "SELECT a.username, a.acctype, numofcredit, numofloan
		FROM account a
		LEFT JOIN
                    (SELECT username, count(*) as numofcredit
                    FROM creditcard
                    GROUP BY username) c on a.username=c.username
                    LEFT JOIN
                        (SELECT username, count(*) as numofloan
                        FROM loan
                        GROUP BY username) l on c.username=l.username
            ORDER BY a.username ASC;
            
            ";
    $result = queryMysql($sql);
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>". $row['username'] . "</td>" .
             "<td>" . $row['acctype'] . "</td>" .
             "<td>" . $row['numofcredit'] . "</td>" .
             "<td>" . $row['numofloan'] . "</td></tr>";
    }
}
function getMonthlyDeposit($aDate){
    date_default_timezone_set('America/Los_Angeles');
    $year = date('Y', strtotime($aDate));
    $month = date('F', strtotime($aDate));
    
    echo <<<_END
    <h2 class='tabletitle'>Total Deposit on $month $year</h2>
    <table id='loyalcustomers'>
        <tr>
            <th>Username</th>
        </tr>
_END;
    $result = queryMysql("Call monthlyDeposit('$aDate')");
    $num = $result->num_rows;
    for ($j = 0; $j < $num; $j++){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr><td>$ " . number_format($row['total'], 2, ".", ",") . "</td></tr>";
    }
}

function archiveTransaction(){
    $sql = "CALL archiveTransaction()";
    $result = queryMysql($sql);
    echo "<div class='message'>Transaction Table has been archive</div>";
}
?>