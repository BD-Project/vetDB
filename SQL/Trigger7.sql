/*
Trigger che non permette di modificare il peso di un animale con  un peso minore o uguale a zero.
*/
DROP TRIGGER IF EXISTS Updateanimale;
DELIMITER $
CREATE TRIGGER Updateanimale
BEFORE UPDATE ON Animali
FOR EACH ROW
BEGIN
	IF(NEW.Peso<=0)
		THEN
			INSERT INTO Errori(Numerrori) VALUES(4);
		END IF;
END$
DELIMITER ;