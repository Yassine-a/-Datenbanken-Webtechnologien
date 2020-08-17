DELIMITER //
DROP PROCEDURE IF EXISTS f;
CREATE PROCEDURE f(IN cat INT,IN Avail INT, IN Lim INT)
BEGIN

	IF cat = -1 AND Avail= 0 THEN 
    SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten FROM Mahlzeiten
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID LIMIT Lim;
				
	ELSEIF cat > -1 AND Avail = 0 THEN
	SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten FROM Mahlzeiten
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID WHERE Mahlzeiten.Kategorie_ID = cat LIMIT Lim;
				
	ELSEIF cat = -1 AND Avail = 1 THEN
	SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten FROM Mahlzeiten
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID WHERE Mahlzeiten.Verfuegbar= 1 LIMIT Lim;
	ELSE
	SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten FROM Mahlzeiten
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID 
				WHERE Mahlzeiten.Verfuegbar= 1 AND Mahlzeiten.Kategorie_ID = cat LIMIT Lim;
	END IF;
	
END; //

DELIMITER ;

CALL filter(-1,-1,999);

