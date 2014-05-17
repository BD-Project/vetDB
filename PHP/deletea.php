<?php
require "Connect.php";
$id=$_POST['id'];
if($id)
{
	$delete="DELETE FROM Animali WHERE Idanimale='$id'";
	$ris=mysql_query($delete,$conn) or die("Errore".mysql_error($conn));
}
header("Location: deleteanimale.php");	
?>