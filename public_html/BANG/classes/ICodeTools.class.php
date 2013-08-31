<?php
class ICodeTools
{
    public static function parse_mysql_dump($url)
    {
        global $wpdb;
        $wpdb->show_errors();
        $file_content = file($url);
        $query='';
        foreach($file_content as $sql_line)
        {
            if(trim($sql_line) != "" && strpos($sql_line, "--") === false)
            {
                //echo $sql_line . '<br>';
                $query.=' '.$sql_line;
                if(strpos($sql_line,";")!==false)
                {
                    //echo $query. '<br>';      //make the table

                    if($wpdb->query($query)===false)
                    {
                        echo "<br> couldn't execute :$query<br>";
                        $_SESSION['invoiceError']= "<br> couldn't execute :$query<br>";
                        add_action('admin_notice',array('ICodeInvoiceTools','AdminNotice'));
                    }

                    $query='';
                }
            }
        }
        
        $wpdb->hide_errors();
    }
    public static function ICodeMail($emailaddress, $fromaddress, $emailsubject, $body,$fromName, $attachments=false)
    {
        $eol=PHP_EOL;    
        //$fromName='Abul Mal';
        //$fromaddress='tom.smith@sitecoms.com';
        $mime_boundary=md5(time());
        //echo"<br>here is the from address: $fromaddress<br>";
        # Common Headers
        $headers = "From: $fromName <".$fromaddress.'>'.$eol;
        //$headers .= "Reply-To: $fromName <".$fromaddress.'>'.$eol;
        //$headers .= "Return-Path: $fromName <".$fromaddress.'>'.$eol;    // these two to set reply address
        $headers .= "Content-ID: <".time()."system@".$_SERVER['SERVER_NAME'].">".$eol;
        //$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters

        # Boundry for marking the split & Multitype Headers
        $headers .= 'MIME-Version: 1.0'.$eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"".$eol;

        $msg = "";
       
        if ($attachments !== false)
        {

          for($i=0; $i < count($attachments); $i++)
          {
            if (is_file($attachments[$i]["file"]))
            {  
              # File for Attachment
              if(isset($attachments[$i]["fileName"]))
                  $file_name=$attachments[$i]["fileName"];
              else    
                  $file_name = substr($attachments[$i]["file"], (strrpos($attachments[$i]["file"], "/")+1));
              $handle=fopen($attachments[$i]["file"], 'rb');
              $f_contents=fread($handle, filesize($attachments[$i]["file"]));
              $f_contents=chunk_split(base64_encode($f_contents));    //Encode The Data For Transition using base64_encode();
              fclose($handle);
             
              # Attachment

              $msg .= "--".$mime_boundary.$eol;
              $msg .= "Content-Type: ".$attachments[$i]["content_type"]."; name=\"".$file_name."\"".$eol;
              $msg .= "Content-Transfer-Encoding: base64".$eol;
              $msg .= "Content-Disposition: attachment; filename=\"".$file_name."\"".$eol.$eol; // !! This line needs TWO end of lines !! IMPORTANT !!
              $msg .= $f_contents.$eol.$eol;

             
            }
          }
        }
                 
        /*
        # Setup for text OR html  
        $msg .= "--".$mime_boundary.$eol;
        //$msg .= "Content-Type: multipart/alternative boundary=\"".$mime_boundary."alt"."\"".$eol.$eol;

        # Text Version
        //$msg .= "--".$mime_boundary."alt".$eol;
        $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
        $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
        $msg .= $body.$eol.$eol;

        */
        # HTML Version            

        $msg .= "--".$mime_boundary.$eol;
        $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
        $msg .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
        $msg .= "<html><body>".$body."</body></html>".$eol.$eol;


        $msg .= "--".$mime_boundary."--".$eol.$eol;

        //echo "emailaddress:$emailaddress <br> subject: $emailsubject <br> body: $msg <br> headers: $headers";
                                                                         
        //echo '<pre>',$emailaddress, $emailsubject, $msg,'</pre>';
        //echo '<pre>',$emailaddress, $emailsubject, $msg,'</pre>';
        //echo '<pre>',$emailaddress, $emailsubject, $msg, $headers,'</pre>';
        //$error=mail($emailaddress, $emailsubject, $msg);
        $error=mail($emailaddress, $emailsubject, $msg, $headers);
        return $error;

    }

