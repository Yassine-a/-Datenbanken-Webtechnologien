<?php
include 'controller/RegistrierenController.php';

if(isset($_GET['id'])&& $_GET['id']==1){
    $controller = new \Emensa\Controller\RegistrierenController();
    $controller->action_insert_student($_POST['vorname'],$_POST['nachname'],$_POST['email'],$_POST['date'],
                                        $_POST['fb_id'],$_POST['matrNr'],$_POST['studiengang'],$_POST['username'],$_POST['hash']);
}elseif(isset($_GET['id'])&& $_GET['id']==2){
    $controller = new \Emensa\Controller\RegistrierenController();
    $controller->action_insert_ma($_POST['vorname'],$_POST['nachname'],$_POST['email'],$_POST['date'],
        $_POST['fb_id'],$_POST['buero'],$_POST['telefone'],$_POST['username'],$_POST['hash']);

}elseif(isset($_GET['id'])&& $_GET['id']==3){
    $controller = new \Emensa\Controller\RegistrierenController();
    $controller->action_insert_gast($_POST['username'],$_POST['hash'],$_POST['vorname'],$_POST['nachname'],$_POST['email'],$_POST['date'],$_POST['grund']);
}else{
    $controller = new \Emensa\Controller\RegistrierenController();
    if (isset($_POST['username'])){
        $controller->action_insert_first_step($_POST['username'], $_POST['role'], $_POST['password'], $_POST['password2']);
    }
    else $controller->view();
}


