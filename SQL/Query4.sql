/*
Query che visualizza le 5 razze di animale più diffuse nel database tra animali che hanno effettuato
almeno 2 visite..
*/
SELECT a.Razza, COUNT(*) AS Numanimali
FROM Animali a
WHERE a.Idanimale IN(SELECT a1.Idanimale
					 FROM Animali a1 JOIN Visite v ON(a1.Idanimale=v.Animale)
					 WHERE v.Datavisita<CURDATE()
					 GROUP BY a1.Idanimale
					 HAVING COUNT(*)>=2)
GROUP BY a.Razza
ORDER BY COUNT(*) DESC
LIMIT 5;
