<?php
require "Utility.php";
require "Connect.php";
session_start();
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("Tutte le visite");
	echo "<h1>Tutte le visite degli animali di $username</h1>";
	$animali="SELECT * FROM Animali a JOIN Account ac ON(a.Padrone=ac.Idcliente) WHERE ac.Username='$username'";
	$risa=mysql_query($animali,$conn) or die("Query fallita".mysql_error($conn));
	if(mysql_num_rows($risa))
	{
	$query="SELECT v.Idvisita,a.Idanimale,tv.Nome,tv.Costo,v.Datavisita,v.Oravisita  FROM TipoVisite tv JOIN Visite v ON(tv.Id=v.Tipovisita) JOIN Animali a 	ON(v.Animale=a.Idanimale) JOIN Account ac 	ON(a.Padrone=ac.Idcliente) WHERE ac.Username='$username'  ORDER BY v.Idvisita ASC";
	$ris=mysql_query($query,$conn) or die("Query fallita".mysql_error($conn));
	if(mysql_num_rows($ris))
	{
		$headers=array("Idvisita","Idanimale","Tipo visita","Costo","Data visita","Ora visita");
		table_start($headers);
		while($row=mysql_fetch_row($ris))
			table_row($row);
		table_end();
	}
	else
		echo "I tuoi animali non hanno ancora effettuato alcuna visita presso il nostro studio";
	
	}
	else
		echo "	Non hai alcun animale registrato presso il nostro studio";
	echo<<<END
	<p>
	<a href="indexvisite.php">Clicca qui</a>
	per tornare all'indice</p>
END;
	page_end();
}
else
	echo "Accesso negato";
?>
