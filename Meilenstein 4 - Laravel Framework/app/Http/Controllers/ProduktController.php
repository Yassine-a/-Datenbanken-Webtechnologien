<?php

namespace App\Http\Controllers;

use App\Produkte;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ProduktController extends Controller
{
    public function view()
    {
        $kat = NULL;
        $LIMIT = 999; // wird an Query angehängt
        $Avail = 0;
        $vegetarisch = false;
        $vegan = false;
        if (isset($_GET['limit'])) $LIMIT = $_GET['limit'];
        if (isset($_GET['avail'])) $Avail = $_GET['avail'];
        if (isset($_GET['vegetarisch'])) $vegetarisch = $_GET['vegetarisch'];
        if (isset($_GET['vegan'])) $vegan = $_GET['vegan'];
        if ($Avail) $Avail = 1;
        else $Avail = 0;

        if (isset($_GET['kat'])) $kat = $_GET['kat'];



        // If a catagory is seleted the query will give the Bezeichnung back
        if(isset($kat) and $kat != "alle")
            $category_is_selected = Produkte::scope_get_catagory_name($kat);
        else
            $category_is_selected = Produkte::scope_get_catagory_name_all();

        if ($category_is_selected) $Category_Titel = $category_is_selected->first()->Bezeichnung;
        else $Category_Titel = "Generell";

        $catagory_list = Produkte::scope_get_catagory_list();


        // Check whether a Certain category is selected => Used for the query
        if (isset($kat) and $kat != "alle")
            $kat1 = $kat;
        else $kat1 = -1;

        $sorted_mahlzeitenListe = Produkte::scope_get_filtered_MahlzeitenListe($kat1, $Avail, $LIMIT);

        $view = ['titel' => "Mahlzeiten", 'titel2' => $Category_Titel, 'catagory_list' => $catagory_list,
            'current_category' => $kat1, 'sorted_list' => $sorted_mahlzeitenListe,
            'Avail' => $Avail, 'vegetarisch' => $vegetarisch, 'vegan' => $vegan];


        return view("Product.Produkte",$view);

    }
}
