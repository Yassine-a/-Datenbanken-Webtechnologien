<?php
namespace Emensa\Model {
    require_once('db.php');

    class ProdukteModel
    {
        public static function get_catagory_name($catagory)  {
            $query = 'SELECT Bezeichnung FROM Kategorien m WHERE ' . $catagory;
            return db_query_assoc_single($query);

        }

        public static function get_catagory_list() {
            $query = "SELECT kparent.ID,kparent.Bezeichnung PB,kchild.Bezeichnung AS CB,kchild.ID AS CID FROM Kategorien kchild
                            LEFT JOIN Kategorien kparent ON kchild.ParentKategorie=kparent.ID WHERE kparent.ID!=0 ORDER BY kparent.ID ASC";
            return db_query_assoc_multi($query);
        }

        public static function get_filtered_MahlzeitenListe($kat1,$Avail,$LIMIT){
            $query = 'CALL filter(' . $kat1 . ',' . $Avail . ',' . $LIMIT . ')';
            return db_query_assoc_multi($query);
        }


    }
}
