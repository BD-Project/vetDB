<?php
require "Utility.php";
page_start("Registrati");
echo "<h1>Pagina di registrazione</h1>";
echo<<<END
	<form action="Registrer.php" method="POST">
	<fieldset>
	<legend>Registrati</legend>
		<label for="nome">Nome:</label>
		<input type="text" name="nome"><br>
		<label for="cognome">Cognome:</label>
		<input type="text" name="cognome"</label><br>
		<label for="sesso">Sesso:</label>
		<select name="sesso">
			<option>M</option>
			<option>F</option>
		</select><br>
		<label for="citta">Citt&agrave:</label>
		<input type="text" name="citta"><br>
		Data di nascita:
		<label for="giorno">
		<select name="giorno">
END;
				for($i=1;$i<=31;$i++)
					echo '<option value="'.$i.'" >'.$i.'</option>'; 
		echo<<<END
		</select>
		<label for="mese">Mese</label>
		<select name="mese">
END;
				for($i=1;$i<=12;$i++)
					echo '<option  value="'.$i.'" >'.$i.'</option>'; 
		echo<<<END
		</select>
		<label for="anno">Anno</label>
		<select name="anno">
END;
				for($i=date("Y");$i>=1920;$i--)
					echo '<option  value="'.$i.'" >'.$i.'</option>'; 
		echo<<<END
		</select><br>
		<label for="tel">Telefono:</label>
		<input type="text" name="tel"><br>
		<label for="email">E-mail:</label>
		<input type="text" name="email"><br>
		<label for="username">Username:</label>
		<input type="text" name="username"><br>
		<label for="password">Password:</label>
		<input type="password" name="password" maxlength="8"><br>
		<label for="cpassword">Conferma password:</label>
		<input type="password" name="cpassword" maxlength="8"><br>
		<input type="submit" value="Registrati"><br>
	</fieldset>
	</form>
<p>
<a href="Login.php">Clicca qui</a>
se sei gi&agrave registrato</p>
END;
page_end();
?>