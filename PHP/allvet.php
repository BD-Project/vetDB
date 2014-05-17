
<?php
require "Connect.php";
require "Utility.php";
page_start("Tutti i veterinari");
echo "<h1>Tutti i nostri veterinari</h1>";
$query1="SELECT v.Idveterinario,p.Nome,p.Cognome,p.Datanasc,p.Citta,p.Sesso,p.Telefono FROM Persone p JOIN Veterinari v ON(p.Idpersona=v.Idveterinario)";
$ris=mysql_query($query1,$conn) or die("Query fallita" . mysql_error($conn));
if(!mysql_num_rows($ris))
	echo "Nessun veterinario trovato";
else
	{
		$header=array("Idveterinario","Nome","Cognome","Data di Nascita","Citt&agrave","Sesso","Telefono");
		table_start($header);
		while($row=mysql_fetch_row($ris))
		{
			$url="dettaglivet.php?Id=" . urlencode($row[0]) . "&nome=" . urlencode($row[1]) . "&cognome=" . urlencode($row[2]);
			$row[0]="<a href='$url'>" . $row[0] . "</a>";
			table_row($row);
		}
		table_end();
	}
echo "<p>";
echo '<a href="indexveterinari.php">Clicca qui</a>';
echo " per tornare al punto precedente";
echo"</p>";
page_end();
?>