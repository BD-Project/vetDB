/*
Query che visuallizza  i clienti i cui animali hanno tutti effettuato solo visite con costo superiore a 20 euro.*/
SELECT c.Idcliente,p.Nome,p.Cognome,c.email
FROM Clienti c JOIN Persone p ON(c.Idcliente=p.Idpersona)
WHERE NOT EXISTS(SELECT *
				 FROM TipoVisite tv JOIN Visite v ON(tv.Id=v.Tipovisita) 
				 JOIN Animali a ON(a.Idanimale=v.Animale)
				 WHERE a.Padrone=c.Idcliente AND tv.Costo<=20 AND v.Datavisita<CURDATE())
		AND c.Idcliente IN(SELECT a.Padrone
					       FROM Animali a);