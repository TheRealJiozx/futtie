<?php
session_start();
include_once 'inc/config.php';
if(isset($_POST['submit']))
{
    $id = $_POST['id'];
    $result = mysqli_query($conn,"SELECT * FROM users where ID='" . $_POST['id'] . "'");
    $row = mysqli_fetch_assoc($result);
	$fetch_id=$row['ID'];
	$email=$row['email'];
	$password=$row['password'];
	if($id==$fetch_id) {
				$to = $email;
                $subject = "Password";
                $txt = "Your password is : $password.";
                $headers = "From: oalali5@gmail.com" . "\r\n" .
                "CC: somebodyelse@example.com";
                mail($to,$subject,$txt,$headers);
			}
				else{
					echo 'invalid userid';
				}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
 input{
 border:1px solid olive;
 border-radius:5px;
 }
 h1{
  color:darkgreen;
  font-size:22px;
  text-align:center;
 }

</style>
</head>
<body>
<h1>Forgot Password<h1>
<form action='' method='post'>
<table cellspacing='5' align='center'>
<tr><td>id:</td><td><input type='text' name='id'/></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Submit'/></td></tr>
</table>
</form>
</body>
</html>