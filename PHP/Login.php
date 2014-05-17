<?php
session_start();
require "Utility.php";
page_start("Login");
$username=$_SESSION['username'];
if(!isset($username))
{
echo<<<END
<form action="Logincheck.php" method="POST">
 <fieldset>
  <legend>Login</legend>
	<label for="username">Username:</label>
	<input type="text" name="username"/></br>
	<label for="password">Password:</label>
    <input type="password" name="password"/></br>
    <input type="submit" name="login"value="Login" /><br>
 </fieldset>
</form>
END;
}
else
	echo "Accesso negato";
page_end();
?>