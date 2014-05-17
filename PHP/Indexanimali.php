<?php
session_start();
require "Utility.php";
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("I tuoi animali");
	headerdiv("Zoo Planet");
	pathdiv("I tuoi animali");
	navdiv($username);
	echo<<<END
		<div id="contenent" style="backgound-color:white">
		<h1>Indice degli animali di $username</h1>
		<li><a href="Animali.php">Tutti i tuoi animali</a>
		<li><a href="Cercaanimali.php">Cerca tra i tuoi animali</a>
		<li><a href="nuovoanimale.php">Registra un nuovo animale</a>
		<li><a href="deleteanimale.php">Elimina un tuo animale</a>
		</div>
END;
page_end();
}
else
	echo "Accesso negato";
?>