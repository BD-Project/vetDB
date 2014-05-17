<?php
$host="127.0.0.1";
$user="root";
$pwd="mypassword";
$conn=mysql_connect($host, $user, $pwd)or die($_SERVER[’PHP_SELF’] . "connessione fallita");
mysql_select_db("Progettobasi",$conn);
?>