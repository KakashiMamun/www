<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/29/13
 * Time: 10:08 PM
 * To change this template use File | Settings | File Templates.
 */


require_once('ICodeMongoDB.class.php');

class UrboshiArticle {

    public static function createNewArticle($title,
                                            $content,
                                            $meta_tags=array(),
                                            $meta_description,
                                            $meta_image,
                                            $authors = array(),
                                            $tags = array(),
                                            $uploader_id,
                                            $categories = array()
    ){




        $DB = 'Urboshi';
        $Collection = 'Articles';
        $ID = UrboshiArticle::GetNextArticleID();

        $article = array(

            'id' => $ID,
            'categories'=> $categories,
            'title' => $title,
            'content' => $content,
            'meta_tags'=> $meta_tags,
            'meta_description'=> $meta_description,
            'meta_image' => $meta_image,
            'authors' => $authors,
            'tags' => $tags,
            'uploader_id'=> $uploader_id
        );

        $result  = ICodeMongoDB::Insert($article,$DB,$Collection);


        return $result;
        }

    public static function GetNextArticleID(){

            $command  = 'db.eval("getNextSequence(\'next_article_no\')")';

            $record = ICodeMongoDB::Execute($command, 'Urboshi');


            if(isset($record['retval'])){
                return $record['retval'];
            }else{

                echo 'Error in Next article ID generation';
            }

        }


    public static function getArticles($ID = null){

        $DB = 'Urboshi';
        $Collection = 'Articles';

        if(isset($ID))
            $result = ICodeMongoDB::FetchAsCursor(array('id' => $ID),array(), $DB, $Collection);
        else
            $result = ICodeMongoDB::FetchAsCursor(array(),array(), $DB, $Collection);

        return iterator_to_array($result);

    }

    public static function getID($title){

        $DB = 'Urboshi';
        $Collection = 'Articles';

            $result = ICodeMongoDB::FetchAsCursor(array( 'title' => $title),array('id'), $DB, $Collection);

        return iterator_to_array($result);
    }

    public static function getArticlesV2($query,$fields){

        $DB = 'Urboshi';
        $Collection = 'Articles';

        $result = ICodeMongoDB::FetchAsCursor($query,$fields, $DB, $Collection);

        return iterator_to_array($result);

    }

    public static function updateArticle($query,$fieldsToUpdate,$options){

        $DB = 'Urboshi';
        $Collection = 'Articles';


        $result = ICodeMongoDB::Update($query,$fieldsToUpdate,$options=array(),$DB,$Collection);


        return ($result);
    }


    public static function addTags($query, $tags, $options=array()){

        $DB = 'Urboshi';
        $Collection = 'Articles';


            $result = ICodeMongoDB::UpdateWithCriteria($query,array('$addToSet' => array('tags' => array('$each'=> $tags))),$options,$DB,$Collection);

    }

    public static function deleteArticle($query){


        $DB = 'Urboshi';
        $Collection = 'Articles';

        //remove only one document of matching criteria
        $result = ICodeMongoDB::Remove($query,array("justOne" => true), $DB ,$Collection);

        return $result;

    }


}