<?php

namespace App\Http\Controllers;

use App\Details;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Comment;

class DetailsController extends Controller
{
    public function view()
    {
        if (!isset($_GET['id'])) header('Location: Produkte.php');
        $id = (int) $_GET['id'] ?? null;

        $Default_Role_Preis = $this->get_role();
        $details = Details::scope_get_mahlzeit_by_ID_role($id, $Default_Role_Preis);
        $DB_ID = (int)$details->first()->ID ?? null;

        if ($DB_ID != $id) header('Location: Produkte.php');

        $GSM = $this->check_role_string($Default_Role_Preis);
        $zutaten_liste = Details::scope_get_sortierte_tabelle($id);

        $average = Comment::get_average($id);
        $comments = Comment::get_all_comments('s');
        $view = ['titel' => "Details", 'zutaten' => $zutaten_liste, 'GSM' => $GSM,'comments'=>$comments,'average'=>$average];


        return view("Product.Details",compact('view','details','id','comments'));
    }

    function get_role()
    {
        $Default_Role_Preis = "Gastpreis";
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'ma')
            $Default_Role_Preis = "MAPreis";
        elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'student')
            $Default_Role_Preis = "Studentpreis";
        return $Default_Role_Preis;
    }

    function check_role_string($Default_Role_Preis)
    {
        $GSM = "";
        if ($Default_Role_Preis == "Gastpreis") $GSM = "Gast";
        elseif ($Default_Role_Preis == "Studentpreis") $GSM = "Student";
        elseif ($Default_Role_Preis == "MAPreis") $GSM = "Mitarbeiter";
        return $GSM;

    }
}
