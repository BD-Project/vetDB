/*
Query che trova i Veterinari che vivono nella vittà di Padova ed hanno effettuato almeno 2 Visite
nel giorno del loro compleanno dell'anno corrente.
*/
SELECT v.Idveterinario,p.Nome,p.Cognome,COUNT(*) AS num
FROM Persone p JOIN Veterinari v ON(p.Idpersona=v.Idveterinario) NATURAL JOIN VisiteVeterinari vv NATURAL JOIN Visite vi
WHERE p.Citta='Padova' AND vi.Datavisita<CURDATE() AND(DAY(vi.Datavisita)=DAY(p.DataNasc))
			AND (MONTH(vi.Datavisita)=MONTH(p.DataNasc))
GROUP BY v.Idveterinario,p.Nome,p.Cognome
HAVING COUNT(*)>=2
ORDER BY num DESC;