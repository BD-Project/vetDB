/*
Query che trova i clienti che hanno solo gatti o solo cani.
*/
SELECT p.Idpersona,p.Nome,p.Cognome,c.email
FROM Persone p JOIN Clienti c ON(p.Idpersona=c.Idcliente)
WHERE c.Idcliente IN(SELECT DISTINCT(a.Padrone)
					 FROM Animali a)
	AND(c.Idcliente NOT IN(SELECT DISTINCT a.Padrone
						 FROM Animali a
						 WHERE a.Tipoanimale<>'Gatto')
	OR c.Idcliente NOT IN(SELECT DISTINCT a.Padrone
						 FROM Animali a
						 WHERE a.Tipoanimale<>'Cane'));