<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 11:19 AM
 * To change this template use File | Settings | File Templates.
 */

require_once('MongoDB/ICodeMongoDB.class.php');

class UrboshiCategory {

    public static function GetNextCategoryID(){

        $command  = 'db.eval("getNextSequence(\'next_category_no\')")';

        $record = ICodeMongoDB::Execute($command, 'Urboshi');


        if(isset($record['retval'])){
            return $record['retval'];
        }else{

            echo 'Error in Next category ID generation';
        }

    }



    public static function createNewCategory($name){

        $DB = 'Urboshi';
        $Collection = 'Categories';
        $ID = UrboshiCategory::GetNextCategoryID();

        $category = array(

            'id' => $ID,
            'name' => $name,
            'articles' => array()
        );

        $result  = ICodeMongoDB::Insert($category,$DB,$Collection);

        return $result;
    }


    public static function getCategories($ID = null){

        $DB = 'Urboshi';
        $Collection = 'Categories';

        if(isset($ID))
            $result = ICodeMongoDB::FetchAsCursor(array('id' => $ID),array(), $DB, $Collection);
        else
            $result = ICodeMongoDB::FetchAsCursor(array(),array(), $DB, $Collection);

        return iterator_to_array($result);

    }


    public static function getID($name){

        $DB = 'Urboshi';
        $Collection = 'Catgeories';

        $result = ICodeMongoDB::FetchAsCursor(array( 'name' => $name),array('id'), $DB, $Collection);

        return iterator_to_array($result);
    }

    public static function getCatgeoriesV2($query,$fields){

        $DB = 'Urboshi';
        $Collection = 'Categories';

        $result = ICodeMongoDB::FetchAsCursor($query,$fields, $DB, $Collection);

        return iterator_to_array($result);

    }

    public static function updateCategory($query,$fieldsToUpdate,$options){

        $DB = 'Urboshi';
        $Collection = 'Categories';


        $result = ICodeMongoDB::Update($query,$fieldsToUpdate,$options=array(),$DB,$Collection);


        return ($result);
    }


    public static function addArticles($query, $articles, $options=array()){

        $DB = 'Urboshi';
        $Collection = 'Categories';

        $result = ICodeMongoDB::UpdateWithCriteria($query,array('$addToSet' => array('articels' => array('$each'=> $articles))),$options,$DB,$Collection);

    }


    public static function removeArticles($query, $articles, $options=array()){

        $DB = 'Urboshi';
        $Collection = 'Categories';

        $result = ICodeMongoDB::UpdateWithCriteria($query,array('$popAll' => array('articles'=> $articles)),$options,$DB,$Collection);

    }

    public static function deleteCategory($query){


        $DB = 'Urboshi';
        $Collection = 'Category';

        //remove only one document of matching criteria
        $result = ICodeMongoDB::Remove($query,array("justOne" => true), $DB ,$Collection);

        return $result;

    }

}