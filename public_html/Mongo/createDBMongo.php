<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/14/13
 * Time: 12:12 PM
 * To change this template use File | Settings | File Templates.
 */
//
//$m = new MongoClient();
//$c = $m->demo->circus;
//$c->insert( array(
//    '_id' => 'circ1',
//    'name' => 'Diaspora',
//    'performers' => 43,
//    'elephpants' => array (
//        array ( 'name' => 'Annabelle', 'colour' => 'pink', 'year' => 1964 ),
//        array ( 'name' => 'Chunee',
//            'colour' => 'blue', 'year' => 1826 )
//    )
//) );
//$c->insert( array(
//    '_id' => 'circ2',
//    'name' => 'Sensible',
//    'performers' => 27,
//    'elephpants' => array (
//        array ( 'name' => 'Kandula',
//            'colour' => 'pink', 'year' => 2001 ),
//        array ( 'name' => 'Kolakolli', 'colour' => 'blue', 'year' => 2006 )
//    )
//) );
//?>

<?php
//$m = new MongoClient();
//$c = $m->demo->elephpants;
////$c->remove();
//$c->insert( array( '_id' => 'e42', 'name' => 'Kamubpo' ) );
//var_dump( $c->findOne( array( '_id' => 'e42' ) ) );
//$c->update( array( '_id' => 'e42' ), array( 'name' => 'Bo Tat' ) );
//var_dump( $c->findOne( array( '_id' => 'e42' ) ) );
//$c->update( array( 'name' => 'Bo Tat' ), array( 'age' => '17' ) );
//var_dump( $c->findOne( array( '_id' => 'e42' ) ) );
//?>

<?php
//$m = new MongoClient();
//$c = $m->demo->elephpants;
//$c->remove(array( '_id' => 'e42' ) );
//$c->insert( array( '_id' => 'e43', 'name' => 'Dumbo' ) );
//var_dump( $c->findOne( array( '_id' => 'e43' ) ) );
//$c->update( array(
//        'name' => 'Dumbo' ), // criteria
//    array(
//        '$set' => array ( 'age' => '17' )
//    )
//);
//var_dump( $c->findOne( array( '_id' => 'e43' ) ) );
//?>

<?php
$m = new Mongo;
$c = $m->demo->elephpants;
$c->drop();
$c->insert( array( '_id' => 'e42', 'name' => 'Kamubpo', 'age' => 17 ) );
$c->insert( array( '_id' => 'e43', 'name' => 'Denali', 'age' => 17 ) );
$c->update( array( 'age' => 17 ), array( '$inc' => array( 'age' => 1 ) ) );
var_dump( iterator_to_array( $c->find() ) );
?>
