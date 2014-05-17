
/*
Trigger che successivamente alla prenotazione di una visita ne assegna automaticamente i veterinari.
Il numero di veterinari assegnati dipende dal tipo di visita.
*/
DROP TRIGGER IF EXISTS Assegnavet;
DELIMITER $
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
DELIMITER ;