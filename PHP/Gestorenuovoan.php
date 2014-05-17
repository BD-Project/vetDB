<?php
session_start();
require "Connect.php";
require "Utility.php";
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
	$vacc=$_POST['vacc'];
	$ster=$_POST['ster'];
	$sverm=$_POST['sverm'];
	$padrone="SELECT a.Idcliente FROM Account a WHERE a.Username='$username'";
	$ris=mysql_query($padrone,$conn)or die("Query fallita".mysql_error($conn));
	$row=mysql_fetch_row($ris);
	$id=$row[0];
	if($nome && $peso && $cocchi && $cpelo && $razza && $tipo && $sesso && $data && $vacc && $ster && $sverm && $id)
	{
		if($vacc=='TRUE')
			$vacc=1;
		else
			$vacc=0;
		if($ster=='TRUE')
			$ster=1;
		else
			$ster=0;
		if($sverm=='TRUE')
			$sverm=1;
		else
			$sverm=0;
		page_start("Registrazione nuovo animale");
		$insert="INSERT INTO Animali(Nome,Padrone,Peso,Coloreocchi,Colorepelo,Razza,Tipoanimale,Sesso,Datanasc)
				VALUES('$nome','$id','$peso','$cocchi','$cpelo','$razza','$tipo','$sesso','$data')";
		$ris1=mysql_query($insert,$conn) or die("Inserimento non riuscito".mysql_error($conn));
		$idanimale=mysql_insert_id();
		$update="UPDATE SchedeCliniche 
				SET Sverminato='$sverm', Sterilizzato='$ster', Vaccinato='$vacc'
				WHERE Idanimale='$idanimale'";
		$ris2=mysql_query($update,$conn) or die("Creazione della scheda clinica non riuscita".mysql_error($conn));
		echo<<<END
		Registrazione dell'animale avvenuta con successo.
		<p>
		<a href="Indexanimali">Clicca qui</a>
		per tornare all'indice</p>
END;
		page_end();
	}
	
}
else
	echo "Accesso negato";
?>