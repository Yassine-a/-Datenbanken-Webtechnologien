<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produkte extends Model
{
    public static function scope_get_catagory_name($ID)  {
        $catagory = DB::table('Kategorien')
            ->select('Bezeichnung')
            ->where('ID','=',$ID)
            ->get();
        return $catagory;
    }

    public static function scope_get_catagory_name_all()  {
        $catagory = DB::table('Kategorien')
            ->select('Bezeichnung')
            ->get();
        return $catagory;
    }

    public static function scope_get_catagory_list() {
        return DB::select('CALL category_list()');
    }

    public static function scope_get_filtered_MahlzeitenListe($kat1,$Avail,$LIMIT){
        return DB::select('CALL filter(' . $kat1 . ',' . $Avail . ',' . $LIMIT . ')');
    }
}
