<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/19/13
 * Time: 1:51 PM
 * To change this template use File | Settings | File Templates.
 */





require_once('../includes/frontIncludes.php');

    global $CONFIGURATIONS;
    removeExpiredSession();
    shrinkSizeTo(getPercentage($CONFIGURATIONS['SESSION_TABLE_SIZE']));


?>

<?php

    function removeExpiredSession(){
        $sql =  "DELETE FROM Bang.session_table WHERE exp_date <= NOW();";

        ICodeDB::FreshInsert($sql);

    }

    function shrinkSizeTo($percent){
        $sql = "SELECT table_schema,table_name,table_rows
                    FROM information_schema.TABLES
                    WHERE table_schema = 'Bang' and table_name = 'session_table';";
        $result = ICodeDB::GetResultRow($sql);
        $rows = $result['table_rows'];
        $rowsToRemove = floor($rows*$percent*0.01);

        $sql = "SELECT user_id FROM Bang.session_table ORDER BY exp_date LIMIT $rowsToRemove;";
        $userRowSet = ICodeDB::GetResultsSet($sql);

        foreach($userRowSet as $user){
            $id = $user['user_id'];
            $sql = "DELETE FROM Bang.session_table where user_id = $id ;";
            ICodeDB::FreshInsert($sql);
        }
    }
    function getTableSize(){

        $sql = "SELECT table_schema,table_name,
                  table_rows,
                  data_length,
                  index_length,
                  concat(round(sum(data_length+index_length))) total_size,
                  round(sum(index_length)/sum(data_length),2) index_fraction
                FROM information_schema.TABLES
                WHERE table_schema = 'Bang' and table_name = 'session_table'";
        $tableInfo = ICodeDB::GetResultRow($sql);

        return $tableInfo['table_rows'];
    }

    function getPercentage($size){

        $curSize = getTableSize();
        $percentage = 0;

        if($curSize > $size){
            $percentage = floor(($size/$curSize)*100);
        }

        return $percentage;

    }

    

?>









