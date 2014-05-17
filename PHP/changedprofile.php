<?php
require "Connect.php";
require "Utility.php";
session_start();
$username=$_SESSION['username'];
if(isset($username))
{
	$nome=$_POST['nome'];
	$cognome=$_POST['cognome'];
	$citta=$_POST['citta'];
	$sesso=$_POST['sesso'];
	$giorno=$_POST['giorno'];
	$mese=$_POST['mese'];
	$anno=$_POST['anno'];
	$tel=$_POST['tel'];
	$email=$_POST['email'];
	$data=$anno."-".$mese."-".$giorno;//creo la data concatenando giorno, mese e anno
	if($nome && $cognome && $citta && $sesso && $data && $tel && $email)
	{
		$dati="SELECT c.Idcliente,p.Nome,p.Cognome,p.Datanasc,p.Citta,p.Sesso,p.Telefono,c.email FROM Persone p JOIN Clienti c ON(p.Idpersona=c.Idcliente) NATURAL JOIN 		Account ac WHERE ac.Username='$username'";
		$ris=mysql_query($dati,$conn) or die("Modifica non riuscita".mysql_query($conn));
		$row=mysql_fetch_row($ris);
		$id=$row[0];
		$nomev=$row[1];
		$cognomev=$row[2];
		$datav=$row[3];
		$cittav=$row[4];
		$sessov=$row[5];
		$telv=$row[6];
		$emailv=$row[7];
		if(($nomev!=$nome)||($cognomev!=$cognome)||($citta!=$cittav)||($sesso!=$sessov)||($data!=$datav)||($tel!=$telv)||($email!=$emailv))
		{
			if(($nomev!=$nome)||($cognomev!=$cognome)||($citta!=$cittav)||($sesso!=$sessov)||($data!=$datav)||($tel!=$telv))
			{
				$update1="UPDATE Persone 
				SET Nome='$nome',Cognome='$cognome',Datanasc='$data',Sesso='$sesso',Telefono='$tel'
				WHERE Idpersona='$id'";
				$ris1=mysql_query($update1,$conn) or die("Modica non riuscita".mysqL_error($conn));
			}
			if(($email!=$emailv))
			{
				$update2="UPDATE Clienti
						  SET email='$email'
						  WHERE Idcliente='$id'";
				$ris2=mysql_query($update2,$conn) or die("Modifica non riuscita".mysql_error($conn));
			}
			else
				echo "no";
		}
		else
			echo "Devi modificare almeno un campo";
	}
	else
		echo "Tutti i campi vanno compilati";
	
}
else
	echo "Accesso negato";
?>