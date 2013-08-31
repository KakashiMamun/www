<?php

    //page attributes
    function PageTitle()
    {
    }
    function PageMeta()
    {
    }


    //member related
    
   function MemberStatus($username, $type='business')  //return 0 for suspended,1 for active, 2 for pending
   {
       $get="select status from member where member_id='$username'";
       $res=mysql_query($get);
       if(mysql_num_rows($res)==1)
       {
           $row=mysql_fetch_row($res);
           return $row[0];
       }
       return 'not a member';
   }

   function IsUser($userId,$password)
   {
       return true;
   }

   function RetrivePassword($email,$username, $type='business')//must addslashes before passing to this function
   {
       $get="select password from member where email='$email' and member_id='$username'";
       //echo $get;
       $res=mysql_query($get);
       if(mysql_num_rows($res)==0)
           return "No match for the email and username given. Please contact administrator or try again";
       $row=mysql_fetch_row($res);
       mail($email,'Password',"Your password is: ".$row[0]);
       return "Password sent. Check your email box";
   }

   
   function LoginMember($id,$pass, $type='business')
   {
       $query="select status from member where member_id='$id' and password='$pass'";
       $res=mysql_query($query);
       if(mysql_num_rows($res)==1)
       {
           $row=mysql_fetch_row($res); 
           if(strcasecmp($row[0],'inactive')==0)
               return 2;
           if(strcasecmp($row[0],'pending')==0)
               return 3;
           return 1;
       }
           
       else
           return -1;
   }
   function RequireVerification($loginUrl)
   {
       global $verifiedMember;  
       global $memberId;
       global $memberPassword;    
       global $remember,$MEMBER_URL;
       if($verifiedMember==0)
       {                                                                 
         header("Location:$loginUrl?loginError=you are not logged in");
         exit();
       }          
       if($verifiedMember==-1)
       {
         header("Location:$loginUrl?loginError=username or id is wrong");
         exit();
       }    
       if($verifiedMember==1)
       {
         setcookie('memberId',StripSlashes($memberId),time()+$remember,'/');
         setcookie('memberPassword',StripSlashes($memberPassword),time()+$remember,'/');
         setcookie('remember',$remember,time()+$remember,'/');
       }  
       if($verifiedMember==2)
       {
         setcookie('memberId','',time()+$remember,'/');
         setcookie('memberPassword','',time()+$remember,'/');
         setcookie('remember','',time()+$remember,'/');
         header("Location:$loginUrl?loginError=This account is waiting for approval or is disabled");
         exit();
       }    
       if($verifiedMember==3)
       {
         setcookie('memberId','',time()+$remember,'/');
         setcookie('memberPassword','',time()+$remember,'/');
         setcookie('remember','',time()+$remember,'/');
         header("Location:$loginUrl?loginError=This account is not verified by email address you provided. If you didn't get the email <a href='{$MEMBER_URL}resendVerificationEmail.php?memberId=$memberId'>Click here</a>. ");
         exit();
       }
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

    

   function GetDays()
   {
   
    for($i=1;$i<32;$i++)
        echo"<option value='$i'>$i</option>";
   }
      
   function GetMonths()
   {
       Echo"<option value='01' selected='selected'>Jan</option><option value='02'>Feb</option><option value='03'>Mar</option><option value='04'>Apr</option><option value='05'>May</option><option value='06'>Jun</option><option value='07'>Jul</option><option value='08'>Aug</option><option value='09'>Sep</option><option value='10'>Oct</option><option value='11'>Nov</option><option value='12'>Dec</option>";

   }
   function GetYears()
   {       
      $curYear=intval(date('Y',time()));
      for($i=1900;$i<$curYear;$i++)
          echo"<option value='$i'>$i</option>";
   } 
   
   //  Regfunctions.......
   function GetCountries()
    {
        $query = "select country_code,name from country order by name asc";
        $result = GetResultsSet($query);
        return $result;
    }
    function ShowFormValue($fieldName)
    {
        if(isset($_SESSION['postVars'][$fieldName]))
            echo $_SESSION['postVars'][$fieldName];
    }
   
   function isSelected($selectedValue,$optionValue)
   {
      if($selectedValue == $optionValue)
         return "selected";
      return "";
   }

    function NormalDateToMysql($normal)
    {
        global $months;
        $monthNumbers=array_flip($months);
        $a=explode(',',$normal);
        $y=$a[1];
        $b=explode(' ',$a[0]);

        $m=$monthNumbers[$b[0]];
        $mySqlDate=$y."-".$m."-".$b[1];
        return $mySqlDate;
    }
    function GetOtherSettingsValue($discard) //discard this value
    {
        
        global $settingsArr;
        $settings=0;
        foreach($settingsArr as $key=>$val)
        {
            if($key!=$discard)
                $settings+=$val;
        }

        return $settings;
    }    
   function WriteFile($fileName,$content,$mode = "a",$lineSperator="\n")
   {
        
      if (!$handle = fopen($fileName, $mode)) 
      {
          echo "Cannot open file ($fileName)";
          exit;
      }
      if (fwrite($handle, $content.$lineSperator) === FALSE)
      {
         echo "Cannot write to file ($fileName)";
         exit;
      }
      //echo "Success;
      fclose($handle);

  }
  function FillWithNA($array)
  {
      $arrayTrimmed=TrimDeep($array);
      foreach($arrayTrimmed as $k=>$v)
      {
          if(is_null($v) || $v=='')
             $array[$k]='N\A';
      }
      return $array;
  }

  function entityEscapeUTF8($array)
  {
      //foreach
      $codes=array("&"=>"&amp;", "'"=>"&apos;", '"'=>"&quot;", ">"=>"&gt;", "<"=>"&lt;");
      foreach($array as $k=>$v)
      {
          
      }
  }
         
  function MakeHtmlTable($items,$itemsPerRow,$tableClass='')
  {
      $html="<table class='$tableClass'>
             <tr>";
      $count=0;
      foreach($items as $item)
      {
          $html.="
                  <td>$item</td>";
          ++$count;
          if($count%$itemsPerRow==0)
              $html.="
              </tr><tr>";
      }
      $i=$count%$itemsPerRow;
      while($i)
      {
          $html.="<td></td>";
          --$i;
      }
      $html.="
              </tr>
              </table>";
      return $html;
  }

  function ArrayToXML($array)
  {
      //EchoPre($array);
      $xml='';
      foreach($array as $k=>$v)
          $xml.="<$k>$v</".$k.">";
      return $xml;
  } 
function GetCountryCallingCode($iso2Code)
{
    $row=GetResultRow("select itu_calling from country_calling_codes where iso2_alpha='$iso2Code'");
    if(is_array($row))
        return $row['itu_calling'];
    return "";

}
     
function PrintArrayToCSV($items,$filename)
{          
        header("Pragma: no-cache");
        header("Expires: 0");     
        header("Cache-Control: private");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Description: File Transfer");    
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $count=0;
        foreach($items as $item)
        {
            if(!$count)
            {
                $tempArr=array();
                foreach($item as $k=>$v)
                {
                    $tempArr[]='"'.addSlashes($k).'"';
                }       
                $line=implode(",",$tempArr);
                echo $line,"\n";

            }
            ++$count;         
            $tempArr=array();
            foreach($item as $v)
            {
                $tempArr[]='"'.addSlashes($v).'"';
            }       
            $line=implode(",",$tempArr);
            echo $line,"\n";
            //$line=implode(",",$item);
            //echo $line,"\n";
        }
}  
function MysqlRowsToSet($mysqlRows,$isNumber=false) //must have single field input array(0=>array('single'=>11),1=>array('single'=>15),2=>array('single'=>11))
{
    $set='';
    $comma='';
    if($isNumber)
        $delim='';
    else
        $delim="'";
    foreach($mysqlRows as $aRow)
    {
        $set.=$comma.$delim.array_pop($aRow).$delim;
        $comma=",";
    }
    return "(".$set.")";
}
  
?>