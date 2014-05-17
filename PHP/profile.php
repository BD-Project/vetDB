<?php
session_start();
$username=$_SESSION['username'];
if(isset($username))
{
	require "Utility.php";
	require "Connect.php";
	page_start("Il tuo profilo");
	headerdiv("Zoo Planet");
	pathdiv("Il tuo profilo");
	navdiv($username);
	$query="SELECT p.Nome,p.Cognome,p.Datanasc,p.Citta,p.Sesso,p.Telefono,c.email FROM Persone p JOIN Clienti c ON(p.Idpersona=c.Idcliente) NATURAL JOIN Account ac 	WHERE ac.Username='$username'";
	$ris=mysql_query($query,$conn) or die("Query fallita".mysql_query($conn));
	$row=mysql_fetch_row($ris);
	$nome=$row[0];
	$cognome=$row[1];
	$data=$row[2];
	$citta=$row[3];
	$sesso=$row[4];
	$tel=$row[5];
	$email=$row[6];
	echo<<<END
	<h1 align="center">Profilo di $username</h1>
	<table width="398" border="1" align="center">
	<tr>
	<td>Nome</td>
	<td>$nome</td>
	</tr>
	<td>Cognome</td>
	<td>$cognome</td>
	</tr>
	<td>Data di nascita</td>
	<td>$data</td>
	</tr>
	<td>Citt&agrave</td>
	<td>$citta</td>
	</tr>
	<td>Sesso</td>
	<td>$sesso</td>
	</tr>
	<td>Telefono</td>
	<td>$tel</td>
	</tr>
	<td>E-mail</td>
	<td>$email</td>
	</tr>
	</table>
	<p>
	<a href="Changepassword.php">Cambia password</a><br>
	<a href="editprofile.php">Modifica informazioni</a>
	</p>
END;
}
else
	echo "Accesso negato";
?>