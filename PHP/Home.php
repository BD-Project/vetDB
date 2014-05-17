<?php
session_start();
require "Connect.php";
require "Utility.php";
page_start("Home");
headerdiv("Zoo Planet");
pathdiv("Home");
$username=$_SESSION['username'];
navdiv($username);
echo<<<END
<div id="contenent" style="backgound-color:white">
	<h2>Chi siamo?</h2>
	<p>
		Siamo uno studio veterinario che da poco ha aperto a Montebelluna.
		Abbiamo pi&ugrave di trenta Veterinari che si prenderanno cura dei tuoi animali.
	</p>
	<h2>Orario</h2>
	<p>
		Siamo aperti da luned&igrave al venerd&igrave dalle 8:00 alle 19:00 con 
		orario continuato.Venite a trovarci!!
	</p>
	<h2>Contatti</h2>
	<p>
		Se vuoi avere informazione sulle nostre tariffe e sui nostri servizi contattare il numero
		telefonico 3345718555 o scrivete una e-mail a alberto.adami.7@gmail.com
	</p>
	<h2>Servizi</h2>
	<p>
		Forniamo i seguenti tipi di visita con il relativo prezzo.
END;
		$query="SELECT tv.Nome,tv.Costo FROM TipoVisite tv";
		$ris=mysql_query($query,$conn) or die("Query fallita".mysql_error($conn));
		$header=array("Descrizione","Costo");
		table_start($header);
		while($row=mysql_fetch_row($ris))
			table_row($row);
		table_end();
		echo"</p>";
		echo "</div>";
		page_end();
?>