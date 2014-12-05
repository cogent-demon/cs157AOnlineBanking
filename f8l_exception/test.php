<html>
    <head>
        <style>
            #container div{
                float: left;
            }
        </style>
    </head>
    <body>
        <div id="container">
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
        </div>
    </body>
</html>

<!--
<form action="test.php" method="post">
    <select name="formGender" />
      <option value="">Select...</option>
      <option value="M">Male</option>
      <option value="F">Female</option>
    </select>
    <input type="submit" value="Submit" />
</form>
-->
<?php
    if(isset($_POST['formGender'])){
        if ($_POST['formGender'] == "")
            echo "Select gender";
        else
            echo "Gender is " . $_POST['formGender'];
    }
?>