    function AdminNotice()
    {
        //echo $_SESSION['invoiceError'];
    }

    function GetPaging($numItems,$perPage,$curPage=1,$url)
    {
          $numPages=ceil(floatval($numItems)/$perPage);
          $pageNumbers="";
          for($i=1;$i<=$numPages;++$i)
          {
              if($i==$curPage)
                  $pageNumbers.="<span class='pagingCurrent'>$i</span> ";
              else
                  $pageNumbers.="<span  class='paging'><a href='$url&pageNo=$i'>$i</a></span>";
          }
          return $pageNumbers;
    }

    public static function IsInserted()
    {
        if(mysql_errno()!=0)
        {
            return false;
        }
        if(mysql_affected_rows() < 1)
              return false;
        return true;
    }

    public static function IsUpdated()
    {
        if(mysql_errno()!=0)
        {
            return false;
        }
        return true;
    }


    public static function QuoteArrayElements(&$item, $key)
    {
        $item = "'".$item."'";
    }

    public static function isValidURL($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }

    public static function DbInsert($tableName,$data)
    {
         global $wpdb;
         $fieldsArray = array_keys($data);
         $fields = implode(",",$fieldsArray);
         $values = implode(",",$data);
         $wpdb->show_errors();
         $sql="INSERT INTO $tableName($fields) VALUES($values)";
         //ICodeError::Log($sql);
         $insertResult = $wpdb->query($sql);
         $wpdb->hide_errors();
         if($insertResult!==FALSE)//insertion success
         {
             return $wpdb->insert_id;
         }
         else
         {
              return FALSE;
         }
    }

    public static function ShowErrors()
    {
        if(isset($_SESSION['ICodeInvoiceError']) && (count($_SESSION['ICodeInvoiceError']) > 0) )
        {
            echo implode('<br>',$_SESSION['ICodeInvoiceError']);
        }
    }


    public static function GetTableStatus($tableName)
    {
        global $wpdb;
        $sql = "SHOW TABLE STATUS LIKE '$tableName'";
        $wpdb->show_errors();
        $tableStatus = $wpdb->get_row($sql,ARRAY_A);
        $wpdb->hide_errors();
        return $tableStatus;
    }
                              
    public static function GetRawValue($fieldName,$alternate='none')
    {
        if(isset($_REQUEST[$fieldName])) //it can be userId or user_id
        {
            return $_REQUEST[$fieldName];
        }
        else if(isset($_REQUEST[$alternate])) //it can be userId or user_id
        {
            return $_REQUEST[$alternate];
        }
        return '';
    }      
    public static function GetValue($fieldName)
    {
        if(isset($_REQUEST[$fieldName]))
        {
            return ICodeFormValidation::AddSafeSlashes($_REQUEST[$fieldName]);
        }
        return '';
    }     
    public static function IfChecked($fieldName,$value='')
    {
        if(isset($_REQUEST[$fieldName]))
        {
            if($value=='')
                return 'Checked';
            if(is_array($_REQUEST[$fieldName]))
            {
                if(in_array($value))         
                    return 'Checked';
            }
            else
            {
                if(StripSlashes($_REQUEST[$fieldName]==$value))    
                    return 'Checked';
            }
        }
        return '';
    }
    public static function IfSelected($fieldName,$value)
    {
        if(isset($_REQUEST[$fieldName]))
        {
            if(is_array($_REQUEST[$fieldName]))
            {
                if(in_array($value))         
                    return 'Selected';
            }
            else
            {
                if(StripSlashes($_REQUEST[$fieldName]==$value))        
                    return 'Selected';
            }
        }
        return '';
    }                                 

    public static function IfCurrentLink($linkSlug, $echoClass='')
    {
        if(ICodeTools::CurrentScriptName() == $linkSlug.'.php')
        {
            if($echoClass!='')
            {
                echo ' class=',$echoClass,' ';
            }
            return true;
        }
        return false;
    }

