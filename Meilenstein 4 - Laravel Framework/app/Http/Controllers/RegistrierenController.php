<?php

namespace Emensa\Controller {

    require 'vendor/autoload.php';
    require "models/RegistrierenModel.php";

// Use-Direktive
    Use eftec\bladeone\BladeOne;
    use Emensa\Model\RegistrierenModel;


    class RegistrierenController
    {
        private $blade;

        public function __construct()
        {
            session_start();
            $views = 'views';
            $cache = 'cache';
            $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }


        public function Action_erfolgreich_reg($msg=""){
            try {
                echo $this->blade->run("User.Registrieren",compact('msg','errore'));
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }

        public function view($msg="",$errore=false){
            try {
                echo $this->blade->run("User.Registrieren",compact('msg','errore'));
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }

        public function viewStudent($msg="",$errore=false,$username="",$hash="",$vorname="",$nachname="",$email="",$gdatum="",$fb="",$matrNr="",$studiengang=""){
            try {
                echo $this->blade->run("User.RegistrierenStudent",compact('msg','errore','username','hash','vorname','nachname','email','gdatum','fb','matrNr','studiengang'));
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }

        public function view_ma($msg="",$errore=false,$username="",$hash="",$vorname="",$nachname="",$email="",$gdatum="",$fb="",$telefone="",$buero=""){
            try {
                echo $this->blade->run("User.RegistrierenMitarbeiter",compact('msg','errore','username','hash','vorname','nachname','email','gdatum','fb','telefone','buero'));
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }

        public function view_ga($msg="",$errore=false,$username="",$hash="",$vorname="",$nachname="",$email="",$gdatum="",$grund=""){
            try {
                echo $this->blade->run("User.RegistrierenGast",compact('msg','errore','username','hash','vorname','nachname','email','gdatum','grund'));
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }

        public function action_insert_first_step($username,$role,$password,$passwordRe) {

            $hash =  password_hash($password, PASSWORD_BCRYPT);
            if(RegistrierenModel::isMemberExists($username)>0) {
                $message = "Nickname ist schon vergeben!";
                $this->view($message,true);
                die();
            }
            if(strlen($password)<10 || !preg_match("#[0-9]+#", $password) || !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password) ) {
                $message = "Error, das Passwort muss mindestens 10 Zeichen lang sein und mindestens eine Ziffer und ein Sonderzeichen enthalten!";
                $this->view($message,true);
                die();
            }
            if($password != $passwordRe ) {
                $message = "Error, Die Passwörter stimmen nicht über ein!";
                $this->view($message,true);
                die();
            }
            if($role == "student"){
               $this->viewStudent("",false,$username,$hash);
            }
            elseif($role == "ma"){
                $this->view_ma("",false,$username,$hash);
            }
            elseif($role == "gast") {
                $this->view_ga("",false,$username,$hash);
            }
        }

        public function action_insert_student($vorname,$nachname,$email,$gdatum,$fb,$matrNr,$studiengang,$username,$hash){
            global $blade;
            $message=array();
            $flag=false;

            if(RegistrierenModel::isEmailExists($email)>0) {
                $flag = true;
                array_push($message, "Email ist schon vergeben!");
            }
            if(RegistrierenModel::isMatrExists($matrNr)>0){
                $flag = true;
                array_push($message,"Es gibt schon ein Account mit der eingegebenen Matrikulnummer!");
            }
            if(strlen($matrNr)!=7 || !is_numeric($matrNr)){
                $flag = true;
                array_push($message,"Ihre Matrikelnummer erfüllt nicht die Kriterien!");
            }
            if(!ctype_alpha($vorname) || !ctype_alpha($nachname)){
                $flag = true;
                array_push($message,"Vor bzw. Nach-name darf nur Buchstaben enthlaten!");
            }
            if($flag) {
                $this->viewStudent($message,$flag,$username,$hash,$vorname,$nachname,$email,$gdatum,$fb,$matrNr,$studiengang);
                die();
            }

            if(RegistrierenModel::insert_student($vorname,$nachname,$email,$gdatum,$fb,$matrNr,$studiengang,$username,$hash)){
                $flag=false;
                $msg="Sie haben sich erfolgreich registriert";
                echo $this->blade->run("User.Login",compact('flag','msg'));
            }
            else{
                $flag=true;
                $message="etwas ist schief gelaufen bitte versuchen Sie es erneut";
                $this->viewStudent($message,$flag,$username,$hash,$vorname,$nachname,$email,$gdatum,$fb,$matrNr,$studiengang);
            }
        }

        public function action_insert_ma($vorname,$nachname,$email,$gdatum,$fb,$telefone,$buero,$username,$hash){
            global $blade;
            $message=array();
            $flag=false;
            if(strlen($buero)==0) $buero = "NULL"; else $buero = "'$buero'";
            if(strlen($telefone)==0) $telefone = "NULL";
            echo $buero.$telefone.strlen($buero);

            if(RegistrierenModel::isEmailExists($email)>0) {
                $flag = true;
                array_push($message, "Email ist schon vergeben!");
            }
            if(!ctype_alpha($vorname) || !ctype_alpha($nachname)){
                $flag = true;
                array_push($message,"Vor bzw. Nach-name darf nur Buchstaben enthlaten!");
            }
            if($flag) {
                $this->view_ma($username,$hash,$vorname,$nachname,$email,$gdatum,$fb,$telefone,$buero);
                die();
            }
            if(RegistrierenModel::insert_ma($vorname,$nachname,$email,$gdatum,$fb,$telefone,$buero,$username,$hash)){
                $flag=false;
                $msg="Sie haben sich erfolgreich registriert";
                echo $this->blade->run("User.Login",compact('flag','msg'));
                die();
            }
            $flag=true;
            $message="etwas ist schief gelaufen bitte versuchen Sie es erneut";
            $this->view_ma($username,$hash,$vorname,$nachname,$email,$gdatum,$fb,$telefone,$buero,$username,$hash);
        }

        public function action_insert_gast($username,$hash,$vorname,$nachname,$email,$gdatum,$grund){
            global $blade;
            $message=array();
            $flag=false;

            if(RegistrierenModel::isEmailExists($email)>0) {
                $flag = true;
                array_push($message, "Email ist schon vergeben!");
            }
            if(!ctype_alpha($vorname) || !ctype_alpha($nachname)){
                $flag = true;
                array_push($message,"Vor bzw. Nach-name darf nur Buchstaben enthlaten!");
            }
            if($flag) {
                $this->view_ga($message,$flag,$username,$hash,$vorname,$nachname,$email,$gdatum,$grund);
                die();
            }

            if(RegistrierenModel::insert_gast($username,$hash,$vorname,$nachname,$email,$gdatum,$grund)){
                $flag=false;
                $msg="Sie haben sich erfolgreich registriert";
                echo $this->blade->run("User.Login",compact('flag','msg'));
            }
            else{
                $flag=true;
                $message="etwas ist schief gelaufen bitte versuchen Sie es erneut";
                $this->view_ga($message,$flag,$username,$hash,$vorname,$nachname,$email,$gdatum,$grund);
            }

        }


    }
}

