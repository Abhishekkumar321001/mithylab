<?php

require_once "header.php";

echo <<<_END

				<script>

					function checkUser(obj)
					{

						if(obj.value == "") return

						var data = "user=" + obj.value + "&nocache=" + Math.random()*1000000
						var request = new ajaxRequest()
						request.open("GET", "checkuser.php?" + data, true)

						request.onreadystatechange = function()
						{

							if(this.readyState == 4 && this.status == 200)
									document.getElementById("info").innerHTML = this.responseText

						}

						request.send(null)

					}

					function checkPhone(obj)
					{

						if(obj.value == "") return

						var data = "phone=" + obj.value + "&nocache=" + Math.random()*1000000
						var request = new ajaxRequest()
						request.open("GET", "checkphone.php?" + data, true)

						request.onreadystatechange = function()
						{

							if(this.readyState == 4 && this.status == 200)
									document.getElementById("info1").innerHTML = this.responseText

						}

						request.send(null)

					}

					function ajaxRequest() {


						var request
						try { request = new XMLHttpRequest() }
						catch(e1)
						{

							try { request = new ActiveXObject("Microsoft.XMLHTTP") }
							catch(e2)
							{


								try {  request = new ActiveXObject("Msxml2.XMLHTTP") }
								catch(e3)
								{

									request = false

								}

							}

						}

						return request

					}

				</script>

_END;

$error = $user = $pass = $phone = "";
$err1  = $err2 = $err3 = "<span style='color:red'>*</span>";
if(isset($_POST['user']))
{

	$user  = sanitizeString($_POST['user']);
	$phone = sanitizeString($_POST['phone']);
	$pass  = sanitizeString($_POST['pass']);

	if($user == "" || $phone == "" || $pass == "") {
		
		if($user  == "") $err1 = "<span style='color:red;font-style:italic'>* required</span>";
		if($phone == "") $err2 = "<span style='color:red;font-style:italic'>* required</span>";
		if($pass  == "") $err3 = "<span style='color:red;font-style:italic'>* required</span>";

	}
	elseif(!preg_match('/[0-9]/', $phone)) {$err2 = "<span style='color:red;font-style:italic'>* only integer value is allowed</span>";}
	else
	{

		$result = mysqlQuery("SELECT * FROM members WHERE user='$user'");
		if($result->num_rows)
		{
			$error = "This account does already exist";
		}
		else
		{
			mysqlQuery("INSERT INTO members VALUES('$user', '$pass', '$phone')");
			echo "<br><h4>Please Log in to continue</h4>";
		}

	}

}

echo "<div class='main'><h3>Fill following fields:</h3>";

echo <<<_END

				$error<form method="post" action="signin.php">
				<span class="fieldname">Name</span>
				<input type="text" name="user" value="$user" maxlength="16" onblur="checkUser(this)">$err1<span id="info"></span><br>
				<span class="fieldname">Phone No.</span>
				<input type="text" name="phone" value="$phone" maxlength="10" onblur="checkPhone(this)">$err2<span id="info1"></span><br>
				<span class="fieldname">Password</span>
				<input type="text" name="pass" value="$pass" maxlength="16">$err3<br>
				<span class="fieldname">&nbsp;</span> <input type="submit" value="Sign In"><br>
				</form>

_END; 

?>
</div>
</body>
</html>