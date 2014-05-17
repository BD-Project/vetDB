/*
Abilito gli eventi.
*/
SET GLOBAL event_scheduler = ON;
/*
Elimino le tabelle, qualora esistessero già.
*/
DROP TABLE IF EXISTS SchedeCliniche;
DROP TABLE IF EXISTS VisiteVeterinari;
DROP TABLE IF EXISTS Visite;
DROP TABLE IF EXISTS Animali;
DROP TABLE IF EXISTS Specializzazioni;
DROP TABLE IF EXISTS TipoVisite;
DROP TABLE IF EXISTS Veterinari;
DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Clienti;
DROP TABLE IF EXISTS Persone;
DROP TABLE IF EXISTS Errori;
/*
Elimino le viste se esistono.
*/
DROP VIEW IF EXISTS clienticosto;
DROP VIEW IF EXISTS numvisite;
/*
Elimino i trigger e gli eventise esistono.
*/
DROP EVENT IF EXISTS Aggiornascheda;
DROP TRIGGER IF EXISTS CreateScheda;
DROP TRIGGER IF EXISTS Aggiornastipendio;
DROP TRIGGER IF EXISTS Newveterinario;
DROP TRIGGER IF EXISTS Assegnavet;
DROP TRIGGER IF EXISTS Visitacorretta;
DROP TRIGGER IF EXISTS Insertanimale;
DROP TRIGGER IF EXISTS Updateanimale;
/*
Elimino le funzioni se esistono.
*/
DROP FUNCTION IF EXISTS VerificaDisponibile;
DROP FUNCTION IF EXISTS VetDisponibili;
DROP FUNCTION IF EXISTS Haspecializzazione;
DROP FUNCTION IF EXISTS Nuovesverm;
DROP FUNCTION IF EXISTS Nuovevacc;
DROP FUNCTION IF EXISTS Nuovester;
/*
Creo la tabella delle Persone.
*/
CREATE TABLE Persone (
    Idpersona INTEGER PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(15) NOT NULL,
    Cognome VARCHAR(15) NOT NULL,
    DataNasc DATE NOT NULL,
    Citta VARCHAR(20) NOT NULL,
    Sesso CHAR(1) NOT NULL CHECK (Sesso IN ('M' , 'F')),
    Telefono VARCHAR(10) NOT NULL 
)  ENGINE=InnoDB;
/*
Creo la tabella dei Clienti.
*/
CREATE TABLE Clienti (
    Idcliente INTEGER PRIMARY KEY,
    email VARCHAR(32) NOT NULL UNIQUE,
    FOREIGN KEY (Idcliente)
        REFERENCES Persone (IdPersona)
        ON DELETE CASCADE
)  ENGINE=InnoDB;
/*
Creo la tabella degli Account.
*/
CREATE TABLE Account (
    Idcliente INTEGER NOT NULL UNIQUE,
    Username VARCHAR(50) PRIMARY KEY,
    Password VARCHAR(64) NOT NULL,
    FOREIGN KEY (Idcliente)
        REFERENCES Clienti (Idcliente)
        ON DELETE CASCADE
)  ENGINE=InnoDB;
/*
Creo la tabella dei Veterinari.
*/
CREATE TABLE Veterinari (
    Idveterinario INTEGER PRIMARY KEY,
    Stipendio DOUBLE NOT NULL CHECK (Stipendio > 0),
    Dataassunzione DATE NOT NULL,
    FOREIGN KEY (Idveterinario)
        REFERENCES Persone (IdPersona)
        ON DELETE CASCADE
)  ENGINE=InnoDB;
/*
Creo la tabella degli Animali.
*/
CREATE TABLE Animali (
    Idanimale INTEGER PRIMARY KEY AUTO_INCREMENT,
    Padrone INTEGER NOT NULL,
    Nome VARCHAR(15) NOT NULL,
    Peso DOUBLE  NOT NULL CHECK (Peso > 0),
    Coloreocchi VARCHAR(20) NOT NULL,
    Colorepelo VARCHAR(20) NOT NULL,
    Razza VARCHAR(20) NOT NULL,
    Tipoanimale VARCHAR(30) NOT NULL,
	Datanasc DATE NOT NULL,
    Sesso CHAR(1) NOT NULL CHECK (Sesso IN ('M' , 'F')),
    FOREIGN KEY (Padrone)
        REFERENCES Clienti (Idcliente)
        ON DELETE CASCADE
)  ENGINE=InnoDB;
/*
Creo la tabella delle Schede Cliniche.
*/
CREATE TABLE SchedeCliniche (
    Idscheda INTEGER PRIMARY KEY AUTO_INCREMENT,
    Idanimale INTEGER NOT NULL UNIQUE,
    Datacreazione DATE NOT NULL,
    Sverminato BOOLEAN DEFAULT False,
    Vaccinato BOOLEAN DEFAULT False,
    Sterilizzato BOOLEAN DEFAULT FALSE,
    Annotazioni VARCHAR(255) NOT NULL DEFAULT '',
    FOREIGN KEY (Idanimale)
        REFERENCES Animali (Idanimale)
        ON DELETE CASCADE
)  ENGINE=InnoDB;
/*
Creo la tabella TipoVisita.
*/
CREATE TABLE TipoVisite (
    Id INTEGER AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(25) UNIQUE NOT NULL,
    Costo DOUBLE NOT NULL CHECK (Costo > 0),
	Vetnecessari INTEGER NOT NULL CHECK(Vetnecessari>0) 
)  ENGINE=InnoDB;
/*
Creo la tabella delle visite.
*/
CREATE TABLE Visite (
    Idvisita INTEGER PRIMARY KEY AUTO_INCREMENT,
    Tipovisita INTEGER NOT NULL,
    Datavisita DATE NOT NULL,
    Oravisita TIME NOT NULL,
    Animale INTEGER NOT NULL,
    FOREIGN KEY (Tipovisita)
        REFERENCES TipoVisite (Id)
        ON DELETE CASCADE,
    FOREIGN KEY (Animale)
        REFERENCES Animali (idAnimale)
        ON DELETE CASCADE
)  ENGINE=InnoDB;
/*
Creo la tabella Specializzazioni*/
CREATE TABLE Specializzazioni (
    Idveterinario INTEGER,
    Idtipovisita INTEGER,
    PRIMARY KEY (Idveterinario , Idtipovisita),
    FOREIGN KEY (Idveterinario)
        REFERENCES Veterinari (Idveterinario)
        ON DELETE CASCADE,
    FOREIGN KEY (Idtipovisita)
        REFERENCES TipoVisite (Id)
        ON DELETE CASCADE
)  ENGINE=InnoDB;
/*
Creo la tabella VisiteVeterinari.
*/
CREATE TABLE VisiteVeterinari (
    Idvisita INTEGER,
    Idveterinario INTEGER,
    PRIMARY KEY (Idveterinario ,Idvisita),
    FOREIGN KEY (Idveterinario) REFERENCES Veterinari (Idveterinario)
        ON DELETE CASCADE,
    FOREIGN KEY (Idvisita)
        REFERENCES Visite (Idvisita)
        ON DELETE CASCADE
)ENGINE=InnoDB;
/*
Creo la tabella degli errori.
*/
CREATE TABLE Errori (
    Numerrore INTEGER PRIMARY KEY,
    Descrizione VARCHAR(50)
)  ENGINE=InnoDB;
/*
Creo le viste.
*/
/*
Creo la vista Numvisite.
*/
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
/*
Creo la vista  ClientiCosto.
*/
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
/*
Imposto il delimiter per trigger, eventi e funzioni.
*/
DELIMITER $
/*
Creo le funzioni.
*/
/*
Creo la funzione VerificaDisponibile.
*/
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
/*
Creo la funzione VetDisponibili.
*/
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
/*
Creo la funzione Haspecializzazione.
*/
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
/*
Creo la funzione Nuovesverm.
*/
CREATE FUNCTION Nuovesverm() RETURNS BOOLEAN
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Visite v
	WHERE v.Datavisita<CURDATE() AND v.Tipovisita=3 
		  AND v.Animale IN(SELECT s.Idanimale
						   FROM SchedeCliniche s
						   WHERE s.Sverminato=FALSE);
	IF(conta!=0)
		THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
	END IF;
