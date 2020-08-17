<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function showLogin($failed = false)
    {
        $flag = $failed;
        return view("User.Login",compact('flag'));
    }

    public function doLogout()
    {
        session_unset();
        session_destroy();
        $flag = false;
        return view("User.Login",compact('flag'));
    }

    public function doLogin()
    {
        $username=$_POST['username'];
        $password = $_POST['password'];

        $_SESSION['logged_in'] = false;
        $message = "";

        $username1 = filter_var($username, FILTER_SANITIZE_STRING);
        $password1 = filter_var($password, FILTER_SANITIZE_STRING);
        //echo $password = password_hash($password, PASSWORD_BCRYPT);

        $result = User::get_user_details($username1);
        if ($result->first()) {
            if (password_verify($password1, $result->first()->Hash)) {
                $user_id = $result->first()->Nummer;

                //session(['used_id' => $user_id]);
                $_SESSION['user_id'] = $user_id;
                //session(['username' => username]);
                $_SESSION['username'] = $username;

                //session(['role' => User::get_rule($username1)->role]);
                $_SESSION['role'] = User::get_rule($username1)->role;

                //session(['logged_in' => true]);
                $_SESSION['logged_in'] = true;
                //Session::save();

                $message = "Hallo " . $username . ", Sie sind angemeldet als " . $_SESSION['role'];
            }
            if (!isset($user_id) || (isset($user_id)) && !$user_id) {
                $flag = true;
                return view("User.Login",compact('flag'));
            }
            else{
                $flag = false;
                return view("User.Login",compact('flag'));
            }
        } else {
            $flag = true;
            return view("User.Login",compact('flag'));
        }
    }
}
