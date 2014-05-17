<?php
function page_start($title)
{
	echo "<html>";
	echo "<head>";
	echo "<title>$title</title>";
	echo "</head>";
	echo "<body>";
}
function page_end()
{
	echo "</body>";
	echo "</html>";
}
function table_start($row) {
  echo "<table border=\"1\">";
  echo "<tr>";
  foreach ($row as $field) 
    echo "<td>$field</td>";
  echo "</tr>\n";
};
function table_row($row){
    echo "<tr>";
     foreach ($row as $field) 
         echo "<td>$field</td>";
     echo "</tr>";
}
function table_end()
{
	echo "</table>";
}
function solonumeri($stringa)
{
	return preg_match('/^[0-9]*$/',$stringa);
}
function solocaratteri($stringa)
{
	return preg_match('/^[a-zA-Z]*$/',$stringa);
}
function lunghezzadata($stringa,$n)
{
	return strlen($stringa)==$n;
}
function headerdiv($title)
{
	echo<<<END
	<div id="header" style="background-color:blue;height:20%;width:100%">
	<h1 style="margin-bottom:0;text-align:center">$title</h1>
	<p>
		<span class="residenza">Via Borgo Castellana, 51</span><br>
		<span class="residenza">Montebelluna 31044</span><br>
		<span class="residenza">Treviso Italy</span><br>
	</p>
	</div>
END;
}
function pathdiv($path)
{
		echo'<div id="path" style="background-color:yellow;">';
		echo"Ti trovi in: $path";
		echo'</div>';
}
function navdiv($username)
{
	echo<<<END
	<div id="nav" style="background-color:lightblue;height:100%;width:20%;float:left;">
	<ul>
	<li><a href="Home.php">Home</a>
	<li><a href="Query.php">Query</a>
	<li><a href="indexveterinari.php">Veterinari</a>
END;
	if(!isset($username))
	{
		echo "<li><a href=\"Login.php\">Login</a>";
		echo "<li><a href=\"Registrerform.php\">Registrati</a>";
	}
	else
	{
		echo "<li><a href=\"profile.php\">I tuo profilo</a>";
		echo "<li><a href=\"Indexanimali.php\">I tuoi animali</a>";
		echo "<li><a href=\"indexvisite.php\">Le tue visite</a>";
		
		echo "<li><a href=\"Logout.php\">Logout</a>";
	}
	echo "</ul>";
	echo "</div>";
}
?>