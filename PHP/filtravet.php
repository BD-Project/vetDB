<?php
require "Connect.php";
require "Utility.php";
page_start("Risultati ricerca");
$nome=$_GET['nome'];
$cognome=$_GET['cognome'];
$citta=$_GET['citta'];
$sesso=$_GET['sesso'];
echo "<h1>Risultati della ricerca</h1>";
if($nome || $cognome || $citta || $sesso)
{
	$query1="SELECT v.Idveterinario,p.Nome,p.Cognome,p.Datanasc,p.Citta,p.Sesso,p.Telefono FROM Persone p JOIN Veterinari v ON(p.Idpersona=v.Idveterinario)";
	$where="WHERE TRUE ";
	if($nome)
		$where.="AND p.Nome LIKE '%$nome%'";
	if($cognome)
		$where.="AND p.Cognome LIKE '%$cognome%'";
	if($citta)
		$where.="AND p.Citta='$citta'";
	if($sesso)
		 $where.="AND p.Sesso='$sesso'";
	$query1=$query1 . $where;
	$ris=mysql_query($query1,$conn) or die("Query fallita" . mysql_error($conn));
	if(!mysql_num_rows($ris))
		echo "Nessun veterinario trovato con i parametri inseriti";
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
	
}
else
	echo "Compilare almeno uno dei campi del form";
echo "<p>";
echo '<a href="cercavet.php">Clicca qui</a>';
echo " per toranre al form di ricerca";
echo "</p>";
table_end();
?>