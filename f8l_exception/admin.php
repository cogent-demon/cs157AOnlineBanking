<?php
include 'functions.php';
include 'includes/inc_header.php'; 
include 'includes/inc_validateInput.php';
include 'includes/inc_validateLogin.php';

echo <<<_END
    <!-- F8L Exception Online Bank | Admin Login -->

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>F8L Exception Online Bank | Admin Login</title>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <link rel = 'stylesheet' href='styles.css' type='text/css'></link>
    </head>
    <body>
    <hr />
    <h1>Admin Login</h1>
    
_END;

global $errorMessage;
$errorCount = 0;
$errorMessage = $userName = $password = "";
$result=$num="";
if (isset($_POST['Submit'])){
    $userName  = validateInput($_POST['user'],"User Name");
    $password  = validateInput($_POST['pass'],"Password");
    //Check if there is an error on userName and/or password.
    if ($errorMessage == ""){
        $result = queryMysql("SELECT username,password FROM Users WHERE username='$userName' AND password='$password'");
        $num = $result->num_rows;
        
        if ($result->num_rows == 0)
                $errorMessage = "Username/Password invalid";
        else{
            header("Location: http://mywebsite.localdomain/cs157a/cs157AOnlineBanking/f8l_exception/admin_home.php");
            exit();
        }
    }
}
echo <<<_END
   <form method="POST" action="admin.php">$errorMessage
	<p>User Name <input type="text" name="user" /></p>
	<p>Password <input type="password" name="pass" /></p>
	<p><input type="submit" name="Submit" value="Log in" /></p>
    </form>
_END;
?>