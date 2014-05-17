/*
Trigger che non permette di inserire un animale con peso minore o uguale a zero.
*/
DROP TRIGGER IF EXISTS Insertanimale;
DELIMITER $
CREATE TRIGGER Insertanimale
BEFORE INSERT ON Animali
FOR EACH ROW
BEGIN
	IF(NEW.Peso<=0)
		THEN
			INSERT INTO Errori(Numerrori) VALUES(4);
		END IF;
END$
DELIMITER ;