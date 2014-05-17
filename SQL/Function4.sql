/*
Funzione che verifica se ci sono nuove visite di sverminazione da registrare.
*/
DROP FUNCTION IF EXISTS Nuovesverm;
DELIMITER $
CREATE FUNCTION Nuovesverm() RETURNS BOOLEAN
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Visite v
	WHERE v.Datavisita<CURDATE() AND v.Tipovisita=3 
		  AND v.Animale IN(SELECT s.Idanimale
						   FROM SchedeCliniche s
						   WHERE s.Sverminato=FALSE);
	IF(conta!=0)
		THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
	END IF;
END$
DELIMITER ;