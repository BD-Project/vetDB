<?php
	session_start();
	require "Connect.php";
	require "Utility.php";
	page_start("Elimina visita");
	$username=$_SESSION['username'];
	if(!isset($username))
		echo "Accesso negato";
	else
		{
			
			$query="SELECT v.Idvisita,a.Idanimale,tv.Nome,tv.Costo,v.Datavisita  FROM TipoVisite tv JOIN Visite v ON(tv.Id=v.Tipovisita) JOIN Animali a 			ON(v.Animale=a.Idanimale) JOIN Account ac 	ON(a.Padrone=ac.Idcliente) WHERE ac.Username='$username'AND v.Datavisita>CURDATE() ORDER BY v.Idvisita ASC";
			$ris=mysql_query($query,$conn) or die("Query fallita".mysql_error($conn));
			if(!mysql_num_rows($ris))
				echo "Non c'&egrave nessuna visita da eliminare";
			else
			{
				echo "<h1>Sciegli una visita da eliminare</h1>";
				echo "<form action='deletev.php' method='post'>";
				$headers=array("Idvisita","Idanimale","Tipovisita","Costo","Data visita");
				table_start($headers);
				while($row = mysql_fetch_array($ris))
				  {
				  $id=$row['Idvisita'];
				  $animale=$row['Idanimale'];
				  $tipovisita=$row['Nome'];
				  $costo=$row['Costo'];
				  $data=$row['Datavisita'];
				  echo<<<END
				  <tr>
				  <td><input type='radio'name='id' value='$id'></td>
				  <td><input type='text' name='idanimale' value='$animale'></td>
				  <td><input type='text' name='tipovisita' value='$tipovisita'></td>
				  <td><input type='text' name='costo' value='$costo'></td>
				  <td><input type='text' name='datavisita' value='$data'></td>
				  </tr>
END;
			     }
				 table_end();
				 echo<<<END
				 <br/><input type='submit' value='Delete'/>
				 </form>
END;
			}
			echo<<<END
				<p>
			<a href="indexvisite.php">Clicca qui</a> per tornare all'indice
			</p>
END;
		}	
page_end();	
	?>