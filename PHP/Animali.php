<?php
require "Utility.php";
require "Connect.php";
session_start();
$username=$_SESSION['username'];
if(isset($username))
	{
		page_start("Tutti i tuoi animali");
		echo "<h1>Tutti gli animali di $username</h1>";
		$query="SELECT a.Idanimale,a.Nome,a.Peso,a.Coloreocchi,a.Colorepelo,a.Razza,a.Tipoanimale,a.Datanasc,a.Sesso FROM Animali a JOIN Account ac 		ON(a.Padrone=ac.Idcliente) WHERE ac.Username='$username'";
		$ris=mysql_query($query,$conn) or die("Query fallita".mysql_error($conn));
		if(mysql_num_rows($ris))
		{
			$headers=array("Idanimale","Nome","Peso","Colore degli occhi","Colore del pelo","Razza","Tipo di animale","Data di nascita","Sesso");
			table_start($headers);
			while($row=mysql_fetch_row($ris))
			{
				$url="Dettaglianimali.php?Id=" . urlencode($row[0]) . "&nome=" . urlencode($row[1]);
				$row[0]="<a href='$url'>" . $row[0] . "</a>";
				table_row($row);
			}
			table_end();
		}
		else
			echo "Non hai ancora registrato alcun animale presso il nostro studio";
		echo "<p>";
		echo '<a href="Indexanimali.php">Clicca qui</a>';
		echo " per tornare all'indice</p>";
		page_end();
	}	
else
	echo "Accesso negato";
?>