END$
/*
Creo la funzione Nuovevacc.
*/
CREATE FUNCTION Nuovevacc() RETURNS BOOLEAN
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Visite v
	WHERE v.Datavisita<CURDATE() AND v.Tipovisita=1 
		  AND v.Animale IN(SELECT s.Idanimale
						   FROM SchedeCliniche s
						   WHERE s.Vaccinato=FALSE);
	IF(conta!=0)
		THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
	END IF;
END$
/*
Creo la funzione Nuovester.
*/
CREATE FUNCTION Nuovester() RETURNS BOOLEAN
BEGIN
	DECLARE conta INTEGER;
	SELECT COUNT(*) INTO conta
	FROM Visite v
	WHERE v.Datavisita<CURDATE() AND v.Tipovisita=2
		  AND v.Animale IN(SELECT s.Idanimale
						   FROM SchedeCliniche s
						   WHERE s.Sterilizzato=FALSE);
	IF(conta!=0)
		THEN
			RETURN TRUE;
		ELSE
			RETURN FALSE;
	END IF;
END$
/*
Creo i trigger e gli eventi.
*/
/*
Creo il trigger CreateScheda.
*/
CREATE TRIGGER CreateScheda
AFTER INSERT ON Animali
FOR EACH ROW
BEGIN
	INSERT INTO SchedeCliniche(Idanimale, Datacreazione,Sverminato,Vaccinato,Sterilizzato,Annotazioni)
	VALUES(NEW.Idanimale,CURDATE(),FALSE,FALSE,FALSE,"");
