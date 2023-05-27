<?php

if(isset($_GET['phone']))
{

	$phone = sanitizeString($_GET['phone']);

	if(preg_match('/[0-9]/', $phone))
	{

		if(strlen($phone) == 10)
			echo "<span class='available'> &check;accepted</span>";
		else echo "<span class='taken'> &#x2715;number should be of 10 digits</span>";

	}
	else echo "<span class='taken'> &#x2715;number should contain only digits</span>";

}

?>