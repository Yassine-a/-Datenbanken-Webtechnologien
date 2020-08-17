<?php
session_start();
include 'controller/UserController.php';

$controller = new \Emensa\Controller\UserController();
$controller->logout();