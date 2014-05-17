/*
Funzione che verifica se ci sono nuove visite di sterlizzazione da registrare.
*/
DROP FUNCTION IF EXISTS Nuovester;
DELIMITER $
CREATE FUNCTION Nuovester() RETURNS BOOLEAN
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Visite v
	WHERE v.Datavisita<CURDATE() AND v.Tipovisita=2
		  AND v.Animale IN(SELECT s.Idanimale
						   FROM SchedeCliniche s
						   WHERE s.Sterilizzato=FALSE);
	IF(conta!=0)
		THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
	END IF;
END$
DELIMITER ;