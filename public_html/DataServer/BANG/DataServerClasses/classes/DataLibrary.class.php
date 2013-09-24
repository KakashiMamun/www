<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 3:20 PM
 * To change this template use File | Settings | File Templates.
 */


require_once(realpath(dirname(__FILE__)).'/../includes/LibraryIncludes.php');
class DataLibrary
{


    public static function createNewCategory($ID,$name)
    {
        if($name)
            return UrboshiCategory::createNewCategory($ID,$name);

    }
    public static function createNewAuthor($name)
    {
        UrboshiAuthor::createNewAuthor($name);
    }

    public static function createNewArticle(
                              $ID,
                              $title,
                              $content,
                              $meta_tags,
                              $meta_description,
                              $meta_image,
                              $authors,
                              $tags,
                              $uploader_id,
                              $categories)
    {
        $authorsInfo = (UrboshiAuthor::getAuthorsInfo($authors));

//        var_dump($authorsInfo);
        $cIds = array();
        $i=0;
        foreach($categories as $c)
        {
            $cIds[$i++] = UrboshiCategory::getID($c);

        }

        $categoryInfo = UrboshiCategory::getCategoriesInfo($cIds);



        $result = UrboshiArticle::createNewArticle($ID,$title,$content,$meta_tags,$meta_description,$meta_image,$authorsInfo,$tags,$uploader_id,$categoryInfo);

//        var_dump($result);

        if(isset($result['ok']))
        {
            foreach($categoryInfo as $category)
            {
                $ID = UrboshiArticle::getID($title);
                UrboshiCategory::addArticles($category,array('id' => $ID,'title' => $title));
            }

            $msg =  'Article Insertion Successfull';
            ICodeError::Log($msg,'DataLibrary.Class','createNewArticle','Notify');
            return true;
        }else
        {
            $error =  'Article Insertion Error';
            ICodeError::Log($error,'DataLibrary.Class','createNewArticle','Notify');
            return false;
        }
    }


    public static function updateArticle($ID,$title,$content,$meta_tags,$meta_decscription,$meta_image,$tags,$uploader_id)
    {


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

        return ($result);

    }


    public static function getArticleByID($ID){

        $result = UrboshiArticle::getArticles($ID);
        if(!empty($result))
            return ($result);
        else
        {
            $error =  'No Such article';
            ICodeError::Log($error,'DataLibrary.Class','getArticleByID','Error');
        }

    }

    public static function getArticleByTitle($title){

         $ID = UrboshiArticle::getID($title);

        if(isset($ID)){
            $result = UrboshiArticle::getArticles($ID);
            print_r($result);
        }else
        {
            $error =  'No Such article';
            ICodeError::Log($error,'DataLibrary.Class','getArticleByTitle','Error');
        }
    }

    public static function getArticles(){
        $result = UrboshiArticle::getArticles();
        return($result);
    }

    public static function deleteArticleByID($ID){

        $result = UrboshiArticle::deleteArticle(array('id' => $ID));
        if($result['n'] == 1)
        {
            UrboshiCategory::removeArticles(array(),$ID, array('multiple' => true));
        }
        else
        {
            $error = 'No article is matched and deleted';
            ICodeError::Log($error,'DataLibrary.Class','deleteArticleByID','Warning');

        }

    }

    public static function getCategories($nameLike = null){

        $fields = array('name','id');
        if($nameLike){
            $query = array('name' => new MongoRegex("/.*$nameLike.*/"));

            $result = UrboshiCategory::getCatgeoriesV2($query,$fields);
        }else{

            $result = UrboshiCategory::getCatgeoriesV2(array(),$fields);
        }

         return ($result);
    }
}

//createNewCategory('New Category');
//createNewAuthor('NewAuthor');
//createNewArticle('A 2nd title','Ki ar lekhbo!!', ' tags',' desc','  image ',4,array('Food', 'Cooking', 'Western'),420,array(3,5));
//updateArticle(2,'An Updated title','Update korlam!!', 'baaler tags2','baal er desc2','chaat er image amr2',array('Food', 'Cooking'),401);
//getArticleByID(2);
//getArticleByTitle('An Updated title');
//getArticles();
//deleteArticleByID(6);
//getCategories('');