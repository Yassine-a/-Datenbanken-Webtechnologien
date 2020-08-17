DELIMITER $$
DROP PROCEDURE IF EXISTS filter;
CREATE PROCEDURE filter(IN cat INT,IN Avail INT, IN Lim INT)
BEGIN

  DECLARE ist_vegetarisch BOOL;
  DECLARE M_ID INT;
  DECLARE ist_vegan BOOL;
  DECLARE tmp INT;
  DECLARE rowsNum INT;
  DECLARE currRow INT;
 
  
  DROP TABLE IF EXISTS Mahlzeiten_vegetarisch_vegan;
  CREATE TEMPORARY TABLE Mahlzeiten_vegetarisch_vegan(
    Mahlzeit_ID INT,
    Vegetarisch BOOL NOT NULL,
    Vegan BOOL NOT NULL,
    PRIMARY KEY (Mahlzeit_ID)
    );
    
    SET currRow = 0;
    SELECT COUNT(*) INTO rowsNum FROM Mahlzeiten;
    
        
    WHILE currRow < rowsNum DO
    
    SELECT ID INTO M_ID FROM Mahlzeiten LIMIT currRow,1;
    
    SELECT COUNT(*) INTO tmp FROM Zutaten RIGHT JOIN malhzeitenenthaeltzutaten ON Zutaten.ID = malhzeitenenthaeltzutaten.ZutatenID WHERE malhzeitenenthaeltzutaten.MahlzeitenID = M_ID;
   

	IF tmp = (SELECT COUNT(*) FROM Zutaten
	 				RIGHT JOIN malhzeitenenthaeltzutaten ON Zutaten.ID = malhzeitenenthaeltzutaten.ZutatenID
					WHERE malhzeitenenthaeltzutaten.MahlzeitenID = M_ID AND zutaten.Vegan) THEN
					
   SET ist_vegan = 1;
   ELSE
      SET ist_vegan = 0;
   END IF;
   
   IF tmp = (SELECT COUNT(*) FROM Zutaten
	 				RIGHT JOIN malhzeitenenthaeltzutaten ON Zutaten.ID = malhzeitenenthaeltzutaten.ZutatenID
					WHERE malhzeitenenthaeltzutaten.MahlzeitenID = M_ID AND zutaten.Vegetarisch) THEN
					
   SET ist_vegetarisch = 1;
   ELSE
      SET ist_vegetarisch = 0;
   END IF;
	    

    INSERT INTO Mahlzeiten_vegetarisch_vegan(Mahlzeit_ID, Vegetarisch, Vegan) VALUES (M_ID, ist_vegetarisch, ist_vegan);
    
    SET currRow = currRow + 1;
    
    END WHILE;
    IF cat = -1 AND Avail= 0 THEN 
    SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten,Mahlzeiten_vegetarisch_vegan.Vegetarisch,Mahlzeiten_vegetarisch_vegan.Vegan FROM Mahlzeiten
    			JOIN Mahlzeiten_vegetarisch_vegan ON Mahlzeiten_vegetarisch_vegan.Mahlzeit_ID=Mahlzeiten.ID
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID LIMIT Lim;
				
	ELSEIF cat > -1 AND Avail = 0 THEN
	SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten,Mahlzeiten_vegetarisch_vegan.Vegetarisch,Mahlzeiten_vegetarisch_vegan.Vegan FROM Mahlzeiten
				JOIN Mahlzeiten_vegetarisch_vegan ON Mahlzeiten_vegetarisch_vegan.Mahlzeit_ID=Mahlzeiten.ID
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID WHERE Mahlzeiten.Kategorie_ID = cat LIMIT Lim;
				
	ELSEIF cat = -1 AND Avail = 1 THEN
	SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten,Mahlzeiten_vegetarisch_vegan.Vegetarisch,Mahlzeiten_vegetarisch_vegan.Vegan FROM Mahlzeiten
				JOIN Mahlzeiten_vegetarisch_vegan ON Mahlzeiten_vegetarisch_vegan.Mahlzeit_ID=Mahlzeiten.ID
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID WHERE Mahlzeiten.Verfuegbar= 1 LIMIT Lim;
	ELSE
	SELECT Mahlzeiten.Name,Mahlzeiten.ID,Verfuegbar,`Alt-Text`,Binaerdaten,Mahlzeiten_vegetarisch_vegan.Vegetarisch,Mahlzeiten_vegetarisch_vegan.Vegan  FROM Mahlzeiten
	 			JOIN Bilder 
				JOIN HatBilder ON Mahlzeiten.ID = hatbilder.MahlzeitenID AND Bilder.ID = HatBilder.BilderID
				JOIN Mahlzeiten_vegetarisch_vegan ON Mahlzeiten_vegetarisch_vegan.Mahlzeit_ID=Mahlzeiten.ID
				WHERE Mahlzeiten.Verfuegbar= 1 AND Mahlzeiten.Kategorie_ID = cat LIMIT Lim;
	END IF;
	


END$$


	
DELIMITER ;



CALL filter(-1,1,99);


