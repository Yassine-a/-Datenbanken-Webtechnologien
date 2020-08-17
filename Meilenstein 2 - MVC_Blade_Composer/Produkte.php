<?php
include 'controller/ProdukteController.php';


//HilfsVariablen
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

if (isset($kat) and $kat != "alle")
    $query_category_variable = "ID=" . $kat;
else $query_category_variable = " FALSE ";

$controller = new \Emensa\Controller\ProdukteController();
$controller->Action_view($Avail,$vegetarisch,$vegan,$query_category_variable,$kat,$LIMIT);