<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    public static function get_user_details($username){

        $userInfo = DB::table('Benutzer')
            ->select('Nummer', 'Hash')
            ->where('Nutzername', '=',$username)
            ->get();
        return $userInfo;
    }


    public static function get_rule($username) {
        return DB::selectOne("CALL user_role('".$username."')");
    }
}
