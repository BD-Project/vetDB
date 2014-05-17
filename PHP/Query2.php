<?php
require "Connect.php";
require "Utility.php";
page_start("Query2");
echo<<<END
<h1>Query2</h1>
<h3>Query che trova i Clienti che hanno speso il massimo in visite per i loro animali.</h3>
END;
$query="SELECT * FROM ClientiCosto cc WHERE cc.CostoTot=(SELECT MAX(cc1.CostoTot)
				   										 FROM ClientiCosto cc1)";
$ris=mysql_query($query,$conn)or die("Query fallita" . mysql_error($conn));
if(!mysql_num_rows($ris))
	echo "Nessun risultato trovato";
else
{
	$headers=array("Idcliente","Nome","Cognome","email","Costotot");
	table_start($headers);
	while($row=mysql_fetch_row($ris))
		table_row($row);
	table_end();
}
echo "<p>";
echo '<a href="Query.php">Clicca qui</a>';
echo " per tornare all'elenco delle query";
echo"</p>";
page_end();
?>