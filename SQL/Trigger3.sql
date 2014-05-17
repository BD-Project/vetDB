/*
Trigger che non permette di inserire un veterinario con uno stipendio minore o uguale a 0.
*/
DROP TRIGGER IF EXISTS Newveterinario;
DELIMITER $
CREATE TRIGGER Newveterinario
BEFORE INSERT ON Veterinari
FOR EACH ROW
BEGIN 
	IF(NEW.Stipendio<=0)
		THEN
			INSERT INTO Errori(Numerrore) VALUES (2);
	END IF;
END$
DELIMITER ;