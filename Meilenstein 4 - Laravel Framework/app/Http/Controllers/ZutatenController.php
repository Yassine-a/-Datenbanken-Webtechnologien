<?php
namespace Emensa\Controller{

    require 'vendor/autoload.php';
    require "models/ZutatenModel.php";

// Use-Direktive
    Use eftec\bladeone\BladeOne;
    use Emensa\Model\ZutatenModel;


    $views = 'views';
    $cache = 'cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);


    class ZutatenController{

        public static function index(){
            global $blade;

            $total = ZutatenModel::get_total_number();
            $titel = "Zutatenliste (" . $total . ")";

            $sorted_list = ZutatenModel::get_orders_list();

            $view = ['titel' => $titel, 'sorted_list' => $sorted_list];

            try {
                echo $blade->run("Product.Zutaten", $view);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }

        }
    }

}
