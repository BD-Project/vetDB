/*
Query che trova i Veterinari che hanno fatto un numero di visite maggiori alla media.
*/
DROP VIEW IF EXISTS Numvisite; 
CREATE VIEW Numvisite AS
	SELECT v.Idveterinario,p.Nome,p.Cognome,COUNT(vv.Idvisita) AS Num
	FROM Persone p JOIN Veterinari v ON(p.Idpersona=v.Idveterinario) NATURAL JOIN VisiteVeterinari vv NATURAL JOIN Visite vis
	WHERE vis.Datavisita<CURDATE()
	GROUP BY v.Idveterinario,p.Nome,p.Cognome
UNION
	SELECT v.Idveterinario,p.Nome,p.Cognome,0 AS Num
	FROM Persone p JOIN Veterinari v ON(p.Idpersona=v.Idveterinario)
	WHERE v.Idveterinario NOT IN(SELECT DISTINCT vv.Idveterinario
								 FROM VisiteVeterinari vv)
	OR v.Idveterinario NOT IN(SELECT DISTINCT vv.Idveterinario
						  FROM Visite v NATURAL JOIN VisiteVeterinari vv
						  WHERE v.Datavisita<CURDATE());
SELECT *
FROM Numvisite n
WHERE n.Num>(SELECT AVG(n1.Num)
			 FROM Numvisite n1)
ORDER BY n.Num DESC;