END$
/*
Creo il trigger Aggiornastipendio.
*/
CREATE TRIGGER Aggiornastipendio
BEFORE UPDATE ON Veterinari
FOR EACH ROW
BEGIN
	IF(NEW.Stipendio<=0)
		THEN
			INSERT INTO Errori(Numerrore) VALUES(2);
	END IF;
END$
/*
Creo il trigger Newveterinario.
*/
CREATE TRIGGER Newveterinario
BEFORE INSERT ON Veterinari
FOR EACH ROW
BEGIN 
	IF(NEW.Stipendio<=0)
		THEN
			INSERT INTO Errori(Numerrore) VALUES (2);
	END IF;
END$
/*
Creo il trigger Assegnavet.
*/
CREATE TRIGGER Assegnavet
AFTER INSERT ON Visite
FOR EACH ROW
BEGIN
		DECLARE Nec INTEGER;
		SELECT tv.Vetnecessari INTO Nec
		FROM Tipovisite tv
		WHERE tv.Id=NEW.Tipovisita;
		IF (VetDisponibili(NEW.Tipovisita,NEW.Datavisita,NEW.Oravisita))>=Nec
		THEN
			IF Nec=1
			THEN
			INSERT INTO VisiteVeterinari
			SELECT NEW.Idvisita AS Idvisita, nv.Idveterinario AS Idveterinario
			FROM Numvisite nv
			WHERE VerificaDisponibile(nv.Idveterinario,NEW.Datavisita,NEW.Oravisita) 	
				  AND Haspecializzazione(nv.Idveterinario,NEW.Tipovisita)
			ORDER BY nv.Num ASC
			LIMIT 1;
			ELSEIF Nec=2
				THEN
				INSERT INTO VisiteVeterinari
				SELECT NEW.Idvisita AS Idvisita, nv.Idveterinario AS Idveterinario
				FROM Numvisite nv
				WHERE VerificaDisponibile(nv.Idveterinario,NEW.Datavisita,NEW.Oravisita) 	
				  AND Haspecializzazione(nv.Idveterinario,NEW.Tipovisita)
				ORDER BY nv.Num ASC
				LIMIT 2;
			ELSEIF Nec=3
				THEN
				INSERT INTO VisiteVeterinari
				SELECT NEW.Idvisita AS Idvisita, nv.Idveterinario AS Idveterinario
				FROM Numvisite nv
				WHERE VerificaDisponibile(nv.Idveterinario,NEW.Datavisita,NEW.Oravisita) 	
				  AND Haspecializzazione(nv.Idveterinario,NEW.Tipovisita)
				ORDER BY nv.Num ASC
				LIMIT 3;
			END IF;
		ELSE
			DELETE FROM Visite
			WHERE Idvisita=NEW.Idvisita;
		END IF;
