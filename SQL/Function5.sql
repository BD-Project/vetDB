/*
Funzione che verifica se ci sono nuove visite di vaccinazione da registrare.
*/
DROP FUNCTION IF EXISTS Nuovevacc;
DELIMITER $
CREATE FUNCTION Nuovevacc() RETURNS BOOLEAN
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Visite v
	WHERE v.Datavisita<CURDATE() AND v.Tipovisita=1 
		  AND v.Animale IN(SELECT s.Idanimale
						   FROM SchedeCliniche s
						   WHERE s.Vaccinato=FALSE);
	IF(conta!=0)
		THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
	END IF;
END$
DELIMITER ;