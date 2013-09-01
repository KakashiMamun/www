<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/28/13
 * Time: 1:54 AM
 * To change this template use File | Settings | File Templates.
 */

class MongoConfig{

    var $HOST = '';
    var $PORT = '';
    var $USER = '';
    var $PASS = '';
    public static function GetNewConnection(){

    $con = new MongoClient();

    return $con;
    }
}