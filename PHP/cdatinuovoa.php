<?php
require "Utility.php";
session_start();
$username=$_SESSION['username'];
if(isset($username))
{
	$nome=$_POST['nome'];
	$peso=$_POST['peso'];
	$cocchi=$_POST['cocchi'];
	$cpelo=$_POST['cpelo'];
	$razza=$_POST['razza'];
	$tipo=$_POST['tipo'];
	$sesso=$_POST['sesso'];
	$data=$_POST['data'];
	$vacc=$_POST['vaccinato'];
	$ster=$_POST['sterilizzato'];
	$sverm=$_POST['sverminato'];
	if($nome && $peso && $cocchi && $cpelo && $razza && $tipo && $sesso && $data && $vacc && $ster && $sverm)
	{
		page_start("Riepilogo dati");
		echo<<<END
		<h1>Prospetto riassuntivo</h1>
		<ul>
		<li>Nome: $nome</li>
		<li>Peso: $peso</li>
		<li>Colore degli occhi: $cocchi</li>
		<li>Colore del pelo: $cpelo</li>
		<li>Razza: $razza</li>
		<li>Tipo di animale: $tipo</li>
		<li>Sesso: $sesso</li>
		<li>Data di nascita: $data</li>
		<li>Vaccinato: $vacc</li>
		<li>Sterilizzato: $ster</li>
		<li>Sverminato: $sverm</li>
		</ul>
		<form action="Gestorenuovoan.php" method="POST">
		<input type="hidden" name="nome" value="$nome">
		<input type="hidden" name="peso" value="$peso">
		<input type="hidden" name="cocchi" value="$cocchi">
		<input type="hidden" name="cpelo" value="$cpelo">
		<input type="hidden" name="razza" value="$razza">
		<input type="hidden" name="tipo" value="$tipo">
		<input type="hidden" name="sesso" value="$sesso">
		<input type="hidden" name="data" value="$data">
		<input type="hidden" name="vacc" value="$vacc">
		<input type="hidden" name="ster" value="$ster">
		<input type="hidden" name="sverm" value="$sverm">
		<input type="submit" name="Conferma" value="Conferma">
		</form>
END;
		
		page_end();
	}

}
else
	echo "Accesso negato";
?>