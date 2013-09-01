<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 3:20 PM
 * To change this template use File | Settings | File Templates.
 */


require_once('UrboshiArticle.class.php');
require_once('UrboshiCategory.class.php');
require_once('UrboshiAuthor.class.php');

function createNewCategory($name){
    UrboshiCategory::createNewCategory($name);
}
function createNewAuthor($name){
    UrboshiAuthor::createNewAuthor($name);
}

function createNewArticle($title,
                          $content,
                          $meta_tags,
                          $meta_description,
                          $meta_image,
                          $authors,
                          $tags,
                          $uploader_id,
                          $categories){



    $authorsInfo = (UrboshiAuthor::getAuthorsInfo($authors));

    $categoryInfo = UrboshiCategory::getCategoriesInfo($categories);

    $result = UrboshiArticle::createNewArticle($title,$content,$meta_tags,$meta_description,$meta_image,$authorsInfo,$tags,$uploader_id,$categoryInfo);

//    print_r($result);

    if(isset($result['ok']))
    {
        foreach($categoryInfo as $category){
            $ID = UrboshiArticle::getID($title);
            UrboshiCategory::addArticles($category,array('id' => $ID,'title' => $title));
        }
    }else{

        echo 'Article Insertion Error';
    }
}


function updateArticle($ID,$title,$content,$meta_tags,$meta_decscription,$meta_image,$tags,$uploader_id){


    $updateFields = array(
        'title' => $title,
        'content' => $content,

        'meta_tags'=> $meta_tags,
        'meta_description'=> $meta_decscription,
        'meta_image' => $meta_image,

        'tags' => $tags,
        'uploader_id'=> $uploader_id
    );


    $result = UrboshiArticle::updateArticle(array('id' => $ID),$updateFields,array());

    print_r($result);
}


function getArticleByID($ID){

    $result = UrboshiArticle::getArticles($ID);
    if(!empty($result))
        print_r($result);
    else
        echo 'No Such article';
}

function getArticleByTitle($title){

     $ID = UrboshiArticle::getID($title);

    if(isset($ID)){
        $result = UrboshiArticle::getArticles($ID);
        print_r($result);
    }else
        echo 'No Such article';

}

function deleteArticleByID($ID){

    $result = UrboshiArticle::deleteArticle(array('id' => $ID));
    if($result['n'] == 1)
    {
        UrboshiCategory::removeArticles(array(),$ID, array('multiple' => true));
    }
//    print_r($result);
}
//createNewArticle('A title','Ki ar lekhbo!!', 'baaler tags','baal er desc','chaat er image amr',4,array('Food', 'Cooking', 'Western'),420,array(3,5));
//updateArticle(2,'An Updated title','Update korlam!!', 'baaler tags2','baal er desc2','chaat er image amr2',array('Food', 'Cooking'),401);
//getArticleByID(2);
//getArticleByTitle('An Updated title');
//deleteArticleByID(6);