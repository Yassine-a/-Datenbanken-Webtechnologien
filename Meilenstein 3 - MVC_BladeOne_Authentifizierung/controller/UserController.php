<?php

namespace Emensa\Controller {

    require 'vendor/autoload.php';
    require "models/UserModel.php";

// Use-Direktive
    Use eftec\bladeone\BladeOne;
    use Emensa\Model\UserModel;


    class UserController
    {
        private $blade;
        public function __construct()
        {
            $views = 'views';
            $cache = 'cache';
            $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }

        public function view($failed = false)
        {
            $flag = $failed;
            try {
                echo $this->blade->run("User.Login", compact('flag'));
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }

        public function logout()
        {
            try {
                echo $this->blade->run("User.Logout");
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }

        public function check_user($username, $password)
        {
            $_SESSION['logged_in'] = false;
            $message = "";

            $username1 = filter_var($username, FILTER_SANITIZE_STRING);
            $password1 = filter_var($password, FILTER_SANITIZE_STRING);
            //echo $password = password_hash($password, PASSWORD_BCRYPT);

            $result = UserModel::get_user_details($username1);
            if ($result) {
                if (password_verify($password1, $result['Hash'])) {
                    $user_id = $result['Nummer'];
                    $_SESSION['used_id'] = $user_id;
                    $_SESSION['username'] = $username;


                    $_SESSION['role'] = UserModel::get_rule($username1);
                    $_SESSION['logged_in'] = true;
                    $message = "Hallo " . $_SESSION['username'] . ", Sie sind angemeldet als " . $_SESSION['role'];
                }
                if (!isset($user_id) || (isset($user_id)) && !$user_id) {
                    $flag = true;
                    $this->view($flag);
                } else $this->view();
            } else {
                $flag = true;
                $this->view($flag);
            }
        }
    }


}

