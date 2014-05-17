<?php
require "Connect.php";
$username=$_POST['username'];
$password=SHA1($_POST['password']);
if($username==TRUE && $password==TRUE)
	{	/* se i campi sono entrambi stati compilati */
	$query="SELECT * FROM Account a
		 	WHERE a.Username='$username' AND a.Password='$password' ";
	$risultato=mysql_query($query,$conn) or die("Query fallita" . mysql_error($conn));
	if (mysql_num_rows($risultato)!=1)
		echo "Login o password errati";
	else
		{
			session_start();
			$_SESSION['username']=$username;
			header('Location: index.php');
		}
	}
	else
		echo "Inserie i dati nei campi Usename e password";
?>