<?php
require "Connect.php";
$id=$_POST['id'];
if($id)
{
	$delete="DELETE FROM Visite WHERE Idvisita='$id'";
	$ris=mysql_query($delete,$conn) or die("Errore".mysql_error($conn));
}
header("Location: deletevisita.php");	
?>
