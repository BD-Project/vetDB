<?php
require "Connect.php";
require "Utility.php";
session_start();
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("Risultati ricerca");
	echo "<h1>Risultati della tua ricerca</h1>";
	$nome=$_GET['nome'];
	$sesso=$_GET['sesso'];
	$razza=$_GET['razza'];
	if($nome || $sesso || $razza)
	{
		$query="SELECT a.Idanimale,a.Nome,a.Peso,a.Coloreocchi,a.Colorepelo,a.Razza,a.Tipoanimale,a.Datanasc,a.Sesso FROM Animali a JOIN Account ac 		ON(a.Padrone=ac.Idcliente) WHERE ac.Username='$username'";
		$where;
		if($nome)
			$where.="AND a.Nome LIKE '%$nome%'";
		if($sesso)
			$where.="AND a.Sesso='$sesso'";
		if($razza)
			$where.="AND a.Razza='$razza'";
		$query=$query . $where;
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
			echo "Nessun animale trovato con i parametri inseriti";
	
	}
	else
		echo "Almeno un campo va compilato";
	echo "<p>";
	echo '<a href="Cercaanimali.php">Clicca qui</a>';
	echo " per toranre al form di ricerca</p>";
	page_end();
}
else
	echo "Accesso negato";
?>