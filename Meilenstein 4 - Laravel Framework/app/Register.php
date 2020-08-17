<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Register extends Model
{
    public static function get_user_ID($username){
        $userFind = DB::table('Benutzer')
            ->select('Nummer')
            ->where('Nutzername', '=',$username)
            ->get();
        return $userFind->first()->Nummer;
    }


    public static function isMemberExists($username) {
        $userFind = DB::table('Benutzer')
            ->select('COUNT(*) AS c')
            ->where('Nutzername', '=',$username)
            ->get();
        return $userFind->first()->c;
    }

    public static function isEmailExists($email) {
        $userFind = DB::table('Benutzer')
            ->select('COUNT(*) AS c')
            ->where('E-Mail', '=',$email)
            ->get();
        return $userFind->first()->c;
    }

    public static function isMatrExists($matNr) {
        $userFind = DB::table('Benutzer')
            ->select('COUNT(*) AS c')
            ->where('Matrikelnummer', '=',$matNr)
            ->get();
        return $userFind->first()->c;

    }

    public static function insert_student($vorname,$nachname,$email,$gdatum,$fb,$matrNr,$studiengang,$username,$hash){
        global $remoteConnection;
        try{
            $remoteConnection->begin_transaction();
            $remoteConnection->query("INSERT INTO Benutzer(`E-Mail`,Nutzername,`Hash`,Vorname,Nachname,Geburtsdatum) 
                                                    VALUES("."'".$email ."'".","."'". $username ."'".","."'". $hash ."'".","."'". $vorname ."'".","."'". $nachname ."'".","."'".$gdatum."'".")");
            $id = $remoteConnection->insert_id;
            $remoteConnection->query("INSERT INTO FH_Angehoerige(Nummer) VALUES(".$id.")");
            $remoteConnection->query("INSERT INTO FH_AngehoerigeGehoertZuFachbereiche VALUES(".$id.",".$fb.")");
            $remoteConnection->query("INSERT INTO Studenten(Nummer, Studiengang, Matrikelnummer) VALUES(".$id.","."'".$studiengang."'".","."$matrNr)");
            $remoteConnection->commit();
        }catch (\Exception $e){
            $remoteConnection->rollback();
            $remoteConnection->close();
            return false;
        }
        $remoteConnection->close();
        return true;
    }

    public static function insert_ma($vorname,$nachname,$email,$gdatum,$fb,$telefone,$buero,$username,$hash){
//            echo "VN:",$vorname,'  ',"VN:",$nachname,'  ',"Email:",$email,'  ',"Gdatum:",$gdatum,'  ',"FB:",$fb,'  ',"Telefone:",$telefone,'  ',"Buero:",$buero,'  ',"Username:",$username,'  ',"Hash:",$hash;
        global $remoteConnection;
        try{
            $remoteConnection->begin_transaction();
            $remoteConnection->query("INSERT INTO Benutzer(`E-Mail`,Nutzername,`Hash`,Vorname,Nachname,Geburtsdatum) 
                                                    VALUES("."'".$email ."'".","."'". $username ."'".","."'". $hash ."'".","."'". $vorname ."'".","."'". $nachname ."'".","."'".$gdatum."'".")");
            $id = $remoteConnection->insert_id;
            $remoteConnection->query("INSERT INTO FH_Angehoerige(Nummer) VALUES(".$id.")");

            $remoteConnection->commit();
        }catch (\Exception $e){
            $remoteConnection->rollback();
            $remoteConnection->close();
            return false;
        }
        $remoteConnection->close();
        return true;
    }

    public static function insert_gast($username,$hash,$vorname,$nachname,$email,$gdatum,$grund){
        global $remoteConnection;
        $remoteConnection->begin_transaction();
        $remoteConnection->query("INSERT INTO Benutzer(`E-Mail`,Nutzername,`Hash`,Vorname,Nachname,Geburtsdatum) 
                                                    VALUES("."'".$email ."'".","."'". $username ."'".","."'". $hash ."'".","."'". $vorname ."'".","."'". $nachname ."'".","."'".$gdatum."'".")");
        $id = $remoteConnection->insert_id;
        echo $grund;
        $remoteConnection->query("INSERT INTO Gaeste(Nummer,Grund) VALUES(".$id.','.$grund.")");
        $remoteConnection->commit();
        if($remoteConnection->warning_count){
            $message = strstr($remoteConnection->get_warnings());
            $remoteConnection->rollback();
            $remoteConnection->close();
            return $message;
        }
        $remoteConnection->close();
        return "done";
    }


    public function get_rule($link,$username):array {
        $result=mysqli_query($link,"CALL user_role('".$username."')");
        return mysqli_fetch_assoc($result);
    }

    public static function get_fb(){
        $query = "SELECT `NAME`,ID FROM Fachbereiche";
        return db_query_assoc_multi($query);
    }

    public static function get_sg(){
        global $remoteConnection;
        $result = $remoteConnection->query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='Studenten' AND COLUMN_NAME='Studiengang'");
        $result = $result->fetch_assoc()['COLUMN_TYPE'];
        $result= explode(",", str_replace(array("enum(", ")", "'"), "", $result));
        return $result;
    }

}
