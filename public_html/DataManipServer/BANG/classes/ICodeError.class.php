<?php
                                                                                            
if(!class_exists('ICodeError'))
{
  abstract Class ICodeError
  {                                
      public static $VERSION=1.0;
      public static function Log($error,$module='',$function='', $type='warning')
      {
         $file=fopen(dirname(__FILE__)."/ErrorLog.txt","a+");  
         fwrite($file,"\r\n\r\n".time()."\r\nScript {$_SERVER['REQUEST_URI']}: \n$error");
         fclose($file);
         $insert="Insert into icode_error(uri,content, module, function, type)
                        values
                        ('{$_SERVER['REQUEST_URI']}', '$error', '$module', '$function', '$type')";
         return Db::getInstance()->Execute($insert);
      }
      public static function LogAndStop($error,$module='',$function='', $type='warning')
      {    
         $file=fopen(dirname(__FILE__)."/ErrorLog.txt","a+");
         fwrite($file,"\r\n\r\n".time()."\r\nScript {$_SERVER['REQUEST_URI']} stopped due to:\n$error");
         fclose($file);   
         $insert="Insert into icode_error(uri,content, module, function, type)
                        values
                        ('{$_SERVER['REQUEST_URI']}', '$error', '$module', '$function', '$type')";
         return Db::getInstance()->Execute($insert);
         exit();

      }          
      public static function LogREQUEST($module='',$function='')
      {
                                     
          $log='****************************************POST Data\n****************************************\n';
          $log.=print_r($_POST,true);
          $log.='****************************************GET Data\n****************************************\n';
          $log.=print_r($_GET,true);
          $log.='****************************************COOKIE Data\n****************************************\n';
          $log.=print_r($_COOKIE,true);
          $log.='****************************************End of request ****************************************';
          ICodeError::Log($log,$module,$function);

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
}

?>