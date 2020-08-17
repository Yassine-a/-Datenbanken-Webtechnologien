<?php

include 'controller/DetailControlle.php';


if (!isset($_GET['id'])) header('Location: Produkte.php');
$id = (int) $_GET['id'] ?? null;

$controller = new \Emensa\Controller\DetailControlle();
$controller->view($id);