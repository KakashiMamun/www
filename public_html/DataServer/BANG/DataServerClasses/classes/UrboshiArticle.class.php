<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/29/13
 * Time: 10:08 PM
 * To change this template use File | Settings | File Templates.
 */


require_once(realpath(dirname(__FILE__)).'/ICodeMongoDB.class.php');
require_once(realpath(dirname(__FILE__)).'/MongoAdminConfig.php');
require_once(realpath(dirname(__FILE__)).'/../../includes/adminConnection.php');
require_once(realpath(dirname(__FILE__)).'/../../classes/ICodeDB.class.php');
require_once(realpath(dirname(__FILE__)).'/../../classes/ICodeError.class.php');

class UrboshiArticle {

    private static $CollectionName = 'articles';
    public static function createNewArticle($ID,
                                            $title,
                                            $content,
                                            $meta_tags=array(),
                                            $meta_description,
                                            $meta_image,
                                            $authors = array(),
                                            $tags = array(),
                                            $uploader_id,
                                            $categories = array()
                                            )
    {
        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

        $article = array(
            'id' => $ID,
            'categories'=> $categories,
            'title' => $title,
            'content' => utf8_encode($content),
            'meta_tags'=> $meta_tags,
            'meta_description'=> $meta_description,
            'meta_image' => $meta_image,
            'authors' => $authors,
            'tags' => $tags,
            'uploader_id'=> $uploader_id
        );

//        var_dump($article);
//        var_dump($DB);
//        var_dump($Collection);

        $result  = ICodeMongoDB::Insert($article,$DB,$Collection);
//        var_dump($result);
        return $result;
        }

    public static function getArticles($ID = null)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

        if(isset($ID))
            $result = ICodeMongoDB::FetchAsCursor(array('id' => $ID),array(), $DB, $Collection);
        else
            $result = ICodeMongoDB::FetchAsCursor(array(),array(), $DB, $Collection);

        $result =  iterator_to_array($result);

        $resultSet = array();
        $i=0;
        foreach($result as $r)
            $resultSet[$i++] = $r;
        return $resultSet;

    }

    public static function getID($title)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

            $result = ICodeMongoDB::FetchAsCursor(array( 'title' => $title),array('id'), $DB, $Collection);

         $results = iterator_to_array($result);

        foreach($results as $result)
            return $result['id'];

    }

    public static function getArticlesV2($query,$fields)
    {
        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

        $result = ICodeMongoDB::FetchAsCursor($query,$fields, $DB, $Collection);

        return iterator_to_array($result);

    }

    public static function updateArticle($query,$fieldsToUpdate,$options)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

        $result = ICodeMongoDB::Update($query,$fieldsToUpdate,$options=array(),$DB,$Collection);


        return ($result);
    }

    public static function updateArticleV2($query,$criteria,$options)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

        $result = ICodeMongoDB::UpdateWithCriteria($query,$criteria,$options=array(),$DB,$Collection);
        return ($result);
    }


    public static function addTags($query, $tags, $options=array())
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

        $result = ICodeMongoDB::UpdateWithCriteria($query,array('$addToSet' => array('tags' => array('$each'=> $tags))),$options,$DB,$Collection);

    }

    public static function deleteArticle($query)
    {
        $DB = MongoConfig::getDBname();
        $Collection = UrboshiArticle::$CollectionName;

        //remove only one document of matching criteria
        $result = ICodeMongoDB::Remove($query,array("justOne" => true), $DB ,$Collection);

        return $result;

    }


}