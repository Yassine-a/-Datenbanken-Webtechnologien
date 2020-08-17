<?php
namespace Emensa\Controller {
    require 'vendor/autoload.php';

// Use-Direktive
    Use eftec\bladeone\BladeOne;


    class homeController
    {
        private $blade;

        public function __construct()
        {
            $views = 'views';
            $cache = 'cache';
            $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }

        public function view(){
            try {
                echo $this->blade->run("Home.start");
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }
    }


}