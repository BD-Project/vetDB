/*
Query che trova i Clienti che hanno speso il massimo in visite per i loro animali.
*/
DROP VIEW IF EXISTS ClientiCosto;
CREATE VIEW ClientiCosto AS
	SELECT c.Idcliente,p.Nome,p.Cognome,c.email,SUM(tv.costo) AS CostoTot
	FROM (TipoVisite tv JOIN Visite v ON(tv.Id=v.Tipovisita) JOIN Animali a ON(v.animale=a.Idanimale)
		JOIN Clienti c ON(a.Padrone=c.Idcliente) JOIN Persone p ON(p.Idpersona=c.Idcliente))
	WHERE v.Datavisita<CURDATE()
	GROUP BY c.Idcliente
UNION
	SELECT DISTINCT c.Idcliente,p.Nome,p.Cognome,c.email,0 AS CostoTot
	FROM Clienti c JOIN Persone p ON(c.Idcliente=p.Idpersona)
	WHERE c.Idcliente NOT IN(SELECT DISTINCT a.Padrone
							 FROM Animali a)
		  OR NOT EXISTS(SELECT *
						FROM Animali a
						WHERE a.Padrone=c.Idcliente AND 
							  a.Idanimale IN(SELECT v.Animale
											 FROM Visite v));
																		
SELECT *
FROM ClientiCosto cc
WHERE cc.CostoTot=(SELECT MAX(cc1.CostoTot)
				   FROM ClientiCosto cc1)
ORDER BY cc.CostoTot DESC;