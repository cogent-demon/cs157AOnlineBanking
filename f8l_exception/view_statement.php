<?php
session_start(); ?>
<!-- F8L Exception Online Bank | View Statement -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>F8L Exception Online Bank | View Statement</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<?php include 'includes/inc_header.php'; ?>
	<h1>View Statement -- Under construction</h1><hr />
</head>
<body>

<?php
function displayTable() {
	global $Login;
	echo "User Name: " . $Login;
	include 'includes/inc_dbConnect.php';

	if ($db_connect === FALSE)
		echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysql_errno() . ": " . mysql_error() . "</p>";
		
	else {
		if (!@mysql_select_db($db_name, $db_connect))
			echo "<p>No data found.</p>";
		else {
			
			$TableName = "document";
			$SQLstring = "SELECT * FROM $TableName WHERE login = '$Login' and active = 1";
			
			$QueryResult = @mysql_query($SQLstring, $db_connect);
			if (mysql_num_rows($QueryResult) == 0)
				echo "<p>No data found .</p>";
			else 
			{
				echo "<table width='100%' border='1'>";
				echo "<tr>
					<th>Title</th>
					<th>Tags</th>
					<th>Revised Date</th>
					<th>Note1</th>
					<th>Edit</th>
					<th>Remove</th>
					</tr>";
				while (($Row = mysql_fetch_assoc($QueryResult)) !== FALSE) 
				{
					echo "<td><a href='view_document.php?id={$Row['id']}'>{$Row['title']}</a></td>";
					echo "<td>{$Row['tags']}</td>";
					echo "<td>{$Row['revisedDate']}</td>";
					echo "<td>{$Row['note1']}</td>";
					?>
					<td>
					<form method="POST" action="edit_document.php">
						<input type="hidden" name="id" value="<?php echo $Row['id']; ?>">
						<input type="hidden" name="status" value=0>
        				<input type="submit" name="edit" value="Edit" />
					</form>
					</td>
					<td>
					<form method="POST" action="change_document_status.php">
						<input type="hidden" name="id" value="<?php echo $Row['id']; ?>">
						<input type="hidden" name="status" value=0>
        				<input type="submit" name="remove" value="Remove" />
					</form>
					</td></tr><?php
				}
				echo "</table><br /><br />";
			}
			mysql_free_result($QueryResult);
		}	
	}
	include 'includes/inc_text_menu.php';
}
$Login = "";
$Login = $_SESSION['login'];
if ($Login == "") { // redirect to login page if not logged in
	?><script language="JavaScript">window.location = "login.php";</script><?php
}
displayTable();
?>

</body>
</html>