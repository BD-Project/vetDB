<?php
session_start();
require "Utility.php";
page_start("Veterinari");
headerdiv("Zoo Planet");
pathdiv("Veterinari");
$username=$_SESSION['username'];
navdiv($username);
echo<<<END
<div id="contenent" style="backgound-color:white">
	<h1>Indice dei veterinari</h1>
	<li><a href="allvet.php">Tutti i nostri veterinari</a>
	<li><a href="cercavet.php">Cerca tra i nostri veterinari</a>
	</div>
END;
page_end();
?>
