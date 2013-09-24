<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/22/13
 * Time: 3:42 PM
 * To change this template use File | Settings | File Templates.
 */

class LoginModule {



    /**
     * Get a User info from User table in the DB with email and password given
     *
     * @param string $email
     * @param string $password
     *
     **/

    public static function GetUser($email, $password)
    {

        $sql = 'SELECT * FROM user where email =\''.$email.'\' and password=\''.$password.'\'';
        $result = ICodeDB::GetResultRow($sql);
        return $result;
    }

    /**
     * Generate a Valid session key
     *
     * @param int $user_id
     * @param int TTL -> Time left
     *
     **/

    public static function GenerateSessionKey($user_id, $TTL){


        $CONFIGURATIONS = ICodeDB::GetResultRow('select * from icode_configuration where name=\'salt\'');

//        global $CONFIGURATIONS;

        $curTimestamp = time();
        $salt = $CONFIGURATIONS['salt'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $sessionKey = $user_id.'#'.$TTL.'#'.$curTimestamp.'#'.$ip.'#'.$salt;

        return $sessionKey;
    }

    /**
     * Create or Update a user's session Data
     *
     * @param result assoc arraay $userData
     * @param int TTL -> Time left
     *
     **/

    public static function CreateOrUpdateSession($userData,$TTL){

        $user_id = $userData['user_id'];

        $session_key = LoginModule::GenerateSessionKey($user_id, $TTL);

        $user_data = serialize($userData);

        $sql = "REPLACE INTO session_table values($user_id,'$session_key','$user_data',ADDDATE(NOW(),INTERVAL $TTL DAY) );";

//    echo $sql;
        ICodeDB::FreshInsert($sql);
    }

    /**
     * Generates session Data
     *
     * @param int user_id
     **/
    public static function GenerateSessionData($user_id){

        $sql ="SELECT * FROM session_table where user_id = $user_id ;";
        $result = ICodeDB::GetResultRow($sql);
        return $result;
    }

}