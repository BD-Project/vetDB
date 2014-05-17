<?php
require "Utility.php";
require "Connect.php";
session_start();
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("Modifica il tuo profilo");
	$query="SELECT p.Nome,p.Cognome,p.Datanasc,p.Citta,p.Sesso,p.Telefono,c.email FROM Persone p JOIN Clienti c ON(p.Idpersona=c.Idcliente) NATURAL JOIN Account ac 
	WHERE ac.Username='$username'";
	$ris=mysql_query($query,$conn) or die("Query fallita".mysql_error($conn));
	$row=mysql_fetch_row($ris);
	$nome=$row[0];
	$cognome=$row[1];
	$data=$row[2];
	$citta=$row[3];
	$sesso=$row[4];
	$tel=$row[5];
	$email=$row[6];
	$fields=explode('-', $data);
	echo<<<END
	<h1>Modifica il tuo profilo</h1>
	<form action="changedprofile.php" method="POST">
	<fieldset>
		<label for="nome">Nome:</label>
		<input type="text" name="nome" value=$nome><br>
		<label for="cognome">Cognome:</label>
		<input type="text" name="cognome" value=$cognome><br>
		<label for="citta">Citt&agrave:</label>
		<input type="text" name="citta" value=$citta><br>
		<label for="sesso">Sesso:</label>
		<select name="sesso">
			<option value="M" if($sesso=='M') selected="selected">M</option>
			<option value="F" if($sesso=='F') selected="selected">F</option>
		</select><br>
		Data di nascita:
		<label for="giorno">Giorno</label>
		<select name="giorno">
END;
		for($i=1;$i<=31;$i++)
			echo '<option '.($fields[3] == $i ? ' selected ' : '').' value="'.$i.'" >'.$i.'</option>'; 
		echo<<<END
		</select>
		<label for="mese">Mese</label>
		<select name="mese">
END;
		for($i=1;$i<=12;$i++)
			echo '<option '.($fields[2] == $i ? ' selected ' : '').' value="'.$i.'" >'.$i.'</option>'; 
		echo<<<END
		</select>
		<label for="anno">Anno</label>
		<select name="anno">
END;
		for($i=date("Y");$i>=1920;$i--)
			echo '<option '.($fields[0] == $i ? ' selected ' : '').' value="'.$i.'" >'.$i.'</option>'; 
		echo<<<END
		</select><br>
		<label for="tel">Telefono:</label>
		<input type="text" name="tel" value=$tel><br>
		<label for="email">E-mail:</label>
		<input type="text" name="email" value=$email><br>
		<input type="submit" name="modifica" value="Modifica">
	</fieldset>
	</form>
	<p>
	<a href="profile.php">Clicca qui</a>
	per tornare al tuo profilo</p>
END;
	page_end();
}
else
	echo "Accesso negato";
?>