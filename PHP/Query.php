<?php
session_start();
require "Utility.php";
page_start("Query");
headerdiv("Zoo Planet");
pathdiv("Query");
$username=$_SESSION['username'];
navdiv($username);
echo<<<END
<div id="contenent" style="backgound-color:white">
	<h1>Indice delle query</h1>
	<li><a href="Query1.php">Query1</a>
	<li><a href="Query2.php">Query2</a>
	<li><a href="Query3.php">Query3</a>
	<li><a href="Query4.php">Query4</a>
	<li><a href="Query5.php">Query5</a>
	<li><a href="Query6.php">Query6</a>
	</div>
END;
page_end();
?>
