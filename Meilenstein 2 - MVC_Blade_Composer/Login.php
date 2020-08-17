<?php
include 'controller/UserController.php';

if(isset($_POST['submit']) && $_POST['submit']=="true"){
    $controller = new \Emensa\Controller\UserController();
    $controller->check_user($_POST['username'], $_POST['password']);
}
else {
    $controller = new \Emensa\Controller\UserController();
    $controller->view();

}

