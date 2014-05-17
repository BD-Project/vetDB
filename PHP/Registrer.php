<?php
require "Connect.php";
require "Utility.php";
$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$sesso=$_POST['sesso'];
$citta=$_POST['citta'];
$giorno=$_POST['giorno'];
$mese=$_POST['mese'];
$anno=$_POST['anno'];
$email=$_POST['email'];
$tel=$_POST['tel'];
$username=$_POST['username'];
$password=$_POST['password'];
$password1=$_POST['cpassword'];
$data=$anno."-".$mese."-".$giorno;//creo la data concatenando giorno, mese e anno
if($nome && $cognome && $sesso && $citta && $tel && $username && $password && $password1)
{
	$ok=TRUE;
	if(!solocaratteri($nome) || !solocaratteri($cognome))
	{
		$ok=FALSE;
		echo "il nome e cognome devono essere formati da soli caratteri!";
		
	}
	if(!solocaratteri($citta) && $ok)
	{
		$ok=FALSE;
		echo "Il campo città deve essere formato da soli caratteri.";
	}
	if(!solonumeri($tel) && $ok)
	{
		$ok=FALSE;
		echo "Il campo telefono deve essere composto da soli numeri.";
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL) && $ok)
	{
		$ok=FALSE;
		echo "Formato e-mail non corretto";
	}
	if($ok)
	{
		$query1="SELECT * FROM Clienti c WHERE c.email='$email'";
		$ris1=mysql_query($query1,$conn) or die("Query fallita" . mysql_error($conn));
		if(mysql_num_rows($ris1)>0)
		{
			$ok=FALSE;
			echo "Esiste gi&agrave un cliente con l'e-mail inserita.";
		}
		if($ok)
		{
			$query2="SELECT * FROM Account a WHERE a.Username='$username'";
			$ris2=mysql_query($query2,$conn) or die("Query fallita" . mysql_error($conn));
			if(mysql_num_rows($ris2)!=0)
			{
				$ok=FALSE;
				echo "Esiste gi&agrave un cliente con l'username inserito";
			}
		}
	}
	if(!lunghezzadata($password,8) && $ok)
	{
		$ok=FALSE;
		echo "La password deve essere lungha 8 caratteri";
	}
	if($password1!=$password && $ok)
	{
		$ok=FALSE;
		echo "Le due password non corrispondono.";
	}
	if($ok)
	{
		$insert1="INSERT INTO Persone(Nome,Cognome,DataNasc,Citta,Sesso,Telefono) VALUES('$nome','$cognome','$data','$citta','$sesso','$tel')";
		$risultato1=mysql_query($insert1,$conn) or die("Query fallita" . mysql_error($conn));
		$id=mysql_insert_id();
		$insert2="INSERT INTO Clienti(Idcliente,email) VALUES('$id','$email')";
		$risultato2=mysql_query($insert2,$conn) or die("Query fallita" . mysql_error($conn));
		$passc=SHA1($password);//metto in scuro la password
		$insert3="INSERT INTO Account(Idcliente,Username,Password) VALUES('$id','$username','$passc')";
		$risultato3=mysql_query($insert3,$conn) or die("Query fallita" . mysql_error($conn));
		echo<<<END
		Registrazione effettuata con successo
		<p>
		<a href="Home.php">Clicca qui</a>
		per tornare alla Home</p>
END;
	}
}	
else
	{
 	echo "Tutti i campi vanno compilati";
	}
?>