<?php
require "Utility.php";
session_start();
$username=$_SESSION['username'];
if(isset($username))
{
	page_start("Completa le informazioni cliniche");
	$nome=$_POST['nome'];
	$peso=$_POST['peso'];
	$cocchi=$_POST['cocchi'];
	$cpelo=$_POST['cpelo'];
	$razza=$_POST['razza'];
	$tipo=$_POST['tipo'];
	$sesso=$_POST['sesso'];
	$giorno=$_POST['giorno'];
	$mese=$_POST['mese'];
	$anno=$_POST['anno'];
	$data=$anno."-".$mese."-".$giorno;//creo la data concatenando giorno, mese e anno
	if($nome && $peso && $cocchi && $cpelo && $razza && $tipo && $sesso && $data )
	{
		$ok=TRUE;
		if(!solocaratteri($nome))
		{
			$ok=FALSE;
			echo "Il nome deve essere formato da soli caratteri";
		}
		if($ok && !is_numeric($peso))
		{
			$ok=FALSE;
			echo "Il peso deve essere formato da soli numeri";
		}
		if($ok && !solocaratteri($cocchi))
		{
			$ok=FALSE;
			echo "Il colore degli occhi deve essere formato da soli caratteri";
		}
		if($ok && !solocaratteri($cpelo))
		{
			$ok=FALSE;
			echo "Il colore del pelo deve essere formato da soli caratteri";
		}
		if($ok && !solocaratteri($razza))
		{
			$ok=FALSE;
			echo "La razza deve essere formata da soloi caratteri";
		}
		if($ok && !solocaratteri($tipo))
		{
			$ok=FALSE;
			echo "Il tipo di animale deve essere formata da soli caratteri";
		}
		if($ok)
		{
			echo<<<END
			<h1>Competa le informazioni cliniche</h1>
			<form action="cdatinuovoa.php" method="POST">
			<fieldset>
			<label for="vaccinato">Vaccinato:</label>
			<select name="vaccinato">
				<option>TRUE</option>
				<option>FALSE</option>
			</select><br>
			<label for="sterilizzato">Sterilizzato:</label>
			<select name="sterilizzato">
				<option>TRUE</option>
				<option>FALSE</option>
			</select><br>
			<label for="sverminato">Sverminato:</label>
			<select name="sverminato">
				<option>TRUE</option>
				<option>FALSE</option>
			<select><br>
			<input type="hidden" name="nome" value="$nome">
			<input type="hidden" name="peso" value="$peso">
			<input type="hidden" name="cocchi" value="$cocchi">
			<input type="hidden" name="cpelo" value="$cpelo">
			<input type="hidden" name="razza" value="$razza">
			<input type="hidden" name="tipo" value="$tipo">
			<input type="hidden" name="sesso" value="$sesso">
			<input type="hidden" name="data" value="$data">
			<input type="submit" value="Avanti">
			</fieldset>
			</form>
END;
			
			
		}
	}
	else
	{
		echo<<<END
		Tutti i campi vanno compilati
		<p>
		<a href="nuovoanimale.php">Cicca qui</a>
		per tornare alla pagina precedente</p>
END;
	}
	page_end();
	
}
else
	echo "Accesso negato";
?>