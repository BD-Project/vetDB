/*
Funzione che verifica se un certo veterinario è disponibile in una certa data, ossia se in quella
data non ha altre visite in programma;
*/
DROP FUNCTION IF EXISTS VerificaDisponibile;
DELIMITER $
CREATE FUNCTION VerificaDisponibile(Vet INTEGER,datav DATE,orav TIME) RETURNS BOOLEAN
BEGIN
	DECLARE num INTEGER;
	SELECT COUNT(*) INTO num 
	FROM Veterinari v 
	WHERE v.Idveterinario=Vet AND (Idveterinario NOT IN (SELECT vv.Idveterinario
														 FROM VisiteVeterinari vv)
		  OR v.Idveterinario NOT IN(SELECT vv.Idveterinario
									FROM VisiteVeterinari vv NATURAL JOIN Visite vi
									WHERE vi.Datavisita=datav AND vi.Oravisita=orav));
	IF(num!=0)
		THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
	END IF;
END$
DELIMITER ;