/*
Evento che registra nella scheda clinica degli animali le sverminazione, vaccini e sterilizzazioni
degli animali.
*/
DROP EVENT IF EXISTS Aggiornascheda;
DELIMITER $
CREATE EVENT Aggiornascheda
ON SCHEDULE  EVERY 1 DAY
DO
	BEGIN
		IF Nuovesverm()
			THEN
				UPDATE SchedeCliniche 
				SET Sverminato=TRUE
				WHERE Idanimale IN(SELECT v.Animale
								   FROM Visite v
								   WHERE v.Datavisita<CURDATE() AND v.Tipovisita=3)
					AND Sverminato=FALSE;
			END IF;
		IF Nuovester()
			THEN
				UPDATE SchedeCliniche 
				SET Sterilizzato=TRUE
				WHERE Idanimale IN(SELECT v.Animale
								   FROM Visite v
								   WHERE v.Datavisita<CURDATE() AND v.Tipovisita=2)
					AND Sterilizzato=FALSE;
			END IF;
		IF Nuovevacc()
			THEN
				UPDATE SchedeCliniche 
				SET Vaccinato=TRUE
				WHERE Idanimale IN(SELECT v.Animale
								   FROM Visite v
								   WHERE v.Datavisita<CURDATE() AND v.Tipovisita=1)
					  AND Vaccinato=FALSE;
			END IF;
	END$