<?php
class ICodeMailTemplate
{                                                                                                      
    public static $insertFields=array('memberId','memberType','subject','content','name','event');
    public static $updateFields=array('templateId','memberId','memberType','subject','content','name','event');
    public static $tableName='icode_mail_template';  
    public static $idName='mail_template_id';
    public static $formIdName='templateId';
    public static $className='ICodeMailTemplate';
    /* functions */
    public static function Add()
    {
        if(($status=ICodeMailTemplate::Validate())!==1)
            return $status;
        $memberType=$_POST['memberType'];
        $memberId=(int)$_POST['memberId'];
        $subject    = $_POST['subject'];
        $content    = $_POST['content'];
        $templateName= $_POST['name'];
        $event=$_POST['event'];

        $insert="INSERT INTO icode_mail_template (member_id,member_type,name,subject,content,event)
                 VALUES
                 ($memberId,'$memberType','$templateName','$subject','$content','$event')";
        $error= ICodeDB::FreshInsert($insert);
        if($error>0)
            $icodeError[]='Mail Template saved.';
        else    
            $icodeError[]='Mail Template couldn\'t be saved due to DB error';
        //print_r($icodeError);
        return ICodeError::GetErrorHtml($icodeError);
        
    }                            
    public static function Validate()
    {
        //check non empty, not isset, etc
        if(isset($_POST[ICodeMailTemplate::$formIdName]) && (int)$_POST[ICodeMailTemplate::$formIdName]>0) //means update
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
    public static function Get($start=0,$limit=0,$memberId=0)
    {
        $condition = "";
        $upto='';
        if(intval($memberId) !== 0)
        {
            $condition = " WHERE member_id=$memberId ";
        }
        if($limit>0)
            $upto=" limit $start,$limit";
        $sql = "SELECT * FROM icode_mail_template ".$condition." LIMIT $start,".$perPage;
        return ICodeDB::GetResultsSet($sql);
    }

    public static function GetInfo($templateId)
    {
        $sql = "SELECT * FROM icode_mail_template WHERE mail_template_id ='{$templateId}'";
        return ICodeDB::GetResultRow($sql);
    }    
    public static function GetTotal($memberId=0)
    {
        $condition = "";
        if(intval($memberId) !== 0)
        {
            $condition = " WHERE member_id=$memberId ";
        }
        $sql = "SELECT count(*) AS total FROM icode_sl_mail_template".$condition;
        $mailTemplates = CodeDB::GetResultRow($sql);
        return $mailTemplates['total'];
    }
      
    public static function Remove($templateId)
    {
        if (IcodeDb::Delete("delete from icode_sl_mail_template where mail_template_id=$templateId limit 1"))
            return "Removed";
        return "DB error";
    }
}
?>