<?php
namespace Emensa\Model {
    require_once('db.php');

    class DetailsModel
    {
        public function get_mahlzeit_by_ID_role($id,$role_preis)  {
            $query= "SELECT m.ID, m.Name,m.ID,Beschreibung,`Alt-Text`,Binaerdaten," . $role_preis . " AS Preis FROM Mahlzeiten AS m
                                                        JOIN Bilder AS b
                                                           JOIN HatBilder AS hb
                                                        JOIN Preise AS p ON m.ID=p.MahlzeitenID
                                                        WHERE m.ID=hb.MahlzeitenID AND b.ID = hb.BilderID AND m.ID=$id";
            return db_query_assoc_single($query);

        }

        public function get_sortierte_tabelle($ID) {
            $query = " SELECT ZutatenID, z.Name, z.Bio, z.Vegan, z.Vegetarisch, z.Glutenfrei FROM Mahlzeiten m 
                                                        JOIN MalhzeitenEnthaeltZutaten mez ON m.ID = mez.MahlzeitenID 
                                                        JOIN Zutaten z ON mez.ZutatenID = z.ID WHERE m.ID=$ID
                                                        ORDER BY Bio Desc, Name ASC";

            return db_query_assoc_multi($query);

        }


    }
}
