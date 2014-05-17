<?php
session_start();
require "Utility.php";
require "Connect.php";
$username=$_SESSION['username'];
if(isset($username))
{
	$vpassword=SHA1($_POST['vpassword']);
	$npassword=($_POST['npassword1']);
	$npassword1=($_POST['cpassword']);
	if($vpassword && $npassword && $npassword1)
	{
		$ok=TRUE;
		$query1="SELECT * FROM Account a WHERE a.Username='$username' AND a.Password='$vpassword'";
		$ris1=mysql_query($query1,$conn) or die("Modifica password non riuscita".mysql_error($conn));
		if(!mysql_num_rows($ris1))
		{
			$ok=FALSE;
			echo "Password vecchia sbagliata";
		}
		if($ok && ($npassword!=$npassword1))
		{
			$ok=FALSE;
			echo "Le due password non corrispondono";
		}
		if($ok && !lunghezzadata($npassword,8))
		{
			$ok=FALSE;
			echo "La password deve essere lunga 8 caratteri";
		}
		if($ok && ($vpassword==$npassword))
		{
			$ok=FALSE;
			echo "La nuova password deve essere diversa dalla precedente";
		}
		if($ok)
		{
			$cnpassword=SHA1($npassword);//metto in scuro la nuova password
			$update="UPDATE Account SET Password='$cnpassword' WHERE Username='$username'";
			$ris=mysql_query($update,$conn) or die("Cambio password fallita".mysql_error($conn));
			page_start("Password cambiata");
			echo<<<END
			password cambiata con successo
			<p>
			<a href="profile.php">Clicca qui</a>
			per tornare al tuo profilo
			</p>
END;
			page_end();
		}
	}
	else
		echo "Compilare tutti i campi";
}
else
	echo "Accesso negato";
?>