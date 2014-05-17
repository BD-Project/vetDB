<?php
require "Utility.php";
session_start();
$username=$_SESSION['username'];
if(!isset($username))
	echo "Accesso negato";
else
{
	page_start("Le tue visite");
	headerdiv("Zoo Planet");
	pathdiv("Le tue visite");
	navdiv($username);
	echo<<<END
		<div id="contenent" style="backgound-color:white">
		<h1>Indice delle visite degli animali di $username</h1>
		<li><a href="visite.php">Tutte le visite</a>
		<li><a href="visiteeffett.php">Tutte le visite gi&agrave effettuate</a>
		<li><a href="visiteinprog.php">Tutte le visite in programma</a>
		<li><a href="nuovavisita.php">Inserisci una nuova visita</a>
		<li><a href="deletevisita.php">Elimina una visita</a>
		</div>
END;
	}
?>