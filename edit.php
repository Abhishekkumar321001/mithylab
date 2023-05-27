<?php

/* -------Update profile------- */

require_once "header.php";

if(!$loggedin) die();

if($_FILES['image']['name'] != null) 										// if image has been uploaded
{

	$saveto = "profile_pics/$user.jpg"; 									// saving location for image
	move_uploaded_file($_FILES['image']['tmp_name'], $saveto);				// move image to $saveto location

	$flag = false;
	switch($_FILES['image']['type']) 										// check image type
	{														 						
		case "image/jpeg": $src = imagecreatefromjpeg($saveto); $flag = true; break; // if image type is jpeg
		case "image/png" : $src = imagecreatefrompng($saveto);  $flag = true; break; // if image type is png

	}

	if(!$flag) echo "<br>Please upload legal image file (jpeg or png)<br>";
	else {

		list($w, $h) = getimagesize($saveto); // returns width and height of the image

		$tw = ""; $th = "";
		if($w > $h) {

			$tw = 140;
			$th = ($h/$w)*$tw;

		}	
		else {

			$th = 140;
			$tw = ($w/$h)*$th;

		}

		$tmp = imagecreatetruecolor($tw, $th); 									// create an black image object of width $tw and height $th
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h); 			// please take reference
		imageconvolution($tmp, array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1)), 8, 0); // please take reference
		imagejpeg($tmp, $saveto); 												// save $tmp in location $saveto as jpeg image
		imagedestroy($src);														// destroy image $src
		imagedestroy($tmp);														// destroy image $tmp

	}

}

if(isset($_POST['text']))														// if some text is submitted
{

	$text = sanitizeString($_POST['text']);
	if($text != "")																
	{

		$result = mysqlQuery("SELECT * FROM profiles WHERE user='$user'");

		if($result->num_rows)												   // if user's record already exists 
			mysqlQuery("UPDATE profiles SET about='$text' WHERE user='$user'");
		else 																   // if user's record doesn't exist
			mysqlQuery("INSERT INTO profiles VALUES('$user', '$text')");
	
	}

}

echo '<div class="main">Upload your image and write your <span style="font-style:italic;font-weight:bold">"about"</span>:<br><br>';
showProfile($user);

echo <<<_END

				<form method="post" action="edit.php" enctype="multipart/form-data">
				<textarea style="border-radius:15px" name="text" cols="47" rows="5"></textarea><br>
				<input type="file" name="image" title="Only JPEG/PNG images are allowed">&nbsp;
				<input type="submit" value="Update Your Profile">
				</form>

_END;

?>
</div>
</body></html>