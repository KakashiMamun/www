<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */

class UrboshiAuthor {



    public static function GetNextAuthorID(){

        $command  = 'db.eval("getNextSequence(\'next_author_no\')")';

        $record = ICodeMongoDB::Execute($command, 'Urboshi');


        if(isset($record['retval'])){
            return $record['retval'];
        }else{

            echo 'Error in Next author ID generation';
        }

    }
    public static function createNewAuthor($name){


        $DB = 'Urboshi';
        $Collection = 'Authors';
        $ID = UrboshiAuthor::GetNextAuthorID();

        $author = array(
            'id' => $ID,
            'name'=> $name
        );
        $result  = ICodeMongoDB::Insert($author,$DB,$Collection);
        return $result;

    }


    public static function getID($name){

        $DB = 'Urboshi';
        $Collection = 'Authors';

        $result = ICodeMongoDB::FetchAsCursor(array( 'name' => $name),array('id'), $DB, $Collection);

        return iterator_to_array($result);
    }

    public static function getAuthors($ID = null){

        $DB = 'Urboshi';
        $Collection = 'Authors';

        if(isset($ID))
            $result = ICodeMongoDB::FetchAsCursor(array('id' => $ID),array(), $DB, $Collection);
        else
            $result = ICodeMongoDB::FetchAsCursor(array(),array(), $DB, $Collection);

        return iterator_to_array($result);

    }

    public static function getAuthorsV2($query,$fields){

        $DB = 'Urboshi';
        $Collection = 'Authors';

        $result = ICodeMongoDB::FetchAsCursor($query,$fields, $DB, $Collection);

        return iterator_to_array($result);

    }



    public static function updateAuthor($query,$fieldsToUpdate,$options){

        $DB = 'Urboshi';
        $Collection = 'Author';


        $result = ICodeMongoDB::Update($query,$fieldsToUpdate,$options=array(),$DB,$Collection);


        return ($result);
    }


    public static function deleteAuthor($query){


        $DB = 'Urboshi';
        $Collection = 'Author';

        //remove only one document of matching criteria
        $result = ICodeMongoDB::Remove($query,array("justOne" => true), $DB ,$Collection);

        return $result;

    }



}