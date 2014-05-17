/*
Trigger che impedisce di modificare lo stipendio di un veterinario se il nuovo valore è negativo o 0.
*/
DROP TRIGGER IF EXISTS Aggiornastipendio;
DELIMITER $
CREATE TRIGGER Aggiornastipendio
BEFORE UPDATE ON Veterinari
FOR EACH ROW
BEGIN
	IF(NEW.Stipendio<=0)
		THEN
			INSERT INTO Errori(Numerrore) VALUES(2);
	END IF;
END$
DELIMITER ;