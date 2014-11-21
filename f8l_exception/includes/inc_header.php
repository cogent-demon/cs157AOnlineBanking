<link rel = 'stylesheet' href='styles.css' type='text/css'>
<center><a href="index.php"><img src="artwork/f8l_exception_logo.png" alt="F8L Exception Online Bank"></a></center>
<?php
session_start();

if (isset($_SESSION['login'])){
    $user       = $_SESSION['login'];
    $loggedin   = TRUE;
    $userstr    = " ($user)";
} else {
    $loggedin   = FALSE;
}
//$loggedin = FALSE;
if ($loggedin){
    include 'includes/inc_loggedin_text_menu.php';
} else {
    include 'includes/inc_text_menu.php';
}
?>