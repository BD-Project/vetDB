<?php
session_start();
require "Utility.php";
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("Registra un nuovo animale");
	echo<<<END
	<h1>Registra un nuovo animale</h1>
	<form action="compilaclinica.php" method="POST">
	<fieldset>
	<label for="nome">Nome:</label>
	<input type="text" name="nome"><br>
	<label for="peso">Peso:</label>
	<input type="text" name="peso"><br>
	<label for="cocchi">Colore degli occhi:</label>
	<input type="text" name="cocchi"><br>
	<label for="cpelo">Colore del pelo:</label>
	<input type="text" name="cpelo"><br>
	<label for="razza">Razza:</label>
	<input type="text" name="razza"><br>
	<label for="tipo">Tipo di animale:</label>
	<input type="text" name="tipo"><br>
	<label for="sesso">Sesso:</label>
	<select name="sesso">
		<option>M</option>
		<option>F</option>
	</select><br>
	Data di nascita:
	<label for="giorno">Giorno:</label>
	<select name="giorno">
END;
	for($i=1; $i<=31; ++$i)
	{
		echo '<option value='.$i.'>'.$i.'</option>';
	}
	echo'</select>';
	echo'<label for="mese">Mese:';
	echo'<select name="mese">';
	for($i=1;$i<=12;++$i)
	{
		echo '<option value='.$i.'>'.$i.'</option>';
	}
	echo '</select>';
	echo '<label for="anno">Anno:';
	echo '<select name="anno">';
	for($i=date('Y');$i>=1920;$i--)
	{
		echo '<option value='.$i.'>'.$i.'</option>';
		
	}
	echo<<<END
	</select><br>
	<input type="submit" value="Avanti">
	</fieldset>
	</form>
	<p>
	<a href="Indexanimali.php">Clicca qui</a>
    per tornare all'indice</p>
END;
	page_end();
}
else
	echo "Accesso negato";
?>