    public static function IfCurrentPage($linkSlug, $echoClass='')
    {
        if(!isset($_GET['page']))
            return false;                                
        //echo "<br> here is your page:",$_GET['page'];
        if($_GET['page'] == $linkSlug)
        {
            if($echoClass!='')
            {
                return ' class='.$echoClass.' ';
            }
            return true;
        }
        return false;
    }

    public static function SubtractDate($first='now',$second,$addToSecond=0,$type='second')
    {
        if($first=='now')
            $firstTime=time();
        else
            $firstTime=strtotime($first);
        $secondTime=strtotime($second)+$addToSecond;
        $seconds=$firstTime-$secondTime;
        if($type=='day')
            return intval($seconds/86400);
        return $seconds;
    }


    public static function ICodeEval($code)
    {
        //echo"<br> executing code: $code ";
        return eval($code);
    }  
    public static function CurrentScriptName()
    {
        $array=explode('/',$_SERVER['SCRIPT_FILENAME']);
        return array_pop($array);
    }  
    public static function IsInObject($val, $obj)
    {
        //echo"<br> checking $val in ";
        //print_r($obj);
        if($val == "")
        {
            trigger_error("in_object expects parameter 1 must not empty", E_USER_WARNING);
            return false;
        }
        if(!is_object($obj))
        {
            $obj = (object)$obj;
        }
        //var_dump($obj);
        foreach($obj as $key => $value)
        {
            //echo "<br>checking key: $key";
            if(!is_object($value) && !is_array($value))
            {
                if($value == $val)
                {
                    return true;
                }
            }
            else
            {
                if( ICodeTools::IsInObject($val, $value))
                    return true;
            }
        }
        return false;
    }

    public static function ArrayToJSON($array)
    {
        return json_encode($array);
    }
    public static function GetIsReadLink($query)
    {
        global $CONFIGURATIONS;   
        $baseReadLink=$CONFIGURATIONS['BASE_URL'].'isRead.php?';
        $encryptedQ=ICodeTools::StringToToken($query);
        $readLink=$baseReadLink."token=".$encryptedQ;
        return "<img src='$readLink' width'0' height='0'>";
    }

    public static function ArrayFromQuery($query,$addToGet=false)
    {        
        $items=array_filter(explode('&',$query));
        $NVPairs=array();
        foreach($items as $anItem)
        {
            $itemArr=explode('=',$anItem);
            $NVPairs[$itemArr[0]]=$itemArr[1];
        }
        if($addToGet)
            $_GET=array_merge($_GET,$NVPairs);
        return $NVPairs;
    }
    public static function GetArrayFromToken()
    {
        $token=$_GET['token'];
        $q=base64_decode(rawurldecode($token));
        $NVPairs=ICodeTools::ArrayFromQuery($q);
        return $NVPairs;
    }
    public static function StringToToken($string)
    {
        return rawurlencode(base64_encode($string));
    }

    public static function ArrayToSet($array)
    {
        return "'".implode("','",$array)."'";
    }     
    public static function GetFileExtension($str)   //returns jpg,JPG gif,etc
    {
        $i = strrpos($str,".");
        if (!$i) { return ""; }

        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return strtolower($ext);
    }

    public static function DebugMessage($msg)
    {

        //EchoPre("<br>$msg<br>");
    }
    public static function ReturnError($errArr)
    {
        if(empty($errArr))
            return true;
        return "<br>".implode('<br>',$errArr)."<br>";
    }         
    public static function ArrayToXML($array)
    {
        //EchoPre($array);
        $xml='';
        foreach($array as $k=>$v)
            $xml.="<$k>$v</".$k.">";
        return $xml;
    } 

    /* pagination ideas */
    public static function GetPageNo()
    {
        $page=1;
        if(isset($_GET['pageNo']) && (int)$_GET['pageNo']>1)
           $page=$_GET['pageNo'];
        return $page;
    }

    public static function GetPaginationStart($pageNo,$limit=10)
    {
        return ($pageNo-1)*$limit;
    }

    /* Pagination ideas implemented */

    public static function SimpleEncrypt($text)
    {
        global $CONFIGURATIONS;
        $salt = $CONFIGURATIONS['SALT'];
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    public static function SimpleDecrypt($text)
    {
        global $CONFIGURATIONS;
        $salt = $CONFIGURATIONS['SALT'];
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }


}
?>              