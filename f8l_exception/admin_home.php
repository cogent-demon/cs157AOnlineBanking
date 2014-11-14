<?php
include 'includes/inc_header.php'; 
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
        echo "low balance!";
    } elseif ($_POST['view'] == 'increaseLimit'){
        echo "increase limit!";
    } elseif ($_POST['view'] == 'offerCredit'){
        echo "offer a credit card!";
    }
} 

function viewLowBalance(){
    
}
?>
