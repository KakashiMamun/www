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



    print_r(UrboshiAuthor::getAuthors($author));


}


