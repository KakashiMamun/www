<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/28/13
 * Time: 1:54 AM
 * To change this template use File | Settings | File Templates.
 */

class MongoConfig{

    private static $HOST = '';
    private static $PORT = '';
    private static $USER = '';
    private static $PASS = '';
    public  static $DBName = 'urboshiDB';
    public static function GetNewConnection()
    {

        $con = new MongoClient();

    return $con;
    }

    public static function getDBname()
    {
        return MongoConfig::$DBName;
    }

}