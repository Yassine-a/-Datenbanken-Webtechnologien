<?php
require 'vendor/autoload.php';
require_once "controller/ZutatenController.php";
$controller = new \Emensa\Controller\ZutatenController();
$controller->index();