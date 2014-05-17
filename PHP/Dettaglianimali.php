<?php
session_start();
require "Connect.php";
require "Utility.php";
$username=$_SESSION['username'];
if(isset($username))
{
	$id=$_GET['Id'];
	$nome=$_GET['nome'];
	page_start("Dettagli animale");
	echo "<h1>Dettagli di $nome(Id=$id)</h1>";
	$query1="SELECT s.Datacreazione,s.Vaccinato,s.Sverminato,s.Sterilizzato,s.Annotazioni FROM SchedeCliniche s WHERE s.Idanimale='$id'";
	$ris1=mysql_query($query1,$conn) or die ("Query fallita".mysql_error($conn));
	if(mysql_num_rows($ris1))
	{
		echo "<h3>Scheda clinica di $nome</h3>";
		$headers=array("Data creazione","Vaccinato","Sverminato","Sterilizzato","Annotazioni");
		table_start($headers);
		while($row=mysql_fetch_array($ris1))
		{
			$data=$row['Datacreazione'];
			$vaccinato=$row['Vaccinato'];
			$sverminato=$row['Sverminato'];
			$sterilizzato=$row['Sterilizzato'];
			$annotazioni=$row['Annotazioni'];
			echo "<tr>";
			echo "<td>$data</td>";
			if($vaccinato)
				echo "<td>SI</td>";
			else
				echo "<td>NO</td>";
			if($sverminato)
				echo "<td>SI</td>";
			else
				echo "<td>NO</td>";
			if($sterilizzato)
				echo "<td>SI</td>";
			else
				echo "<td>NO</td>";
			echo "<td>$annotazioni</td>";
			echo "</tr>";
		}
		table_end();
	}
	echo "<h3>Visite di $nome</h3>";
	$query2="SELECT v.Idvisita,v.Datavisita,v.Oravisita,tv.Nome,tv.Costo FROM TipoVisite tv JOIN Visite v  ON(tv.Id=v.Tipovisita) JOIN Animali a 	 	    		 	 	 ON(v.Animale=a.Idanimale) WHERE v.Animale='$id' AND v.Datavisita<CURDATE()";
	$ris2=mysql_query($query2,$conn) or die("Query fallita".mysql_error($conn));
	if(mysql_num_rows($ris2))
	{
		$headers=array("Idvisita","Data visita","Ora visita","Descrizione","Costo");
		table_start($headers);
		while($row=mysql_fetch_row($ris2))
			table_row($row);
		table_end();
	}
	else
		echo "$nome non ha anora effettuato alcuna visita";
	echo "<p>";
	echo '<a href="Indexanimali.php">Clicca qui</a>';
	echo " per tornare all'indice</p>";
	page_end();
}
else
	echo "Accesso negato";
?>