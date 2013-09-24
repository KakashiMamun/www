<?php

class SMS
{
    /* member type is the class name of that member */                                              
    public static $insertFields=array();
    public static $updateFields=array('smsId');
    public static $tableName='sms';
    public static $idName='sms_id';
    public static $formIdName='smsId';
    public static $className='SMS';
    
    public static function Add()
    {                              
        if(($status=SMS::Validate())!==1)
            return $status;
        //process password
        $insertSql="insert into sms (password, email, reg_date,class, status)
                         values('".$_POST['email']."',now(),'".$_POST['class']."','".$_POST['status']."')";
        if(($smsId=ICodeDB::FreshInsertAndGetId($insertSql,SMS::$tableName))>0)
        {
            SMS::PassToSubClass('Add',$smsId);
            return $smsId;
        }                
        return 'SMS could not be created due to DB error';
    }      
    public static function Update()
    {      
        if(($status=SMS::Validate())!==1)
            return $status;
        //process password
                                   
        $updateOptions=array();
        if(isset($_POST['sample']))
            $updateOptions[]="sample = '{$_POST['sample']}'";

        $updateSql="update sms set ".implode(' , ',$updateOptions)." where sms_id=".$_POST['smsId'];
        $and='';

        return ICodeDB::Update($updateSql);
    }
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        if(isset($_POST[SMS::$formIdName]) && (int)$_POST[SMS::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=SMS::$updateFields;
        }
        else
            $mustFields=SMS::$insertFields;

        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation
        if($update)
        {
            if((int)$_POST[SMS::$formIdName]<=0)
                return "Invalid ".SMS::$formIdName;
            $uniqueCond='and sms_id!='.$_POST['smsId'];
            if((int)$_POST['smsId']==0 && $_POST['smsClass']!='Admin')
                return 'Invalid sms id';
            if(ICodeDB::IsKeyUsed(SMS::$tableName,'email',$_POST['email'],$uniqueCond))
                return "Email already used for another account.";
        }
        else
        {   
            if(ICodeDB::IsKeyUsed(SMS::$tableName,'email',$_POST['email']))
                return "Email already used for another account.";     
            if($_POST['password']!=$_POST['password2'])
                return "Passwords don't match";
        }
        return 1;
    }
    public static function Remove($id)
    {
        if(ICodeDB::Delete("delete from sms where sms_id='$id' limit 1"))
           return true;
    }
    public static function Get($start=0,$limit=0, $from='',$to='') //pending email verification and phone verifications won't show up
    {
        $upto='';
        $where='';
        $and='';
        $condition='';
        if($from!='')
        {
            $condition.=$and." date>='$from'";
            $and=' and ';
        }
        if($to!='')
        {
            $condition.=$and." date<='$to'";
            $and=' and ';
        }
        $where.=$condition;
        if($where!='')
            $where=' where '. $where;

        if($limit>0)
            $upto=" limit $start,$limit";
        return (ICodeDB::GetResultsSet("select * from sms $where  order by sms_id $upto"));

    }    


    
    public static function GetTotal()
    {

        $row=ICodeDB::GetResultRow("select count(*) as count from sms");
        return $row['count'];
    }                                         
    public static function GetDetailInfo($id)
    {
        return ICodeDB::GetResultRow("select * from sms_detail where sms_id='$id'");
    }             
    public static function GetInfo($id)
    {
        return ICodeDB::GetResultRow("select * from sms where sms_id='$id'");
    }
    public static function GetInfoByEmail($email)
    {
        //echo "<br>select * from sms where email='$email'<br>";
        return ICodeDB::GetResultRow("select * from sms where email='$email'");
    }
    
    public static function ChangeStatus($id,$status)
    {
        if(ICodeDB::Update("update sms set status='$status' where sms_id='$id'"))
          return "Status updated";
        return "Status not updated due to DB failure";
    }             
    public static function GetImage($id)
    {
        global $BLANK_IMG_DIR,$BLANK_IMG_URL;
        if(($ext=SearchImgFileExt($BLANK_IMG_DIR.$id))===false)
            return $BLANK_IMG_URL."noImg.png";
        return $BLANK_IMG_URL.$id.".$ext";
    }  
    public static function GetImagePath($id)
    {
        global $BLANK_IMG_DIR,$BLANK_IMG_URL;
        if(($ext=SearchImgFileExt($BLANK_IMG_DIR.$id))===false)
            return false;
        return $BLANK_IMG_DIR.$id.".$ext";
    }
    public static function FormatNumber($number)
    {
        $number=str_replace(array(' ','+','-','(',')','.',','),'',$number);
        if(is_numeric($number))
        {
            $firstChar=substr($number,0,1);
            if($firstChar=='0')
            {
                $number='44'.substr($number,1,strlen($number));
            }
        }
        return $number;
    }

