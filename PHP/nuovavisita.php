<?php
session_start();
?>
<html>
<head>
	<title>Nuova visita</title>
</head>
<body>
	<?php
	$username=$_SESSION['username'];
	if(!isset($username))
		echo "Accesso negato";
	else
	{
		echo<<<END
		<form action="Gestnewvisita.php" method="POST">
		<fieldset>
		<legend>Nuova visita</legend>
		<input type="submit" value="Avanti">
		</fieldset>
		</form>
END;
		
		
	}
	?>
</body>
</html>