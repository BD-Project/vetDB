<?php
session_start();
require "Utility.php";
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("Cambia password");
	echo<<<END
	<h1>Cambia password</h1>
	<form action="Change.php" method="POST">
	<fieldset>
		<label for="vpassword">Vecchia password:</label>
		<input type="password" name="vpassword" maxlength="8"><br>
		<label for="npassword1">Nuova password:</label>
		<input type="password" name="npassword1" maxlength="8"><br>
		<label for="cpassword">Conferma password:</label>
		<input type="password" name="cpassword" maxlength="8"><br>
		<input type="submit" value="Cambia">
	</fieldset>
	</form>
	<p>
	<a href="profile.php">Torna</a>
	al tuo profilo
	</p>
END;
	page_end();
}
else
	echo "Accesso negato";
?>