END$
/*
Creo il triggetr Visitacorretta.
*/
CREATE TRIGGER Visitacorretta
BEFORE INSERT ON Visite
FOR EACH ROW
BEGIN
	DECLARE conta INTEGER;
	DECLARE sver INTEGER;
	DECLARE vacc INTEGER;
	DECLARE ster INTEGER;
	SELECT COUNT(*) INTO sver
	FROM SchedeCliniche s
	WHERE s.Idanimale=NEW.Animale AND s.Sverminato=TRUE;
	SELECT COUNT(*) INTO vacc
	FROM SchedeCliniche s
	WHERE s.Idanimale=NEW.Animale AND s.Vaccinato=TRUE;
	SELECT COUNT(*) INTO ster
	FROM SchedeCliniche s
	WHERE s.Idanimale=NEW.Animale AND s.Sterilizzato=TRUE;
	SELECT COUNT(*) INTO conta
	FROM Visite v 
	WHERE v.Animale=NEW.Animale AND v.Tipovisita=NEW.Tipovisita;
	IF((NEW.Tipovisita=1) AND(vacc>0 OR conta>0))
		OR (NEW.Tipovisita=2 AND (ster>0 OR conta>0))
		OR ((NEW.Tipovisita=3 AND (sver>0 OR conta>0)))
	THEN
		INSERT INTO Errori(Numerrore) VALUES(5);
	END IF;
END$
/*
Creo il trigger Insertanimale.
*/
CREATE TRIGGER Insertanimale
BEFORE INSERT ON Animali
FOR EACH ROW
BEGIN
	IF(NEW.Peso<=0)
		THEN
			INSERT INTO Errori(Numerrori) VALUES(4);
		END IF;
END$
/*
Creo il trigger Updateanimale.
*/
CREATE TRIGGER Updateanimale
BEFORE UPDATE ON Animali
FOR EACH ROW
BEGIN
	IF(NEW.Peso<=0)
		THEN
			INSERT INTO Errori(Numerrori) VALUES(4);
		END IF;
END$
/*
Creo l'evento Aggiornascheda.
*/
CREATE EVENT Aggiornascheda
ON SCHEDULE  EVERY 1 SECOND
DO
	BEGIN
		IF Nuovesverm()
			THEN
				UPDATE SchedeCliniche 
				SET Sverminato=TRUE
				WHERE Idanimale IN(SELECT v.Animale
								   FROM Visite v
								   WHERE v.Datavisita<CURDATE() AND v.Tipovisita=3)
					AND Sverminato=FALSE;
			END IF;
		IF Nuovester()
			THEN
				UPDATE SchedeCliniche 
				SET Sterilizzato=TRUE
				WHERE Idanimale IN(SELECT v.Animale
								   FROM Visite v
								   WHERE v.Datavisita<CURDATE() AND v.Tipovisita=2)
					AND Sterilizzato=FALSE;
			END IF;
		IF Nuovevacc()
			THEN
				UPDATE SchedeCliniche 
				SET Vaccinato=TRUE
				WHERE Idanimale IN(SELECT v.Animale
								   FROM Visite v
								   WHERE v.Datavisita<CURDATE() AND v.Tipovisita=1)
					  AND Vaccinato=FALSE;
			END IF;
	END$
/*
Reimposto il delimiter
*/
DELIMITER ;
/*
Popolo le tabelle.
*/
/*
Popolo la tabella degli Errori.
*/

INSERT INTO Errori(Numerrore,Descrizione)
	VALUES(1,'Data di visita non valida'),
		  (2,'Stipendio negativo'),
	      (3,'Modifica non corretta della schedaclinica'),
		  (4,'Peso animale non corretto'),
		  (5,'Visita non corretta');
