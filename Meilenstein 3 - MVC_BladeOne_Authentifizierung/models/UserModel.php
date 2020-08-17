<?php
namespace Emensa\Model{
    require_once('db.php');

    class UserModel
    {
        public static function get_user_details($username){
            $query = "SELECT Nummer,`Hash` FROM Benutzer WHERE Nutzername= '" . $username  . "'";
            return db_query_assoc_single($query);
        }


        public static function get_rule($username) {
            $query="CALL user_role('".$username."')";
            return db_query_assoc_single($query)['role'];
        }
        public function registerNewUser($email, $password)
        {
            //Entsprechende Überprüfungen und SQL Queries zum Registrieren des Nutzers
            //Gibt z.B. true zurück, falls die Registrierung funktioniert hat
        }

        public function changeUserPassword(User $user, $new_password)
        {
            //Ändert das Benutzerpasswort für den Nutzer $user
        }

        public function sendNewPassword(User $user)
        {
            //Sendet dem Benutzer ein neues Passwort zu
        }
    }
}

