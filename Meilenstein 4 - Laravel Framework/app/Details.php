<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Details extends Model
{
    public static function scope_get_mahlzeit_by_ID_role($id,$role_preis)  {
        $mahlzeit = DB::table('Mahlzeiten')
            ->join('Bilder','Bilder.ID','=','Bilder.ID')
            ->join('HatBilder',function ($join) {
                $join->on('Mahlzeiten.ID', '=', 'HatBilder.MahlzeitenID');
                $join->on('Bilder.ID','=', 'HatBilder.BilderID');
            })
            ->join('Preise', 'Mahlzeiten.ID', '=', 'Preise.MahlzeitenID')
            ->select('Mahlzeiten.ID', 'Mahlzeiten.Name','Mahlzeiten.ID','Beschreibung','Alt-Text','Binaerdaten',$role_preis." AS Preis")
            ->where('Mahlzeiten.ID', '=',$id)
            ->get();
        return $mahlzeit;


    }

    public static function scope_get_sortierte_tabelle($ID) {
        $zutaten_sortiert = DB::table('Mahlzeiten')
            ->join('MalhzeitenEnthaeltZutaten','Mahlzeiten.ID','=','MalhzeitenEnthaeltZutaten.MahlzeitenID')
            ->join('Zutaten','MalhzeitenEnthaeltZutaten.ZutatenID','=','Zutaten.ID')
            ->where('Mahlzeiten.ID','=',$ID)
            ->select('ZutatenID', 'Zutaten.Name', 'Zutaten.Bio', 'Zutaten.Vegan', 'Zutaten.Vegetarisch', 'Zutaten.Glutenfrei')
            ->orderBy('Bio', 'ASC')
            ->get();

        return  $zutaten_sortiert;

    }
}
