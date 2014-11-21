<?php
include 'includes/inc_header.php'; 
include 'includes/inc_adminFunctions.php'; 

echo <<<_END
    <!-- F8L Exception Online Bank | Admin Home -->

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
            <title>F8L Exception Online Bank | Admin Home</title>
            <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
            <link rel = 'stylesheet' href='styles.css' type='text/css'></link>
    </head>
    <body>
    <h1>Admin Home</h1>
    <hr />
_END;

echo <<<_END
    <form action="admin_home.php" method="post">
    <select name="view">
        <option value=""></option>
        <option value="lowBalance">Low Balance Account</option>
        <option value="increaseLimit">Increase Credit Limit</option>
        <option value="offerCredit">Offer Credit</option>
    </select>
    <input type="submit" value="View">
</form>
_END;

if (isset($_POST['view'])){

    if ($_POST['view'] == 'lowBalance'){
        echo <<<_END
    <h2 class='tabletitle'>LOW BALANCE</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Account Type</th>
            <th>Balance</th>
        </tr>
_END;
        viewLowBalance();
    } elseif ($_POST['view'] == 'increaseLimit'){
        echo <<<_END
    <h2 class='tabletitle'>INCREASE CREDIT CARD LIMIT</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Max Limit</th>
            <th>Balance</th>
            <th>Account Type</th>
        </tr>
_END;
        increaseLimit();
    } elseif ($_POST['view'] == 'offerCredit'){
        echo <<<_END
    <h2 class='tabletitle'>OFFER CREDIT CARD</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Balance</th>
        </tr>
_END;
        offerCredit();
    }
echo <<<_END
    </table>
_END;
} 

function viewLowBalance(){
    lowBalance();
}

function increaseLimit(){
    increaseCCLimit();
}

function offerCredit(){
    offerCC();
}
?>
