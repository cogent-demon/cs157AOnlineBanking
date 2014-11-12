<?php
function validateEmail($data, $fieldName)
{
	global $errorCount;
	global $errorMessage;
	
	if (empty($data))
	{
		$errorMessage .= $fieldName . " is a required field. \n";
		$errorCount++;
		$retval = "";
	}
	else
	{
		// only clean up the input if it isn't empty
		$retval = trim($data);
		$retval = stripslashes($retval);
		$pattern = "/^[\w-]+(\.[\w-]+)*@" . "[\w-]+(\.[\w-]+)*" . "(\.[a-z]{2,})$/i";
		if (preg_match($pattern, $retval) == 0)
		{
			$errorMessage .= $fieldName . " is not a valid e-mail address. \n";
			$errorCount++;
		}
	}
	return($retval);
}
?>