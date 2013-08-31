<?php

class Company
{
    /* member type is the class name of that member */                                              
    public static $insertFields=array('ownerId','name');
    public static $updateFields=array('ownerId','companyId','name');
    public static $tableName='company';
    public static $idName='company_id';
    public static $formIdName='companyId';
    public static $className='Company';
    
    public static function Add()
    {                              
        if(($status=Company::Validate())!==1)
            return $status;
        $insertSql="insert into company (name,description,owner_id)
                         values('".$_POST['name']."','".$_POST['description']."','".$_POST['ownerId']."')";
        if(($companyId=ICodeDB::FreshInsertAndGetId($insertSql,'company'))>0)
        {
            return $companyId;
        }                
        return 'Company could not be added due to DB error';
    }      
    public static function Update()
    {      
        if(($status=Company::Validate())!==1)
            return $status;      
        $updateSql="update company set
                           name='".$_POST['name']."',
                           description='".$_POST['description']."'
                           where company_id=".$_POST['companyId'];
        return ICodeDB::Update($updateSql);

    }
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        if(isset($_POST[Company::$formIdName]) && (int)$_POST[Company::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=Company::$updateFields;
        }
        else
            $mustFields=Company::$insertFields;

        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation    
        if($update)
        {        
            $uniqueCond='and company_id!='.$_POST['companyId'].' and owner_id='.$_POST['ownerId'];
            if(ICodeDB::IsKeyUsed(Company::$tableName,'name',$_POST['name'],$uniqueCond))
                return "Name already used for another company for the same owner.";
        }
        else
        {   
            $uniqueCond=' and owner_id='.$_POST['ownerId'];
            if(ICodeDB::IsKeyUsed(Company::$tableName,'name',$_POST['name'],$uniqueCond))
                return "Name already used for another company for the same owner.";
        }
        return 1;
    }
    public static function Remove($id)
    {
        if(ICodeDB::Delete("delete from company where company_id='$id' limit 1"))
           return true;
    }                           
    public static function ChangeStatus($id,$status)
    {
        return ICodeDB::Update("update company set status='$status' where company_id='$id'");
    }

    public static function Get($start=0,$limit=0, $ownerId=0,$status='', $from='',$to='') //pending email verification and phone verifications won't show up
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

        if($status!='')
        {
            $condition.=$and." status = '$status'";   
            $and=' and ';
        }   
        if($ownerId!=0)
        {
            $realOwnerId=Administrator::GetOwnerId($ownerId);
            $condition.=$and. " owner_id=$realOwnerId";
        }    


        if($limit>0)
            $upto=" limit $start,$limit";

        $where.=$condition;
        if($where!='')
            $where=' where '. $where;


        return (ICodeDB::GetResultsSet("select * from company  $where order by name $upto"));

    }

    
    public static function GetTotal($ownerId=0,$status='', $from='',$to='') //pending email verification and phone verifications won't show up
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

        if($status!='')
        {
            $condition.=$and." status = '$status'";   
            $and=' and ';
        }   
        if($ownerId!=0)
        {
            $realOwnerId=Administrator::GetOwnerId($ownerId);
            $condition.=$and. " owner_id=$realOwnerId";
        }    

        $where.=$condition;
        if($where!='')
            $where=' where '. $where;

        $res=ICodeDB::GetResultRow("select count(*) as total from company  $where");
        return $res['total'];

    }

    public static function GetInfo($id)
    {
        return ICodeDB::GetResultRow("select * from company where company_id='$id'");
    }    
    public static function GetHtmlOptions($ownerId,$selectedId=0,$status='')
    {
        $companies=Company::Get(0,0,$ownerId,$status);
        $html='';
        foreach($companies as $aCompany)
        {
            if($selectedId==$aCompany['company_id'])
                $html.="<option selected value='{$aCompany['company_id']}'>{$aCompany['name']}</option>";
            else
                $html.="<option value='{$aCompany['company_id']}'>{$aCompany['name']}</option>";
        }
        return $html;
    }

    public static function GetByUser($userId,$ownerId)
    {                     
        return ICodeDB::GetResultRow("select * from company where company_id in (select company_id from user_company where user_id=$userId and owner_id=$ownerId)");
        
    }


}
?>