/*
Popolo la tabella delle Persone.
*/
INSERT INTO Persone(Nome,Cognome,DataNasc,Citta,Sesso,Telefono)
	VALUES('Giorgio','Rossi','1990-05-21','Treviso','M','0423345678'),
		  ('Mario','Rossi','1992-03-11','Padova','M','0426542367'),
		  ('Beatrice','Bianchi','1980-02-01','Vicenza','F','0678654329'),
		  ('Marco','Marchetti','1970-03-11','Verona','M','0432145789'),
		  ('Marta','Basso','1985-02-14','Treviso','F','6543214678'),
		  ('Mario','Berton','1980-01-16','Padova','M','0987654321'),
		  ('Silvia','Minti','1950-07-15','Vicenza','F','0976432568'),
		  ('Mario','Lani','1988-02-16','Treviso','M','2358976511'),
		  ('Lucia','Forti','1986-09-19','Padova','F','0238749385'),
		  ('Luca','Adami','1992-03-18','Padova','M','8372930483'),
		  ('Tiziana','Chiari','1991-04-11','Vicenza','F','3987456732'),
		  ('Chiara','Scuri','1990-02-14','Vicenza','F','3457890987'),
		  ('Morris','Binotto','1980-08-19','Padova','M','1230938200'),
		  ('Antonio','Mazzocato','1970-09-23','Padova','M','1230986547'),
		  ('Luisa','Vieri','1975-01-12','Treviso','F','9984326781'),
		  ('Antonio','Verdi','1992-12-23','Montebelluna','M','0427898765'),
		  ('Giorgio','Sacchi','1982-02-15','Venezia','M','0426545667'),
		  ('Beatrice','Piazza','1991-03-04','Treviso','F','3987654568'),
		  ('Federico','Marrone','1982-05-16','Volpago','M','0357976345'),
		  ('Marta','Feltri','1988-04-17','Maser','F','0567834509'),
		  ('Mario','Bello','1983-04-16','Istrana','M','0984578900'),
		  ('Silvia','Pellico','1970-09-17','Vicenza','F','0986745678'),
		  ('Fulvio','Arsi','1982-03-14','Padova','M','0987654567'),
		  ('Lucia','Basso','1982-03-14','Caerano','F','0238747389'),
		  ('Luca','Adami','1992-03-18','Padova','M','0987890987'),
		  ('Tiziana','Scuri','1992-04-11','Venezia','F','0987678909'),
		  ('Chiara','Bianchi','1990-02-14','Caerano','F','1235987678'),
		  ('Morris','Tessaro','1983-08-19','Fanzolo','M','0987678903'),
		  ('Antonio','Ferri','1973-09-23','Castelfranco','M','2350985467'),
		  ('Luisa','Verdi','1985-02-22','Montebelluna','F','3345698777'),
		  ('Giorgio','Sereni','1970-05-21','Caerano','M','3309568453'),
		  ('Luigi','Bianchi','1972-02-21','Padova','M','3567893456'),
		  ('Beatrice','Servita','1982-02-01','Venezia','F','7654567890'),
		  ('Luigi','Marchesini','1973-04-15','Verona','M','1234906578'),
		  ('Silvia','Bessegato','1987-02-15','Caerano','F','3456789023'),
		  ('Antonio','Berton','1980-01-16','Padova','M','0987675646'),
		  ('Silvia','Bersi','1950-07-15','Vicenza','F','0976422368'),
		  ('Mario','Tessariol','1988-02-16','Treviso','M','2353976211'),
		  ('Lucia','Berini','1986-09-19','Padova','F','0238749388'),
		  ('Luca','Fortlan','1992-04-16','Treviso','M','8322934483'),
		  ('Tiziana','Forte','1960-02-14','Caerano','F','0987256752'),
		  ('Tiziana','Seri','1992-05-14','Venezia','F','3452896987'),
		  ('Antonio','Borsi','1982-04-15','Caerano','M','336789067'),
		  ('Federico','Mazzobel','1973-05-22','Padova','M','335987654'),
		  ('Luisa','Verdi','1985-02-12','Istrana','F','356789087'),
		  ('Gino','Sordi','1990-12-21','Castelfranco','M','0423335628'),
		  ('Luigi','Rossani','1992-04-11','Venezia','M','0987656789'),
		  ('Beatrice','Girti','1982-04-05','Vicenza','F','0672654425'),
		  ('Marco','Montagner','1973-04-15','Verona','M','0987678904'),
		  ('Maria','Alti','1983-04-15','Venezia','F','356789034'),
		  ('Luigi','Berton','1980-01-16','Treviso','M','0987624334'),
		  ('Anna','Bersi','1955-06-16','Verona','F','0972434565'),
		  ('Antonio','Mordente','1978-12-14','Istrana','M','367890345'),
		  ('Deborah','Forsi','1986-09-19','Padova','F','0238448385'),
		  ('Antonio','Adami','1992-03-18','Padova','M','3390987654'),
		  ('Tiziana','Antico','1991-07-19','Venezia','F','0987456732'),
		  ('Chiara','Feltrin','1993-04-15','Castelfranco','F','3427894987'),
		  ('Morris','Tessariol','1982-04-12','Padova','M','3390651894'),
		  ('Antonio','Mazzobel','1972-04-23','Istrana','M','3408645789'),
		  ('Lucia','Vetri','1978-05-11','Montebelluna','F','3423456700');

