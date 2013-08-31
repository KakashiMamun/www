<?php
//
//require_once('MongoAdminConfig.php') ;
//$m = MongoConfig::GetNewConnection();
//    $c = $m->demo->articles;
//try{
//    $d = array( 'name' => 'Derick', '_id' => 'derickr' );
//    $c->insert( $d );
//    var_dump( $d );
//    $d = array( 'name' => 'Derick' );
//    $c->insert( $d );
//    var_dump( $d );
//}catch (MongoException $ex){
//    print_r($m->demo->lastError());
//
//}
//
//
//// find everything in the collection
//$cursor = $c->find();


require_once('ICodeMongoDB.class.php');


//ICodeMongoDB::CountDocument('demo','articles');
//print_r(ICodeMongoDB::Insert(array('_id'=>3, 'name' => 'Jhon', 'age' => 21),'test','test'));
//print_r(ICodeMongoDB::FetchAsArray(array('elephpants.year' => array( '$gte' => 3000 ) ),'demo', 'circus'));
?>
<?php
$m = new Mongo;
$c = $m->demo->elephpants;
$c->drop();
function birthDay( $c, $name ){
    $c->update(
        array( 'name' => $name ),
//
        array( '$inc' => array( 'age' => 1 ) ),
//
        array( 'upsert' => true )
//
    );
    var_dump( $c->findOne( array( 'name' => 'Santon') ) );

}

birthDay( $c, 'Santon' );
birthDay( $c, 'Santon' );
?>
