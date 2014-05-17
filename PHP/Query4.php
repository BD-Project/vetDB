<?php
require "Connect.php";
require "Utility.php";
page_start("Query 4");
echo<<<END
<h1>Query4</h1>
<h3>Query che visualizza le 5 razze di animale pi&ugrave diffuse nel database tra animali che hanno effettuato almeno 2 visite.</h3>
END;
$query="SELECT a.Razza, COUNT(*) AS Numanimali
FROM Animali a
WHERE a.Idanimale IN(SELECT a1.Idanimale
					 FROM Animali a1 JOIN Visite v ON(a1.Idanimale=v.Animale)
					 WHERE v.Datavisita<CURDATE()
					 GROUP BY a1.Idanimale
					 HAVING COUNT(*)>=2)
GROUP BY a.Razza
ORDER BY COUNT(*) DESC
LIMIT 5";
$ris=mysql_query($query,$conn)or die("Query fallita" . mysql_error($conn));
if(!mysql_num_rows($ris))
	echo "Nessun risultato trovato";
else
{
	$headers=array("Razza","Numanimali");
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