/*
Popolo la tabella dei Clienti.
*/
INSERT INTO Clienti(Idcliente,email)
	VALUES(1,'giorgio@gmail.com'),
		  (6,'berton1@libero.it'),
		  (9,'lucia.forti.2@libero.it'),
	      (10,'adami1@hotmail.it'),
	      (4,'marchetti@live.com'),	  
		  (11,'tizichiari@gmail.com'),
		  (12,'scurichia@libero.it'),
		  (13,'morrs1@libero.it'),
	      (14,'anonymazz@hotmail.it'),
	      (15,'vieriluisa@live.com'),
		  (16,'verdi.antonio@gmail.com'),
		  (17,'thegiorio.1@libero.it'),
		  (18,'beatrixplatz@libero.it'),
	      (19,'marrone.fede@hotmail.it'),
	      (20,'marta.5@live.com'),
		  (21,'bellom@gmail.com'),
		  (22,'pellico1@libero.it'),
		  (23,'fulvio2@libero.it'),
	      (24,'bassoluca@hotmail.it'),
	      (25,'Scurichiara@live.com'),
		  (26,'scurtiz2@gmail.com'),
		  (27,'bianchi3@libero.it'),
		  (28,'texmorris@libero.it'),
	      (29,'ferriantony@hotmail.it'),
	      (30,'verdiluisa@live.com');
/*
Popolo la tabella degli Account.
*/
INSERT INTO Account(Idcliente,Username,Password)
	VALUES(1,'Giorgio1',SHA1('provapke')),
		  (6,'bertonmario',SHA1('password')),
		  (4,'themarchetti',SHA1('password')),
		  (9,'luciaforti',SHA1('passpass')),
		  (10,'adams',SHA1('passmore')),
		  (11,'Thechiari',SHA1('password')),
		  (12,'Scurichia',SHA1('67890987')),
		  (13,'morrs1',SHA1('sdrtyuol')),
	      (14,'Themazzo',SHA1('Dlourftr')),
	      (15,'Lalu',SHA1('asu875rf')),
		  (16,'verdi',SHA1('hjioptrf')),
		  (17,'thegiorio.1',SHA1('34drtiol')),
		  (18,'beatrixplatz',SHA1('fredsòè9')),
	      (19,'Themarrone',SHA1('gtyuiopl')),
	      (20,'martina',SHA1('los34670')),
		  (21,'silvietta',SHA1('hyfr4567')),
		  (22,'pellico1',SHA1('password')),
		  (23,'arsi',SHA1('k8uy6547')),
	      (24,'lucathebasso',SHA1('loiut567')),
	      (25,'darkchiara',SHA1('juiop456')),
		  (26,'tizi',SHA1('tiziana2')),
		  (27,'white11',SHA1('jdoemcoe')),
		  (28,'Texmex',SHA1('textexme')),
	      (29,'Theferri',SHA1('frtyiopl')),
	      (30,'luverdi',SHA1('juioprty'));
