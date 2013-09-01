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


//require_once('ICodeMongoDB.class.php');



//ICodeMongoDB::CountDocument('demo','articles');
//print_r(ICodeMongoDB::Insert(array('_id'=>3, 'name' => 'Jhon', 'age' => 21),'test','test'));
//print_r(ICodeMongoDB::FetchAsArray(array('elephpants.year' => array( '$gte' => 3000 ) ),'demo', 'circus'));


require_once('UrboshiArticle.class.php');


//UrboshiArticle::createNewArticle('b','abcdd',['a', 'b', 'c'],'zxccv','root/a.img',['name'=>'kuddus', 'id'=>'a'],['a', 't', 'p'],12,['name'=> 'ajaira','id'=>2]);

//var_dump(UrboshiArticle::getArticles());

//print_r(UrboshiArticle::getID('a'));

//print_r(UrboshiArticle::getArticlesV2(array(),array('title', 'tags', 'uploader_id','meta_image')));