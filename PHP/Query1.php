<?php
require "Connect.php";
require "Utility.php";
page_start("Query1");
echo<<<END
<h1>Query1</h1>
<h3>Query che trova i veterinari che hanno fatto un numero di visite superiori alla media.</h3>
END;
$query="SELECT *FROM Numvisite n WHERE n.Num>(SELECT AVG(n1.Num)
			 								  FROM Numvisite n1)";
$ris=mysql_query($query,$conn)or die("Query fallita" . mysql_error($conn));
if(!mysql_num_rows($ris))
	echo "Nessun risultato trovato";
else
{
	$headers=array("Idveterinario","Nome","Cognome","Numvisite");
	table_start($headers);
	while($row=mysql_fetch_row($ris))
		table_row($row);
	table_end();
}
	echo "<p>";
	echo '<a href="Query.php">Clicca qui</a>';
	echo " per tornare all'elenco delle query";
	echo"</p>";
?>
