<?php
session_start();
require "Connect.php";
require "Utility.php";
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("Cerca animali");
	$num="SELECT an.Razza,an.sesso FROM Animali an JOIN Clienti c ON(an.Padrone=c.Idcliente) NATURAL JOIN Account a WHERE a.Username='$username'"; 
	$ris1=mysql_query($num,$conn) or die or die("Query fallita" . mysql_error($conn));
	if(mysql_num_rows($ris1)>0)
	{
		echo<<<END
		<h1>Cerca tra i tuoi animali</h1>
		<form action="animalifiltra.php" method="GET">
			<fieldset>
			<legend>Cerca</legend
			<label for="nome">Nome:</label>
			<input type="text" name="nome"/><br>
			<label for="sesso">Sesso:</label>
			<select name="sesso">
			<option>M</option>
			<option>F</option>
			</select><br>
			<label for="razza">Razza:</label>
			<select name="razza">
END;
		while ($row=mysql_fetch_row($ris1))
			echo"<option>$row[0]</option>";
		echo<<<END
			</select><br>
			<input type="submit" value="Cerca">
			</fieldset>
			</form>
END;
	}
else
	echo "Non hai ancora registrato ancora nessun animale presso il nostro studio";
echo "<p>";
echo '<a href="Indexanimali.php">Clicca qui</a>';
echo " per tornare all'indice</p>";
page_end();
}
else
	echo "Accesso negato";
?>