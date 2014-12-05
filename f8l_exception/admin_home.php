<?php
include 'includes/inc_header.php'; 
include 'includes/inc_adminFunctions.php'; 
include 'includes/inc_userFunctions.php';

echo <<<_END
    <!-- F8L Exception Online Bank | Admin Home -->

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <title>F8L Exception Online Bank | Admin Home</title>
            <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
            <link rel = 'stylesheet' href='styles.css' type='text/css'></link>
    </head>
_END;
?>

<body>
<h1>Admin Home</h1>
<hr />
<div class="container">
    <div>
    <div>
        <form name="lowBalanceForm" action="admin_home.php" method="post">
            <fieldset>
                <legend><b>Low Balance</b></legend>
                <p>
                    <label>Enter Amount:</label>
                    <input type="number" name="lowBalance"/>
                    <input type="submit" value="View">
                </p>
            </fieldset>
        </form>
    </div>
    
    <div>
        <form name="increaseLimitForm" action="admin_home.php" method="post">
            <fieldset>
                <legend><b>Increase Credit Card Limit</b></legend>
                <p>
                    <label>Enter Minimum Balance:</label>
                    <input type="number" name="increaseLimit"/>
                    <input type="submit" value="View">
                </p>
            </fieldset>
        </form>
    </div>
    
    <div>
        <form action="admin_home.php" method="post">
            <fieldset>
                <legend><b>Offer Credit Card</b></legend>
                <p>
                    <label>Enter Amount:</label>
                    <input type="number" name="offerCC"/>
                    <input type="submit" value="View">
                </p>
            </fieldset>
        </form>
    </div>
    
    <div>
        <form action="admin_home.php" method="post">
            <fieldset>
                <legend><b>User Transactions</b></legend>
                <p>
                    <label>Enter Username:</label>
                    <input type="text" name="userTrans"/>
                    <input type="submit" value="View">
                </p>
            </fieldset>
        </form>
    </div>
        
    <div>
        <form action="admin_home.php" method="post">
            <fieldset>
                <legend><b>Total Deposit on a Specific Month</b></legend>
                <p>
                    <label>Enter Date (YYYY-MM-DD):</label>
                    <input type="text" name="totalTrans"/>
                    <input type="submit" value="View">
                </p>
            </fieldset>
        </form>
    </div>
    <div>
        <form action="admin_home.php" method="post">
            <fieldset>
                <legend><b>Number of Accounts</b></legend>
                <p>
                    <input type="submit" value="View Number of Accounts" name="numaccounts">
                </p>
            </fieldset>
        </form>
    </div>
    
    <div>
        <form action="admin_home.php" method="post">
            <fieldset>
                <legend><b>User Accounts</b></legend>
                <p>
                    <input type="submit" value="View User Accounts" name="useraccounts">
                </p>
            </fieldset>
        </form>
    </div>
    
    <div>
        <form action="admin_home.php" method="post">
            <fieldset>
                <legend><b>Loyal Customers</b></legend>
                <p>
                    <input type="submit" value="View Loyal Customers" name="loyal">
                </p>
            </fieldset>
        </form>
    </div>
    
    <div>
        <form action="admin_home.php" method="post">
            <fieldset>
                <legend><b>Archive Transaction Table</b></legend>
                <p>
                    <input type="submit" value="Archive Transaction Table" name="archivetransaction">
                </p>
            </fieldset>
        </form>
    </div>
    
        <div id="test">
            
        </div>
    </div>
</div>

<div id="results_table">
<?php
if (isset($_POST['lowBalance'])){
    echo <<<_END
<h2 class='tabletitle'>LOW BALANCE</h2>
<table>
    <tr>
        <th>Username</th>
        <th>Account Type</th>
        <th>Balance</th>
    </tr>
_END;
        //See inc_admin_Functions
        getLowBalance($_POST['lowBalance']);
        
} elseif (isset($_POST['increaseLimit'])){
    echo <<<_END
    <h2 class='tabletitle'>INCREASE CREDIT CARD LIMIT</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Credit Card Max Limit</th>
            <th>Total Account Balance</th>
        </tr>
_END;
        //See inc_admin_Functions
        getIncreaseCCLimit($_POST['increaseLimit']);
        
} elseif (isset($_POST['offerCC'])){
    echo <<<_END
    <h2 class='tabletitle'>OFFER CREDIT CARD</h2>
    <table id='offerCC'>
        <tr>
            <th>Username</th>
        </tr>
_END;
        //See inc_admin_Functions
        getOfferCC($_POST['offerCC']);
        
} elseif (isset($_POST['numaccounts'])){
    getNumAccounts();
} elseif (isset ($_POST['loyal'])){
    getLoyalCustomers();
} elseif (isset ($_POST['useraccounts'])){
    getUserAccounts();
} elseif (isset ($_POST['archivetransaction'])){
    archiveTransaction();
} elseif (isset($_POST['userTrans'])) {
    echo "<h2>Username: " . $_POST['userTrans'] . "</h2>";
    getChecking($_POST['userTrans']);
    getSavings($_POST['userTrans']);
    getCredit($_POST['userTrans']);
    getLoan($_POST['userTrans']);
} elseif (isset ($_POST['totalTrans'])){
    getMonthlyDeposit($_POST['totalTrans']);
}


echo <<<_END
    </table>
_END;
?>
</div>
</body>
</html>