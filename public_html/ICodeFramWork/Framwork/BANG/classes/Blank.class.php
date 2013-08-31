<?php

class Blank
{
    /* member type is the class name of that member */                                              
    public static $insertFields=array();
    public static $updateFields=array('blankId');
    public static $tableName='blank';
    public static $idName='blank_id';
    public static $formIdName='blankId';
    public static $className='Blank';
    
    public static function Add()
    {                              
        if(($status=Blank::Validate())!==1)
            return $status;
        //process password
        $insertSql="insert into blank (password, email, reg_date,class, status)
                         values('".$_POST['email']."',now(),'".$_POST['class']."','".$_POST['status']."')";
        if(($blankId=ICodeDB::FreshInsertAndGetId($insertSql,Blank::$tableName))>0)
        {
            Blank::PassToSubClass('Add',$blankId);
            return $blankId;
        }                
        return 'Blank could not be created due to DB error';
    }      
    public static function Update()
    {      
        if(($status=Blank::Validate())!==1)
            return $status;
        //process password
                                   
        $updateOptions=array();
        if(isset($_POST['sample']))
            $updateOptions[]="sample = '{$_POST['sample']}'";

        $updateSql="update blank set ".implode(' , ',$updateOptions)." where blank_id=".$_POST['blankId'];
        $and='';

        return ICodeDB::Update($updateSql);
    }
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        if(isset($_POST[Blank::$formIdName]) && (int)$_POST[Blank::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=Blank::$updateFields;
        }
        else
            $mustFields=Blank::$insertFields;

        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation
        if($update)
        {
            if((int)$_POST[Blank::$formIdName]<=0)
                return "Invalid ".Blank::$formIdName;
            $uniqueCond='and blank_id!='.$_POST['blankId'];
            if((int)$_POST['blankId']==0 && $_POST['blankClass']!='Admin')
                return 'Invalid blank id';
            if(ICodeDB::IsKeyUsed(Blank::$tableName,'email',$_POST['email'],$uniqueCond))
                return "Email already used for another account.";
        }
        else
        {   
            if(ICodeDB::IsKeyUsed(Blank::$tableName,'email',$_POST['email']))
                return "Email already used for another account.";     
            if($_POST['password']!=$_POST['password2'])
                return "Passwords don't match";
        }
        return 1;
    }
    public static function Remove($id)
    {
        if(ICodeDB::Delete("delete from blank where blank_id='$id' limit 1"))
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
        return (ICodeDB::GetResultsSet("select * from blank $where  order by blank_id $upto"));

    }    


    
    public static function GetTotal()
    {

        $row=ICodeDB::GetResultRow("select count(*) as count from blank");
        return $row['count'];
    }                                         
    public static function GetDetailInfo($id)
    {
        return ICodeDB::GetResultRow("select * from blank_detail where blank_id='$id'");
    }             
    public static function GetInfo($id)
    {
        return ICodeDB::GetResultRow("select * from blank where blank_id='$id'");
    }
    public static function GetInfoByEmail($email)
    {
        //echo "<br>select * from blank where email='$email'<br>";
        return ICodeDB::GetResultRow("select * from blank where email='$email'");
    }
    
    public static function ChangeStatus($id,$status)
    {
        if(ICodeDB::Update("update blank set status='$status' where blank_id='$id'"))
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

}
?>