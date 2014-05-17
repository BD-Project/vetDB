/*
Funzione che ritorna il numero di Veterinari disponibli per un certo tipo di visita in un certo giorno
e orario.
*/
DROP FUNCTION IF EXISTS VetDisponibili;
DELIMITER $
CREATE FUNCTION VetDisponibili(Tipov INTEGER,datav DATE,timev TIME) RETURNS INTEGER
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Veterinari v
	WHERE v.Idveterinario NOT IN(SELECT vv.Idveterinario
								FROM VisiteVeterinari vv)
		   OR v.Idveterinario NOT IN(SELECT vv1.Idveterinario
									 FROM VisiteVeterinari vv1 NATURAL JOIN Visite vi
									 WHERE NOT(vi.Datavisita=datav AND vi.Oravisita=timev));
	RETURN conta;
END$
DELIMITER ;