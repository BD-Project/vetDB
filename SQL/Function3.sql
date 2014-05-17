/*
Funzione che verifica se un certo veterinario ha una certa specializzazione.
*/
DROP FUNCTION IF EXISTS Haspecializzazione;
DELIMITER $
CREATE FUNCTION Haspecializzazione(Vet INTEGER,Idtipo INTEGER) RETURNS BOOLEAN
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Specializzazioni s
	WHERE s.Idveterinario=Vet AND s.Idtipovisita=Idtipo;
	IF conta>0 
		THEN
		RETURN TRUE;
	ELSE
		RETURN FALSE;
	END IF;
END$
DELIMITER ;