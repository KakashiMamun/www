<?php

// NOW IN DB
// NOW ALL THE ERROR REPORTING CAN BE TURNED OF THROUGH CONFIGURATION!!!!!!!!!!!!!!!!!!
abstract Class ICodeError
{          
    public static function Log($error)
    {
       $file=fopen(dirname(__FILE__)."/ErrorLog.txt","a+");  
       fwrite($file,"\r\n\r\n".time()."\r\nScript {$_SERVER['REQUEST_URI']}: \n$error");
       fclose($file);
    }
    public static function LogAndStop($error)
    {    
       $file=fopen(dirname(__FILE__)."/ErrorLog.txt","a+");
       fwrite($file,"\r\n\r\n".time()."\r\nScript {$_SERVER['REQUEST_URI']} stopped due to:\n$error");
       fclose($file);
       exit();

    }          
    public static function LogREQUEST()
    {
                                   
        $log='****************************************POST Data\n****************************************\n';
        $log.=print_r($_POST,true);
        $log.='****************************************GET Data\n****************************************\n';
        $log.=print_r($_GET,true);
        $log.='****************************************COOKIE Data\n****************************************\n';
        $log.=print_r($_COOKIE,true);
        $log.='****************************************End of request ****************************************';
        ICodeError::Log($log);

    }   
    public static function GetErrorHtml($array)
    {
        $html='';
        foreach($array as $anError)
           $html.=$anError."<br>";
        return $html;
    }
    /*
    public static function ()
    {

    }
    */
}

?>