    public static function CreditsNeeded($from,$toArr)
    {                       
        $toArr=array_filter($toArr);
        if(empty($toArr))
            return 0;                 
        $from=SMS::FormatNumber($from);
        $message='hi';
        $numbersString='';
        $processedNumbers=array();
        foreach($toArr as $aNumber)
        {
            $processedNumbers[]=SMS::FormatNumber($aNumber);

        }
        $numbersString=implode(',',$processedNumbers);

        global $CONFIGURATIONS;           
        $uname = $CONFIGURATIONS['SMS_ACCOUNT'];
        $pword = $CONFIGURATIONS['SMS_PASSWORD'];    
        $gateway= $CONFIGURATIONS['SMS_GATEWAY'];     
        //$test= $CONFIGURATIONS['SMS_TEST_MODE'];
        //$debug= $CONFIGURATIONS['SMS_DEBUG'];
        $test= 1;
        $debug= 1;
        $jsonMode=0;
        $uname = "tom@surefixdirect.com";
        $pword = "6aee53";
        $gateway='http://www.txtlocal.com/sendsmspost.php';
        //print_r($CONFIGURATIONS);
        // Configuration variables
        //$debug = "1";
        //$test = "0";
        $rcpurl = "";

        // Data for text message

        //$selected_numbers = implode(",",$mobile_numbers);
        $message = urlencode($message);

        // Prepare data for POST request
        $data = "uname=".$uname."&pword=".$pword."&message=".$message."&from=". $from."&selectednums=".$numbersString."&info=".$debug."&test=".$test."&json=".$jsonMode;

        // Send the POST request with cURL
        $ch = curl_init($gateway);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); //This is the result from Txtlocal
        curl_close($ch);
        //print_r($toArr);
        //print_r($processedNumbers);
        //echo "<br>$result<br>";
        if(preg_match("/CreditsRequired=([0-9\.]+)/i",$result,$matches))
        {
            //print_r($matches);
            return $matches[1];
        }     
        return 0;
    }
    public static function Send($from,$toArr,$message)
    {
        $toArr=array_filter($toArr);
        if(empty($toArr))
            return 0;
        $from=SMS::FormatNumber($from);
        $numbersString='';
        $processedNumbers=array();
        foreach($toArr as $aNumber)
        {
            $processedNumbers[]=SMS::FormatNumber($aNumber);

        }
        $numbersString=implode(',',$processedNumbers);

        global $CONFIGURATIONS;           
        $uname = $CONFIGURATIONS['SMS_ACCOUNT'];
        $pword = $CONFIGURATIONS['SMS_PASSWORD'];    
        $gateway= $CONFIGURATIONS['SMS_GATEWAY'];
        $test= $CONFIGURATIONS['SMS_TEST_MODE'];
        $debug= $CONFIGURATIONS['SMS_DEBUG'];
        $uname = "tom@surefixdirect.com";
        $pword = "6aee53";
        $gateway='http://www.txtlocal.com/sendsmspost.php';
        print_r($CONFIGURATIONS);
        // Configuration variables
        //$debug = "1";
        //$test = "0";
        $rcpurl = "";

        // Data for text message

        //$selected_numbers = implode(",",$mobile_numbers);
        $message = urlencode($message);

        // Prepare data for POST request
        $data = "uname=".$uname."&pword=".$pword."&message=".$message."&from=". $from."&selectednums=".$numbersString."&info=".$debug."&test=".$test;

        // Send the POST request with cURL
        $ch = curl_init($gateway);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); //This is the result from Txtlocal
        curl_close($ch);           
        if(preg_match("/CreditsRequired=([0-9\.]+)/i",$result,$matches))
        {
            //print_r($matches);
            return $matches[1];
        }     
        return 0;
    }

}
?>