<?php
    class ICodeDB
    {
        //Dependancy formValidation.php, a connection file
        //common DB
        
        public static function LockTables($tableList)
        {       

            $tableList=str_replace(',',' write,',$tableList).' write';
            mysql_query("lock tables $tableList");
            if(mysql_errno()!=0)
            {
                echo "<b>lock tables $tableList</b>";
                echo mysql_error();
                return false;
            }
            return true;

        }
        public static function UnlockTables($tableList)
        {       

            mysql_query("unlock tables");
            if(mysql_errno()!=0)
            {                           
                echo "<b>unlock tables</b>";
                echo mysql_error();
                return false;
            }
            return true;
        }       
        public static function Replace($replace)
        {

            //echo"<br>$replace";
            mysql_query($replace);
            if(mysql_errno()!=0)
            {                       
                echo"<b>$replace</b>";
                echo mysql_error();
                return false;
            }
            if(mysql_affected_rows()<1)
                return false;
            return true;
        }
        public static function FreshInsert($insert)
        {

           // echo"<br>$insert";
            mysql_query($insert);
            if(mysql_errno()!=0)
            {
                echo"<b>$insert</b>";
                echo mysql_error();
                return false;
            }
            if(mysql_affected_rows()<1)
            {
                echo"<b>",mysql_affected_rows();
                return false;
            }
            return true;
        }
        public static function FreshInsertAndGetId($insert,$locktables)
        {

            //echo"<br>$insert";
            ICodeDB::LockTables($locktables);
            mysql_query($insert);
            //echo "<br>",mysql_error(),"<br>";
            if(mysql_errno()!=0)
            {
                echo"<b>$insert</b>";
                echo mysql_error();
                ICodeDB::UnlockTables($locktables);
                return 0;
            }
            if(mysql_affected_rows()!=1)
            {      
                ICodeDB::UnlockTables($locktables);
                return 0;
            }
            $id=mysql_insert_id();
            ICodeDB::UnlockTables($locktables);
            return $id;
        }
        public static function Update($update)
        {
           // echo"<br>$update";
            mysql_query($update);
            //echo"<br>mysql error no:",mysql_errno(),"<br>";
            if(mysql_errno()!=0)
            {
                echo"<b>$update</b>";
                echo mysql_error();
                return false;
            }
            return true;
        }
        
        public static function Delete($delete)
        {

            mysql_query($delete);
            if(mysql_errno()!=0)
            {              
                echo"<b>$delete</b>";
                echo mysql_error();
                return false;
            }
            return true;
        }         
        public static function GetResultsSet($query)
        {
            $set=array();
            $res=mysql_query($query);

            if(mysql_errno()!=0)
            {
                echo"<b>$query</b>";
                echo mysql_error();
            }
            while($row=mysql_fetch_assoc($res))
            {
                $row=ICodeFormValidation::StripSlashesDeep($row);
                $set[]=$row;
            }
            return $set;
        }
        public static function GetResultRow($query)
        {                  
            $row=array();
            $res=mysql_query($query);
            //echo $query;
            if(mysql_errno()!=0)
            {
                echo"<b>$query</b>";
                echo mysql_error();
            }
            if($row=mysql_fetch_assoc($res))
            {
                $row=ICodeFormValidation::StripSlashesDeep($row);
            }
            return $row;
        }
        public static function ArrayToMysqlSet($array)
        {
            //EchoPre($array);
            $set='';
            $comma='';
            foreach($array as $a)
            {
                $set.= $comma. "'$a'";
                $comma=',';
            }
            return $set;
        }
        public static function IsKeyUsed($table,$field,$value,$condition='') //to be used to check for unique fields
        {
            $q="Select $field from $table where $field='$value' $condition";
            $row=ICodeDB::GetResultRow($q);
            if(empty($row))
                return false;
            return true;
        }

    }
?>