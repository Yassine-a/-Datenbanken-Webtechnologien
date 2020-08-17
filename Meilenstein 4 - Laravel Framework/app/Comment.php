<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    public static function get_all_comments($id)  {
        $comments = DB::table('Kommentare')
            ->join('Benutzer','Kommentare.GeschriebenVon','=','Benutzer.Nummer')
            ->orderBy('ID', 'desc')->take(5)
            ->select('Kommentare.Bemerkung','Kommentare.Bewertung','Kommentare.Zeitpunkt','Benutzer.Nutzername')
            ->where('ZuMahlzeiten','=',$id)
            ->get();
        return $comments;
    }

    public static function add_comment($userid,$mahlzeitid,$bewertung,$bemerkung){
        DB::table('Kommentare')->insert(
            ['Bemerkung' => $bemerkung, 'Bewertung' => $bewertung,'GeschriebenVon' => $userid, 'ZuMahlzeiten' =>$mahlzeitid]
        );
    }

    public static function get_sum($id){
        return DB::table('Kommentare')->where('ZuMahlzeiten', '=', $id)->sum('Bewertung');
    }

    public static function get_rows_number($id){
        return DB::table('Kommentare')->where('ZuMahlzeiten', '=', $id)->count();
    }

    public static function get_average($id){
        $rowsNum = self::get_rows_number($id);
        if($rowsNum==0) $rowsNum=1;
        return round((double)self::get_sum($id)/(double)$rowsNum,2);
    }
}
