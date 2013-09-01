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





}


function getAuthorInfo($authors){

    $i = 0;
    if(is_array($authors)){
        foreach($authors as $author){
            $authorInfo = UrboshiAuthor::getAuthors($author);

            foreach($authorInfo as $authorObj){
                $authorList[$i]['id'] = $authorObj['id'];
                $authorList[$i]['name'] = $authorObj['name'];
            }

            $i++;
        }
    }else{
        $authorInfo = UrboshiAuthor::getAuthors($authors);

        foreach($authorInfo as $authorObj){
            $authorList[$i]['id'] = $authorObj['id'];
            $authorList[$i]['name'] = $authorObj['name'];
        }
    }

    if(isset($authorList))
        return ($authorList);
    else
        echo 'No such author';
}


//createNewArticle('a','Ki ar lekhbo!!', 'baaler tags','baal er desc','chaat er image amr',4,array('Porn', 'orgy', 'group'),420,5);