/*
Popolo la tabella dei veterinari.
*/
INSERT INTO Veterinari(Idveterinario,Stipendio,Dataassunzione)
	VALUES(2,1000,'2013-04-04'),
		  (3,1500,'2013-04-04'),
		  (5,1570,'2013-05-07'),
		  (7,3100,'2013-09-09'),
		  (8,900,'2013-03-05'),
		  (31,1030,'2013-02-15'),
		  (32,1540,'2013-03-17'),
		  (33,2540.50,'2013-04-23'),	
		  (34,1560,'2013-04-20'),
		  (35,3400,'2013-05-07'),
		  (36,1900,'2013-02-10'),
		  (37,1600,'2013-01-15'),
	      (38,1200,'2013-04-21'),
		  (39,1300,'2013-04-16'),
		  (40,2440.50,'2013-03-15'),	
		  (41,1560,'2013-02-17'),
		  (42,3120,'2013-03-21'),
		  (43,1900,'2013-03-24'),
		  (44,1600,'2013-03-01'),
		  (45,1300,'2013-04-16'),
		  (46,1540.50,'2013-03-14'),	
		  (47,1230,'2013-04-12'),
		  (48,1140,'2013-04-15'),
		  (49,2300,'2013-05-02'),
		  (50,5600,'2013-03-02'),
		  (51,13000,'2013-03-05'),
		  (52,1550,'2013-04-12'),
		  (53,2540.50,'2013-05-16'),	
		  (54,1370,'2013-04-18'),
		  (55,3300,'2013-04-13'),
		  (56,920,'2013-05-15'),
		  (57,1600,'2013-05-03'),
		  (58,1200,'2013-04-05'),
		  (59,1100,'2013-04-08'),
		  (60,2340.50,'2013-03-17');
/*
Popolo la tabella degli animali.
*/
INSERT INTO Animali(Nome,Padrone,Peso,Coloreocchi,Colorepelo,Razza,Tipoanimale,Sesso,Datanasc)
	VALUES('Speedy',1,9,'Verdi','Tigrato grigio','Meticcio','Gatto','M','2013-02-02'),
		  ('Garfield',1,11,'Gialli','Tigrato rosso','Persiano','Gatto','M','2013-01-03'),
		  ('Macchia',6,3.5,'Verdi','Macchie bianco nere','Meticcio','Gatto','F','2013-02-09'),
		  ('Toby',6,4,'Azzurri','blu-point','Sacro di birmania','Gatto','M','2013-03-02'),
		  ('Roxie',9,9.6,'Gialli','Beige','Carlino','Cane','F','2013-03-04'),
		  ('Balto',9,38.2,'Verdi','Bianco','Husky','Cane','M','2013-02-18'),
		  ('Tommy',10,7,'Gialli','Nero','Bassotto','Cane','M','2012-09-12'),
		  ('Baghera',10,6.3,'Gialli','Nero','Meticcio','Gatto','F','2013-01-02'),
		  ('Bongo',4,28.1,'Verdi','Rosso','Alano','Cane','F','2013-03-02'),
		  ('Lucky',4,80,'Gialli','Nero e bianco','Terranova','Cane','F','2013-02-22'),
		  ('Sophie',1,3.2,'Verdi','Bianco','British Shortair','Gatto','F','2013-03-02'),
		  ('Baloo',6,6.8,'Verdi','Grigio','Persiano Chincilla','Gatto','M','2013-02-12'),
		  ('Chily',9,3.1,'Azzurri','Rosso','Siamese','Gatto','F','2013-03-06'),
		  ('Brownie',10,13,'Verde','Marrone','Bigol','Cane','F','2013-02-12'),
		  ('Cremino',4,8.2,'Blu','Grigio','Zversnauzer','Cane','M','2011-03-04'),
		  ('Bilbo',1,5.9,'Azzurri','Bianco','Meticcio','Gatto','M','2012-03-08'),
		  ('Gingi',30,1.9,'Verdi','Rosso ','Meticcio','Gatto','F','2013-04-01');
/*
Popolo la tabela TipoVisite.
*/
INSERT INTO TipoVisite(Nome,Costo,Vetnecessari)
	VALUES('Vaccino',20,1),
		  ('Sterilizzazione',120,2),
		  ('Sverminazione',15,1),
		  ('Intervento',255,3),
	      ('Controllo',15,1),
		  ('Visita oculistica',30,1);
