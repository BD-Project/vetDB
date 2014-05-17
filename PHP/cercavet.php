
<?php
require "Connect.php";
require "Utility.php";
page_start("Cerca veterinari");
echo "<h1>Cerca tra i nostri veterinari</h1>";
$query="SELECT DISTINCT (p.Citta) FROM Persone p JOIN Clienti c ON(p.Idpersona=c.Idcliente)";
$risultato=mysql_query($query,$conn) or die("Query fallita" . mysql_error($conn));
echo<<<END
<form action="filtravet.php" method="GET">
 <fieldset>
  <legend>Cerca</legend>
	<label for="nome">Nome:</label>
	<input type="text" name="nome"/><br>
	<label for="cognome">Cognome:</label>
	<input type="text" name="cognome"><br>
	<label for="citta">Citt&agrave</label>
	<select name="citta">
END;
		while($row=mysql_fetch_row($risultato))
		{
		 echo "<option value=\"".$row[0]."\">".$row[0]."</option>";
		}
echo<<<END
	</select><br>
	<label for="sesso">Sesso</label>
	<select name="sesso">
		<option value="M">M</option>
		<option value="F">F</option>
	</select><br>
    <input type="submit" value="Cerca" /><br>
 	</fieldset>
 	<p>
 	<a href="indexveterinari.php">Clicca qui</a> per tornare al punto precedente
 	</p>
END;
 page_end();
 ?>