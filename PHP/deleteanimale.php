<?php
session_start();
$username=$_SESSION['username'];
require "Connect.php";
require "Utility.php";
if(!isset($username))
	echo "Accesso negato";
else
{
	page_start("Elimina un animale");
	$query1="SELECT a.Idanimale,a.Nome,a.Peso,a.Coloreocchi,a.Colorepelo,a.Razza,a.Tipoanimale,a.Datanasc,a.Sesso FROM Animali a JOIN Account ac 	 	 	 	         	 ON(a.Padrone=ac.Idcliente) WHERE ac.Username='$username'";
	$ris=mysql_query($query1,$conn) or die("Query fallita".mysql_error($conn));
	if(!mysql_num_rows($ris))
		echo "Non c'&egrave alcun animale da eliminare";
	else
	{
			echo"<h1>Sciegli l'animale che vuoi eliminare</h1>";
			echo '<form action="deletea.php" method="POST">';
			$headers=array("Idanimale","Nome","Peso","Colore degli occhi","Colore del pelo","Razza","Tipo di animale","Data di nascita","Sesso");
			table_start($headers);
			while($row=mysql_fetch_array($ris))
			{
				$id=$row['Idanimale'];
				$nome=$row['Nome'];
				$peso=$row['Peso'];
				$cocchi=$row['Coloreocchi'];
				$cpelo=$row['Colorepelo'];
				$razza=$row['Razza'];
				$tipo=$row['Tipoanimale'];
				$data=$row['Datanasc'];
				$sesso=$row['Sesso'];
				echo<<<END
				<tr>
				<td><input type='radio' name='id' value='$id'></td>
				<td><input type='text' name='nome' value='$nome'></td>
				<td><input type='text' name='peso' value='$peso'></td>
				<td><input type='text' name='cocchi' value='$cocchi'></td>
				<td><input type='text' name='cpelo' value='$cpelo'></td>
				<td><input type='text' name='razza' value='$razza'></td>
				<td><input type='text' name='tipo' value='$tipo'></td>
				<td><input type='text' name='data' value='$data'></td>
				<td><input type='text' name='sesso' value='$sesso'></td>
				</tr>
END;
			}
			table_end();
			echo '<input type="submit" name="elimina" value="Elimina">';
			echo "</form>";
		}
	echo "<p>";
	echo '<a href="Indexanimali.php">Clicca qui</a>';
	echo " per tornare all'inidce</p>";
	page_end();
}
?>