/*
Popolo la tabella Specializzazioni.
*/
INSERT INTO Specializzazioni(Idveterinario,Idtipovisita)
	VALUES(2,1),
		  (2,3),
		  (2,2),
		  (2,4),
		  (2,5),
		  (2,6),
		  (3,4),
		  (5,1),
		  (7,2),
		  (7,3),
		  (8,1),
		  (8,3),
		  (8,5),
		  (31,1),
		  (31,2),
		  (31,3),
		  (31,4),
		  (31,5),
		  (31,6),
		  (32,3),
		  (33,1),
		  (33,3),
		  (33,5),
		  (34,1),
		  (34,3),
		  (34,4),
		  (35,1),
		  (36,2),
		  (36,1),
		  (37,3),
		  (38,1),
		  (38,3),
		  (39,5),
	      (39,1),
		  (40,2),
		  (41,3),
		  (41,4),
		  (42,1),
		  (42,3),
		  (43,1),
		  (43,3),
		  (44,1),
		  (45,2),
		  (46,5),
		  (47,6),
		  (48,3),
		  (48,1),
		  (48,2),
		  (48,4),
		  (49,6),
		  (50,1),
		  (50,3),
		  (51,3),
		  (52,4),
		  (53,1),
		  (53,2),
		  (54,1),
		  (54,3),
		  (55,1),
		  (55,3),
		  (56,5),
		  (56,6),
		  (57,3),
		  (58,4),
		  (59,1),
		  (59,2),
		  (59,3),
		  (59,4),
		  (59,6),
		  (60,1),
		  (60,3),
		  (60,4),
		  (60,5),
		  (60,6);
/*
Popolo la tabella delle Visite.
*/
INSERT INTO Visite(Tipovisita,Datavisita,Oravisita,Animale)
	VALUES(1,'1992-03-11','15:00:00',7),
		  (6,'1992-03-11','17:00:00',7),
		  (1,'1992-03-11','15:30:00',2),
		  (6,'1992-03-11','17:30:00',4),
		  (1,'1992-03-11','14:00:00',8),
		  (6,'1992-03-11','18:00:00',9),
		  (1,'1992-03-11','19:30:00',10),
		  (4,'1992-03-11','13:00:00',14),
		  (4,'1992-03-11','15:00:00',13),
		  (5,'1992-03-11','17:30:00',12),
		  (6,'1992-03-11','16:30:00',10),
		  (6,'1992-03-11','09:00:00',11),
		  (4,'1992-03-11','19:00:00',10),
		  (4,'1992-03-11','14:30:00',6),
		  (5,'1992-03-11','13:30:00',7),
		  (6,'1992-03-11','12:30:00',8),
		  (6,'1992-03-11','11:00:00',9),
		  (1,'2013-04-10','15:00:00',1),
		  (5,'2013-04-16','16:30:00',2),
		  (4,'2013-05-17','11:30:00',3),
		  (2,'2013-05-21','17:30:00',4),
		  (4,'2013-05-11','19:30:00',5),
		  (4,'2013-03-26','18:00:00',9),
		  (1,'2013-03-13','15:30:00',3),
		  (2,'2013-04-24','16:30:00',6),
		  (3,'2013-05-18','8:30:00',11),
		  (3,'2013-05-20','17:30:00',9),
		  (3,'2013-05-25','15:00:00',5),
		  (5,'2013-05-16','16:30:00',16),
		  (4,'2013-05-18','11:30:00',15),
		  (2,'2013-04-21','17:30:00',13),
		  (4,'2013-04-11','19:00:00',1),
		  (4,'2013-04-26','18:00:00',9),
		  (3,'2013-05-18','10:30:00',10),
		  (4,'2013-04-10','15:00:00',4),
		  (4,'2013-04-16','16:30:00',10),
		  (5,'2013-05-17','11:30:00',3),
		  (5,'2013-05-21','17:30:00',4),
		  (6,'2013-05-11','19:30:00',5),
		  (6,'2013-03-26','18:00:00',9),
		  (5,'2013-03-13','15:30:00',3),
		  (6,'2013-05-13','14:30:00',13),
		  (6,'2013-07-13','14:30:00',7),
		  (4,'2013-09-17','16:30:00',1),
		  (6,'2013-03-11','19:30:00',4),
		  (6,'2013-07-25','18:00:00',9),
		  (5,'2013-05-16','15:30:00',3),
		  (5,'2013-04-15','15:30:00',12),
		  (6,'2013-04-17','14:30:00',12),
		  (4,'2013-05-16','16:30:00',1),
		  (2,'2013-05-10','16:30:00',17);