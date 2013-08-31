<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/14/13
 * Time: 12:14 PM
 * To change this template use File | Settings | File Templates.
 */
//include_once 'createDBMongo.php';
$m = new MongoClient();

$c = $m->demo->circus;
$r = $c->findOne(
    array( 'performers' => array( '$gte' => 40 ) ),
    array( 'name' => true, 'performers' => true )
);
var_dump( $r );
?>
