<?php
namespace Emensa\Controller {
    include 'models/ProdukteModel.php';
    require 'vendor/autoload.php';

// Use-Direktive
    Use eftec\bladeone\BladeOne;


    class ProdukteController
    {
        private $blade;

        public function __construct()
        {
            $views = 'views';
            $cache = 'cache';
            $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }

        public function Action_view($Avail,$vegetarisch,$vegan,$query_category_variable,$kat,$LIMIT)
        {
            // If a catagory is seleted the query will give the Bezeichnung back
            $category_is_selected = \Emensa\Model\ProdukteModel::get_catagory_name($query_category_variable);

            if ($category_is_selected) $Category_Titel = $category_is_selected['Bezeichnung'];
            else $Category_Titel = "Generell";

            $catagory_list = \Emensa\Model\ProdukteModel::get_catagory_list();


            // Check whether a Certain category is selected => Used for the query
            if (isset($kat) and $kat != "alle")
                $kat1 = $kat;
            else $kat1 = -1;

            $sorted_mahlzeitenListe = \Emensa\Model\ProdukteModel::get_filtered_MahlzeitenListe($kat1, $Avail, $LIMIT);

            $view = ['titel' => "Mahlzeiten", 'titel2' => $Category_Titel, 'catagory_list' => $catagory_list,
                'current_category' => $kat1, 'sorted_list' => $sorted_mahlzeitenListe,
                'Avail' => $Avail, 'vegetarisch' => $vegetarisch, 'vegan' => $vegan];


            try {
                echo $this->blade->run('Product.Produkte',$view);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }


        }
    }


}








