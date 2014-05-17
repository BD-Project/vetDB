<?php
require "Connect.php";
require "Utility.php";
page_start("Query 3");
echo<<<END
<h1>Query3</h1>
<h3>Query che trova i Veterinari che vivono nella citt&agrave di Padova ed hanno effettuato almeno 2 Visite
nel giorno del loro compleanno dell'anno corrente.</h3>
END;
$query="SELECT v.Idveterinario,p.Nome,p.Cognome,COUNT(*) AS Numvisite
FROM Persone p JOIN Veterinari v ON(p.Idpersona=v.Idveterinario) NATURAL JOIN VisiteVeterinari vv NATURAL JOIN Visite vi
WHERE p.Citta='Padova' AND (MONTH(p.Datanasc)=MONTH(vi.Datavisita)) AND (DAY(P.Datanasc)=DAY(vi.Datavisita)) 
	  AND (YEAR(vi.Datavisita)=YEAR(CURDATE())) AND vi.Datavisita<CURDATE()
GROUP BY v.Idveterinario,p.Nome,p.Cognome
HAVING COUNT(*)>=2";
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
page_end();
?>