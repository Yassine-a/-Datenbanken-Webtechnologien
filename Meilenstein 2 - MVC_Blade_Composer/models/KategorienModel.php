<?php
namespace Emensa\Model {

    class KategorienModel extends mysqli
    {

        public function get_mahlzeit_by_ID_role($remoteConnection,$id,$role_preis) :array {
            $result = mysqli_query($remoteConnection, "SELECT m.ID, m.Name,m.ID,Beschreibung,`Alt-Text`,Binaerdaten," . $role_preis . " AS Preis FROM Mahlzeiten AS m
                                                        JOIN Bilder AS b
                                                           JOIN HatBilder AS hb
                                                        JOIN Preise AS p ON m.ID=p.MahlzeitenID
                                                        WHERE m.ID=hb.MahlzeitenID AND b.ID = hb.BilderID AND m.ID=$id");
            return mysqli_fetch_all($result);

        }

        public function get_sortierte_tabelle($remoteConnection,$ID):array {
            $result = mysqli_query($remoteConnection, " SELECT ZutatenID, z.Name, z.Bio, z.Vegan, z.Vegetarisch, z.Glutenfrei FROM Mahlzeiten m 
                                                        JOIN MalhzeitenEnthaeltZutaten mez ON m.ID = mez.MahlzeitenID 
                                                        JOIN Zutaten z ON mez.ZutatenID = z.ID WHERE m.ID=$ID
                                                        ORDER BY Bio Desc, Name ASC");
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }


    }
}
