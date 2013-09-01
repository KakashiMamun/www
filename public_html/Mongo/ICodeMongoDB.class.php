<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/28/13
 * Time: 2:05 AM
 * To change this template use File | Settings | File Templates.
 */

require_once('MongoAdminConfig.php');
class ICodeMongoDB {


    private static function isDatabaseExists($con, $DB){

        $databases = $con->listDBs();
        foreach($databases['databases'] as $db){

            if($db['name'] == $DB){
                return true;
            }

        }
        return false;

    }


    private static function isCollectionExists($db, $Collection){

        $col = $db->selectCollection($Collection);
        $AllCol = $db->listCollections();

        foreach($AllCol as $Col){
            if($Col->getName() == $col->getName())
                return true;
        }
        return false;

        }



    private static function selectDatabasse($con,$DB){
        if(!ICodeMongoDB::isDatabaseExists($con, $DB)){

            echo 'No such Database named: '. $DB;
            return;
        }else{
//            echo 'Database Ok';
        }
        $db = $con->selectDB($DB);
        return $db;
    }

    private static function selectCollection($db,$Collection){

        if(!ICodeMongoDB::isCollectionExists($db, $Collection)){

            echo "No such Collection in $db named: $Collection";
            return;
        }else{
//        echo 'Collection Ok';
        }
        $col = $db->selectCollection($Collection);
        return $col;
    }

    public static function CountDocument($DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        echo $col->count();
    }

    public static function Insert($Document,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
        $result = $col->insert($Document,array( 'safe' => true ));
        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }
        return $result;
    }


    public static function FetchAsCursor($Query,$Criteria,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->find($Query,$Criteria);
        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }
        return $result;
    }


    public static function FetchAsArray($Query,$Criteria,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->find($Query,$Criteria);
        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }

        $result = iterator_to_array($result);
        return $result;
    }




    public static function FetchOneDocAsCursor($Query,$Criteria,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->findOne($Query,$Criteria);
        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }
        return $result;
    }


    public static function FetchOneDocAsArray($Query,$Criteria,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->findOne($Query,$Criteria);
        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }

        $result = iterator_to_array($result);
        return $result;
    }



    //Replace only Replaces the first document it finds by default.Use Options as array( 'multiple' => true ) for multiple change



    public static function Replace($Query,$NewDocument,$Options,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->update($Query,$NewDocument,$Options);//update() replaces the document matching criteria entirely with a new object.

        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }

//        $result = iterator_to_array($result);
        return $result;
    }


    //Update only updates the first document it finds by default.Use Options as array( 'multiple' => true ) for multiple change

    public static function Update($Query,$UpdateFields,$Options,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->update($Query,array('$set' => $UpdateFields),$Options);
            //update() replaces the document matching criteria entirely with a new object.
            //but $set only updates the fields or add new fields

        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }

//        $result = iterator_to_array($result);
        return $result;
    }


    //Update only updates the first document it finds by default.Use Options as array( 'multiple' => true ) for multiple change


    public static function UpdateWithCriteria($Query,$CriteriaAndUpdates,$Options,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->update($Query,$CriteriaAndUpdates,$Options);
            //update() replaces the document matching criteria entirely with a new object.
            //but $set only updates the fields or add new fields

        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }

//        $result = iterator_to_array($result);
        return $result;
    }



    /*
        What’s the difference between update, insert, and save?
        Save is simply a wrapper for insert and update. If an _id is provided, it will update;
        otherwise, it will insert. You can safely use save pretty much all the time, unless you
        want to be very explicit as to which of the two operations you are performing.
     */

    public static function Save($Document,$Options,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->save($Document,$Options);


        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }

//        $result = iterator_to_array($result);
        return $result;
    }



    /*
     *  Unlike update, the remove method by default will remove all documents
        matching the provided criteria. There is an additional optional param-
        eter, which is an array of options. One of these is justOne, which would
        limit the deletion to a single document. As a best practice, justOne
        should be used wherever it is applicable.

     */
    public static function Remove($Query,$Options,$DB,$Collection){

        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $col = ICodeMongoDB::selectCollection($db,$Collection);

        try{
            $result = $col->remove($Query,$Options);


        }catch(Exception $ex)
        {
            return $ex->getMessage();
        }

//        $result = iterator_to_array($result);
        return $result;
    }


    /*
     * Execute DB commands
     */

    public static function  Execute($command,$DB){


        $con = MongoConfig::GetNewConnection();

        $db = ICodeMongoDB::selectDatabasse($con,$DB);

        $record = $db->execute($command);

        return $record;


}



}