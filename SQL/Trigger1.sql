/*
Trigger che dopo aver inserito un animale ne crea una corrispondente scheda clinica.
*/
DROP TRIGGER IF EXISTS CreateScheda;
DELIMITER $
CREATE TRIGGER CreateScheda
AFTER INSERT ON Animali
FOR EACH ROW
BEGIN
	INSERT INTO SchedeCliniche(Idanimale, Datacreazione,Sverminato,Vaccinato,Sterilizzato,Annotazioni)
	VALUES(NEW.Idanimale,CURDATE(),FALSE,FALSE,FALSE,"");
END$
DELIMITER ;
