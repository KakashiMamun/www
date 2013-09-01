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


function addCategoryToArticleBy($ID){


}



//createNewArticle('A title','Ki ar lekhbo!!', 'baaler tags','baal er desc','chaat er image amr',4,array('Food', 'Cooking', 'Western'),420,array(3,5,6));

