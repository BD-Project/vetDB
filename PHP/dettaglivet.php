<?php
require "Utility.php";
require "Connect.php";
$id=$_GET['Id'];
$nome=$_GET['nome'];
$cognome=$_GET['cognome'];
page_start("Dettagli Veterinario");
echo "<h1>Dettagli di $nome $cognome(Id=$id)</h1>";
echo "<h3>Visite effettuate</h3>";
$query1="SELECT v.Idvisita,v.Datavisita,v.Oravisita,v.Animale,tv.Nome,tv.Costo FROM TipoVisite tv JOIN Visite v ON(tv.Id=v.Tipovisita) NATURAL JOIN VisiteVeterinari vv
WHERE v.Datavisita<CURDATE() AND vv.Idveterinario='$id'";
$ris1=mysql_query($query1,$conn) or die("Query fallita". mysql_error($conn));
if(mysql_num_rows($ris1))
{
	$headers=array("Idvisita","Data visita","Ora visita","Animale visitato","Tipo di visita","Costo");
	table_start($headers);
	while($row=mysql_fetch_row($ris1))
		table_row($row);
	table_end();
}
else
	echo "$nome $cognome non ha effettuato ancora alcuna visita";
echo "<h3>Specializzazioni</h3>";
$query2="SELECT tv.id,tv.Nome  FROM Specializzazioni s JOIN TipoVisite tv ON(s.Idtipovisita=tv.Id) WHERE s.Idveterinario='$id'";
$ris2=mysql_query($query2,$conn) or die ("query fallita". mysql_error($conn));
if(mysql_num_rows($ris2))
{
	$headers=array("Idspecializzazione","Descrizione");
	table_start($headers);
	while($row=mysql_fetch_row($ris2))
		table_row($row);
	table_end();
}
else
	echo "$nome $cognome non ha ancora alcuna specializzazione";
echo<<<END
	<p>
	<a href="indexveterinari.php">Clicca qui</a>
	per tornare all'indice
	</p>
END;
page_end();
?>