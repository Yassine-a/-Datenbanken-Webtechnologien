<?php
namespace Emensa\Model {
    require_once('db.php');

    class ZutatenModel
    {
        public static function get_total_number()  {
            $query = "SELECT COUNT(*) FROM Zutaten";
            return db_query_assoc_single($query)['COUNT(*)'];
        }

        public static function get_orders_list() {
            $query = "SELECT ID, Name, Bio, Vegan, Vegetarisch, Glutenfrei FROM Zutaten ORDER BY Bio Desc, Name ASC";
            return db_query_assoc_multi($query);
        }

    }
}

