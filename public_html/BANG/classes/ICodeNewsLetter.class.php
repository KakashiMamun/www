<?php
class ICodeNewsLetter
{   
    /* member type is the class name of that member */                                              
    public static $insertFields=array('memberId','memberType','subject','content','hideSender','targetType','numberOfRecipient');
    public static $updateFields=array('newsletterId','memberId','memberType','subject','content','hideSender','targetType','numberOfRecipient');
    public static $tableName='icode_newsletter';
    public static $idName='newsletter_id';
    public static $formIdName='templateId';
    public static $className='ICodeNewsLetter';
    public static $shortCodes=array('%firstname%','%lastname%','%email%','%username%','%password%');
    /* functions */
    public static function Add()
    {                               
        if(($status=ICodeNewsLetter::Validate())!==1)
            return $status;
        $memberType=$_POST['memberType'];
        $targetType=$_POST['targetType'];
        $memberId=(int)$_POST['memberId'];
        $memberInfo = call_user_func(array($memberType,'GetInfo'),$memberId);
        print_r($memberInfo);
        $icodeError=array();
        $hideSender = $_POST['hideSender'];
        $subject    = $_POST['subject'];
        $content    = $_POST['content'];                                                                              
        $numberOfRecipient    = 0; // 0 means all current members, a number means
        if(isset($_POST['numberOfRecipient']))
            $numberOfRecipient    = intval($_POST['numberOfRecipient']); // 0 means all current members, a number means

        //$content=preg_replace(/"[^(href)(src)]+[ =]+[ ]*
        $insertMailSql = "INSERT INTO icode_newsletter
                       (member_id,hide_sender,subject,content,number_of_recipient,
                       date_created,target_type,member_type)
                        VALUES
                        ('{$memberId}','{$hideSender}','{$subject}','{$content}','{$numberOfRecipient}',
                        NOW(),'$targetType','$memberType')"
                        ;
        $error=ICodeDB::FreshInsert($insertMailSql);
        if($error>0)
            $icodeError[]='Mail saved and will be scheduled shortly';
        else    
            $icodeError[]='Mail couldn\'t be saved due to DB error';
            
        if(isset($_POST['isTemplate']))//want to save as template
        {
            $error=ICodeMailTemplate::Add();
        }
        return ICodeError::GetErrorHtml($icodeError).$error;
    }   
    public static function Validate()
    {
        //check non empty, not isset, etc
        if(isset($_POST[ICodeNewsLetter::$formIdName]) && (int)$_POST[ICodeNewsLetter::$formIdName]>0) //means update    
            $mustFields=ICodeMailTemplate::$updateFields;
        else                                   
            $mustFields=ICodeMailTemplate::$insertFields;
        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation
        if((int)$_POST['memberId']==0 && $_POST['memberType']!='Admin')
            return 'Invalid member id';
        return 1;
    }
    public static function Update()
    {
    }   
    public static function Remove($newsLetterId)
    {
        if (IcodeDb::Delete("delete from icode_newsletter where newsletter_id=$newsLetterId limit 1"))
            return "Removed";
        return "DB error";
    }           
    
    public static function Get($start=0, $limit=0, $filters)
    {
        $upto = '';
        if ($limit > 0)
            $upto = " limit $start,$limit";
        return IcodeDb::GetResultsSet("select * from icode_newsletter order by newsletter_id asc $upto");
    }
    public static function GetTotal()
    {
        $query = "select count(newsletter_id) as count from icode_newsletter";
        $row = IcodeDb::GetResultRow($query);
        return $row['count'];
    } 

    public static function GetInfo($newsLetterId) {
        $query = "select * from icode_newsletter where newsletter_id=$newsLetterId";
        return ICodeDB::GetResultRow($query);
    }         

    public static function ReplaceShortCodes($message,$shortcodes,$data)
    {
        //$shortcodes = array('%username%','%password%','%firstname%','%lastname%','%activationlink%');
        //$data = array($clientInfo['username'],$clientInfo['password'],$clientInfo['first_name'],$clientInfo['last_name'],$clientInfo['activation_link']);
        $message = str_replace($shortcodes,$data,$message);
        return $message;
    }

    /* template section*/
}
?>