<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/11/13
 * Time: 9:18 PM
 * To change this template use File | Settings | File Templates.
 */

require_once('includes/frontIncludes.php');

class UrboshiNextID{

    public static function getNextArticleID(){

        $sql = 'insert into articleID (creator) values(1)';
        $ID = ICodeDB::FreshInsertAndGetId($sql,'articleID');

        return $ID;
    }

    public static function getNextCategoryID(){

        $sql = 'insert into categoryID (creator) values(1)';
        $ID = ICodeDB::FreshInsertAndGetId($sql,'categoryID');

        return $ID;
    }
}