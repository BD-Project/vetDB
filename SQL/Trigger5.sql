/*
Trigger che non permette di prenotare una visita di sterilizzazione, vaccinazione, sverminazione
se l'animale è già sverminato, vaccinato o sterilizzato.
*/
DROP TRIGGER IF EXISTS Visitacorretta;
DELIMITER $
CREATE TRIGGER Visitacorretta
BEFORE INSERT ON Visite
FOR EACH ROW
BEGIN
	DECLARE conta INTEGER;
	DECLARE sver INTEGER;
	DECLARE vacc INTEGER;
	DECLARE ster INTEGER;
	SELECT COUNT(*) INTO sver
	FROM SchedeCliniche s
	WHERE s.Idanimale=NEW.Animale AND s.Sverminato=TRUE;
	SELECT COUNT(*) INTO vacc
	FROM SchedeCliniche s
	WHERE s.Idanimale=NEW.Animale AND s.Vaccinato=TRUE;
	SELECT COUNT(*) INTO ster
	FROM SchedeCliniche s
	WHERE s.Idanimale=NEW.Animale AND s.Sterilizzato=TRUE;
	SELECT COUNT(*) INTO conta
	FROM Visite v 
	WHERE v.Animale=NEW.Animale AND v.Tipovisita=NEW.Tipovisita;
	IF((NEW.Tipovisita=1) AND(vacc>0 OR conta>0))
		OR (NEW.Tipovisita=2 AND (ster>0 OR conta>0))
		OR ((NEW.Tipovisita=3 AND (sver>0 OR conta>0)))
	THEN
		INSERT INTO Errori(Numerrore) VALUES(5);
	END IF;
END$
DELIMITER ;