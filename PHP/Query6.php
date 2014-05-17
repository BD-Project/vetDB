<?php
require "Connect.php";
require "Utility.php";
table_start("Query 6");
echo<<<END
<h1>Query6</h1>
<h3>Query che trova i clienti che hanno solo gatti o solo cani.</h3>
END;
$query="SELECT p.Idpersona,p.Nome,p.Cognome,c.email
FROM Persone p JOIN Clienti c ON(p.Idpersona=c.Idcliente)
WHERE c.Idcliente IN(SELECT DISTINCT(a.Padrone)
					 FROM Animali a)
	AND(c.Idcliente NOT IN(SELECT DISTINCT a.Padrone
						 FROM Animali a
						 WHERE a.Tipoanimale<>'Gatto')
	OR c.Idcliente NOT IN(SELECT DISTINCT a.Padrone
						 FROM Animali a
						 WHERE a.Tipoanimale<>'Cane'))";
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