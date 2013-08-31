<?php
class Director
{                                      
    //Page controls
    //this are the pages for which no navigation links are available. Those are actually linked in navigation pages.
    //So we will still check their permissions!
    public static $subPages = array('payForSite');
    public static $topNavigationPages=
        array(
              'Administrators'=>
                     array(       
                           'Add'=>'addAdministrator',  
                           'View'=>'manageAdministrator'
                     ),                                        
              'Grouping + Associations'=>
                     array(                                                 
                           'Work Groups'=>array('Add workgroup'=>'addWorkgroup','View'=>'manageWorkgroup'),
                           'Trades'=>array('Add trade'=>'addTrade','View'=>'manageTrade'),
                           'Companies'=>array('Add company'=>'addCompany','View'=>'manageCompany')
                     ),    
              'Sites'=>
                     array(       
                           'Add'=>'addSite',
                           'View'=>'manageSite'
                     ), 
              'Preferences'=>
                     array(       
                           'Profile'=>'editProfile',
                           'Login'=>'loginCredential',
                           'Menu Timeout'=>'menuTimeout'
                     )
             );            
    public static function GetNavigation($type='top')
    {
        switch($type)
        {                                               
            case 'top':
                 return self::$topNavigationPages;
            case 'sub':
                 return self::$subPages;
        }
    }                                                   
    /*Page control ends*/

    /* member type is the class name of that member */                                                          
    //public static $insertFields=array('companyNameInv','address1Inv','stateIdInv','cityIdInv','postcodeInv');
    public static $insertFields=array();
    public static $updateFields=array();
    public static $tableName='super_administrator';
    public static $idName='super_administrator_id';
    public static $formIdName='userId';
    public static $className='Director';
            
    public static function Add($DirectorId)
    {
        //process password
        return true;
        $address=serialize(array_filter(array($_POST['address1Inv'],$_POST['address2Inv'],$_POST['address3Inv'])));

        $insert="replace into super_administrator (super_administrator_id, inv_companyName, inv_address,inv_state_id, inv_city_id, inv_postcode)
                         values(
                         '$DirectorId','".$_POST['companyNameInv']."','$address', '".$_POST['stateIdInv']."','".$_POST['cityIdInv']."',
                         '".$_POST['postcodeInv']."'
                         )";
        if(ICodeDB::Replace($insert))
        {
            return true;
        }
        return false;
    }      
    public static function Update($DirectorId)
    {      
        return true;
    }              
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        $delimiter="'";
        if(isset($_POST[Director::$formIdName]) && (int)$_POST[Director::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=Director::$updateFields;
        }
        else
            $mustFields=Director::$insertFields;

        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation
        if($update)
        {
        }
        else
        {
        }
        return 1;
    }    
    public static function Remove($id)
    {
        if(ICodeDB::Delete("delete from super_administrator where super_administrator_id='$id' limit 1"))
           return true;
        return false;
    }   
    public static function GetInfo($id)
    {
        return ICodeDB::GetResultRow("select * from super_administrator where super_administrator_id='$id'");
    }                                                           
    public static function GetIdsByRecipient($rId)
    {
        // select workgroup_id from recipient_workgroup where recipient_id=$rId
        $workgroupQ="select workgroup_id from recipient_workgroup where recipient_id=$rId";
        $siteIdQ="select site_id from workgroup where workgroup_id in ($workgroupQ)";
        $siteQ="select owner_id from site where site_id in($siteIdQ)";
        $companyQ="select owner_id from company where company_id in (select company_id from user_company where user_id=$rId)";

        $ownerQ="select distinct owner_id from ($siteQ) as s_u union ($companyQ)";
        //echo "<b>$siteQ</b>";
        $owners=ICodeDB::GetResultsSet($ownerQ);

        $superUserIds=array();
        foreach($owners as $aO)
            $superUserIds[]=$aO['owner_id'];
        return $superUserIds;
        
    }

    public static function GetHtmlOption($selectedId=0,$status='')
    {                                               
        $superUsers=User::Get(0,0,'Director', $status);
        $html='';
        //print_r($superUsers);
        foreach($superUsers as $anUser)
        {
            $anUser=User::GetCompleteInfo($anUser['user_id']);
            if($selectedId==$anUser['user_id'])
                $html.="<option selected value='{$anUser['user_id']}'>{$anUser['f_name']} {$anUser['l_name']}</option>";
            else
                $html.="<option value='{$anUser['user_id']}'>{$anUser['f_name']} {$anUser['l_name']}</option>";
        }

        return $html;
    }

}