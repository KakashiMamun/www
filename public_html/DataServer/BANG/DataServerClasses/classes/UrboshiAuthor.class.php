<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */



require_once('ICodeMongoDB.class.php');
require_once('MongoAdminConfig.php');



class UrboshiAuthor {


    private static $CollectionName = 'authors';

//    public static function GetNextAuthorID(){
//
//        $command  = 'db.eval("getNextSequence(\'next_author_no\')")';
//
//        $record = ICodeMongoDB::Execute($command, 'DataServer');
//
//
//        if(isset($record['retval'])){
//            return $record['retval'];
//        }else{
//
//            echo 'Error in Next author ID generation';
//        }
//
//    }

    public static function createNewAuthor($ID,$name)
    {


        $DB = MongoConfig::getDBname();
        $Collection = UrboshiAuthor::$CollectionName;

//        $ID = UrboshiAuthor::GetNextAuthorID();

        $author = array(
            'id' => $ID,
            'name'=> $name
        );
        $result  = ICodeMongoDB::Insert($author,$DB,$Collection);
        return $result;

    }


    public static function getID($name)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiAuthor::$CollectionName;


        $result = ICodeMongoDB::FetchAsCursor(array( 'name' => $name),array('id'), $DB, $Collection);

        return iterator_to_array($result);
    }

    public static function getAuthors($ID = null)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiAuthor::$CollectionName;


        if(isset($ID))
            $result = ICodeMongoDB::FetchAsCursor(array('id' => $ID),array(), $DB, $Collection);
        else
            $result = ICodeMongoDB::FetchAsCursor(array(),array(), $DB, $Collection);

        return iterator_to_array($result);

    }

    public static function getAuthorsV2($query,$fields)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiAuthor::$CollectionName;

        $result = ICodeMongoDB::FetchAsCursor($query,$fields, $DB, $Collection);

        return iterator_to_array($result);

    }



    public static function updateAuthor($query,$fieldsToUpdate,$options)
    {

        $DB = MongoConfig::getDBname();
        $Collection = UrboshiAuthor::$CollectionName;

        $result = ICodeMongoDB::Update($query,$fieldsToUpdate,$options=array(),$DB,$Collection);


        return ($result);
    }


    public static function deleteAuthor($query)
    {


        $DB = MongoConfig::getDBname();
        $Collection = UrboshiAuthor::$CollectionName;

        //remove only one document of matching criteria
        $result = ICodeMongoDB::Remove($query,array("justOne" => true), $DB ,$Collection);

        return $result;

    }

    public static function getAuthorsInfo($authors)
    {

        $i = 0;
        if(is_array($authors)){
            foreach($authors as $author)
            {
                $authorInfo = UrboshiAuthor::getAuthors((int)$author);

                foreach($authorInfo as $authorObj)
                {
                    $authorList[$i]['id'] = $authorObj['id'];
                    $authorList[$i]['name'] = $authorObj['name'];
                }
                $i++;
            }
        }else
        {
            $authorInfo = UrboshiAuthor::getAuthors($authors);

            foreach($authorInfo as $authorObj){
                $authorList[$i]['id'] = $authorObj['id'];
                $authorList[$i]['name'] = $authorObj['name'];
            }
        }

        if(isset($authorList))
            return ($authorList);
        else
        {
            $error =  'No such author';
            ICodeError::Log($error,'UrboshiAuthor.Class','getAuthorsInfo','Error');
        }
    }



}