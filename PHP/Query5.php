<?php
require "Connect.php";
require "Utility.php";
page_start("Query 5");
echo<<<END
<h1>Query5</h1>
<h3>Query che visuallizza  i clienti i cui animali hanno tutti effettuato solo visite con costo superiore a 20 euro.</h3>
END;
$query="SELECT c.Idcliente,p.Nome,p.Cognome,c.email
FROM Clienti c JOIN Persone p ON(c.Idcliente=p.Idpersona)
WHERE NOT EXISTS(SELECT *
				 FROM TipoVisite tv JOIN Visite v ON(tv.Id=v.Tipovisita) 
				 JOIN Animali a ON(a.Idanimale=v.Animale)
				 WHERE a.Padrone=c.Idcliente AND tv.Costo<=20 AND v.Datavisita<CURDATE())
		AND c.Idcliente IN(SELECT a.Padrone
					       FROM Animali a)";
$ris=mysql_query($query,$conn)or die("Query fallita" . mysql_error($conn));
if(!mysql_num_rows($ris))
	echo "Nessun risultato trovato";
else
{
	$headers=array("Idcliente","Nome","Cognome","e-mail");
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