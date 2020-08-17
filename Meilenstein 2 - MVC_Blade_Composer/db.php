<?php

namespace Emensa\Model{

    require 'vendor/autoload.php';
    $dotenv = \Dotenv\Dotenv::create(__DIR__, '.env');
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);
    $remoteConnection = mysqli_connect(getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_NAME'),
        (int)getenv('DB_PORT'));

    function db_query_assoc_multi($query) {
        global $remoteConnection;
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $result = mysqli_query($remoteConnection, $query);
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
        close_connection();
    }

    function db_query_assoc_single($query) {
        global $remoteConnection;
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $result = mysqli_query($remoteConnection, $query);
        return mysqli_fetch_assoc($result);
        close_connection();
    }

    function close_connection(){
        global $remoteConnection;
        mysqli_close($remoteConnection);
    }
    //echo db_query_assoc_single("SELECT COUNT(*) FROM Benutzer WHERE Nutzername = 'Yassine'")['COUNT(*)'];

 /*
    $result = $remoteConnection->query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='Studenten' AND COLUMN_NAME='Studiengang'");
    $result = $result->fetch_assoc()['COLUMN_TYPE'];
    $matches= explode(",", str_replace(array("enum(", ")", "'"), "", $result));
    var_dump($matches);
    foreach( $matches as $enum )
    {
        echo "$enum\n";


    }

     function insert_ma($vorname,$nachname,$email,$gdatum,$fb,$telefone,$buero,$username,$hash){
        global $remoteConnection;
        $remoteConnection->autocommit(false);
        $remoteConnection->query("INSERT INTO Benutzer(`E-Mail`,Nutzername,`Hash`,Vorname,Nachname,Geburtsdatum)
                                                    VALUES("."'".$email ."'".","."'". $username ."'".","."'". $hash ."'".","."'". $vorname ."'".","."'". $nachname ."'".","."'".$gdatum."'".")");
        $id = $remoteConnection->insert_id;
        $remoteConnection->query("INSERT INTO FH_Angehoerige(Nummer) VALUES(".$id.")");
        echo $buero." ".$telefone;
        $remoteConnection->query("INSERT INTO FH_AngehoerigeGehoertZuFachbereiche VALUES(".$id.",".$fb.")");
        $remoteConnection->query("INSERT INTO Mitarbeiter(Nummer,Buero) VALUES(".$id.','.$buero.")");
        $remoteConnection->commit();
        if($remoteConnection->warning_count>0){
            $message = $remoteConnection->get_warnings();
            $remoteConnection->rollback();
            $remoteConnection->close();
            return $message;
        }
        $remoteConnection->close();
        return "done";
    }
  */


  //  echo insert_ma("Yswassine","X-X","ssdwe2swine@maiswl.com","1992-01-02",3,NULL,"E321",'M12sswawdesw6',"VmSO4IXYWwPWnf5C7LUBHuJz6M2KvNlBaONoYGRHL7K3DMgFHtWKG");
}



