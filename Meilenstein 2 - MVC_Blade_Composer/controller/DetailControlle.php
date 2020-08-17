<?php
namespace Emensa\Controller {
    include 'models/DetailsModel.php';
    require 'vendor/autoload.php';

// Use-Direktive
    Use eftec\bladeone\BladeOne;


    class DetailControlle
    {
        private $blade;

        public function __construct()
        {
            $views = 'views';
            $cache = 'cache';
            $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }

        public function view($id)
        {


            $Default_Role_Preis = $this->get_role();
            $details = \Emensa\Model\DetailsModel::get_mahlzeit_by_ID_role($id, $Default_Role_Preis);
            $DB_ID = (int)$details['ID'] ?? null;
            if ($DB_ID != $id) header('Location: Produkte.php');
            $GSM = $this->check_role_string($Default_Role_Preis);
            $zutaten_liste = \Emensa\Model\DetailsModel::get_sortierte_tabelle($id);
            $view = ['titel' => "Details", 'details' => $details, 'zutaten' => $zutaten_liste, 'GSM' => $GSM];

            try {
                echo $this->blade->run("Product.Details", $view);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
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
}