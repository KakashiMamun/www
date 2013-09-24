<?php

class Administrator
{                                           
    //Page controls
    //this are the pages for which no navigation links are available. Those are actually linked in navigation pages.
    //So we will still check their permissions!             
    public static $subPages = array('payForSite');
    public static $topNavigationPages=
        array(
              'Notifications'=>
                     array(                    
                           'New'=>'newNotification',
                           'Log'=>'notificationLog',
                           'Search'=>'notificationSearch',
                           'SMS report'=>'smsReport'
                     ),                
              'Recipients'=>
                     array(       
                           'Add'=>'addRecipient',
                           'View'=>'manageRecipient'
                     ),           
              'Grouping + Associations'=>
                     array(                                                 
                           'Work Groups'=>array('Add workgroup'=>'addWorkgroup','View'=>'manageWorkgroup'),
                           'Trades'=>array('Add trade'=>'addTrade','View'=>'manageTrade'),
                           'Companies'=>array('Add company'=>'addCompany','View'=>'manageCompany')
                     ),          
              'Sites'=>
                     array(
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
    /* member type is the class name of that member */                                              
    public static $insertFields=array('ownerId');
    public static $updateFields=array('administratorId');
    public static $tableName='administrator';
    public static $idName='administrator_id';
    public static $formIdName='administratorId';
    public static $className='Administrator';
    
    public static function Add($administratorId)
    {                              
        if(($status=Administrator::Validate())!==1)
            return $status;
        $insertSql="replace into administrator (administrator_id,owner_id)
                         values('".$administratorId."','".$_POST['ownerId']."')";
        return ICodeDB::Replace($insertSql);
    }      
    public static function Update($administratorId)
    {                               
        if(isset($_POST['companyId']))
        {
            $companyInfo=Company::GetInfo($_POST['companyId']);
            $replace="replace into user_company(user_id, company_id,owner_id, status)
                              values
                              ({$administratorId}, {$_POST['companyId']},{$companyInfo['owner_id']}, 'active')";
            if(!ICodeDB::Replace($replace))
                $error[]="Company was not saved due to DB error";
        }
        return ICodeTools::ReturnError($error);
        //return true;
    }
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        if(isset($_POST[Administrator::$formIdName]) && (int)$_POST[Administrator::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=Administrator::$updateFields;
        }
        else
            $mustFields=Administrator::$insertFields;

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
        if(ICodeDB::Delete("delete from administrator where administrator_id='$id' limit 1"))
           return true;
    }
    public static function Get($start=0,$limit=0,$ownerId=0,$siteId=0,$workgroupId=0, $includeWorkgroups=false, $status='',  $from='',$to='') //pending email verification and phone verifications won't show up
    {               
        $upto='';
        $where='';

        $and='';
        $condition='';
        $statusQ='';     
        if($status!='')
        {
            $statusQ=" and status='$status' ";
        }   
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
        if($workgroupId!=0)
        {
            $condition.=$and. " administrator_id in (select administrator_id from administrator_workgroup where workgroup_id=$workgroupId $statusQ)";
            $and=' and ';   
        }

        if($siteId!=0)
        {
            $condition.=$and. " administrator_id in (select distinct administrator_id from site_administrator where site_id=$siteId $statusQ)";
            $and=' and ';
            if($includeWorkgroups)
                $condition.=" or administrator_id in (select distinct administrator_id from administrator_workgroup where workgroup_id in (select workgroup_id from workgroup where site_id=$siteId) $statusQ)";
            $and=' and ';   
        }   
        if($ownerId!=0)
        {
            $condition.=$and. " owner_id=$ownerId";
            $and=' and ';
        }    


        if($limit>0)
            $upto=" limit $start,$limit";

        $where.=$condition;
        if($where!='')
            $where=' where '. $where;
        $q="select * from administrator $where order by administrator_id $upto";
        //echo $q;
        return (ICodeDB::GetResultsSet($q));

    }    

    public static function GetIds($ownerId=0,$siteId=0,$workgroupId=0, $includeWorkgroups=false, $status='') //pending email verification and phone verifications won't show up
    {
        $administrators=Administrator::Get(0,0,$ownerId,$siteId,$workgroupId,$includeWorkgroups, $status);
        $administratorIds=array();
        foreach($administrators as $aAd)
            $administratorIds[]=$aAd['administrator_id'];
        return $administratorIds;
    } 


    
    public static function GetTotal($ownerId=0,$siteId=0,$workgroupId=0,$includeWorkgroups=false, $status='',  $from='',$to='') //pending email verification and phone verifications won't show up
    {
        $where='';

        $and='';
        $condition='';   
        $statusQ='';      
        if($status!='')
        {
            $statusQ=" and status='$status' ";
        }        
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
        if($workgroupId!=0)
        {
            $condition.=$and. " administrator_id in (select administrator_id from administrator_workgroup where workgroup_id=$workgroupId $statusQ)";
            $and=' and ';   
        }               
        if($siteId!=0)
        {
            $condition.=$and. " administrator_id in (select distinct administrator_id from site_administrator where site_id=$siteId $statusQ)";
            $and=' and ';
            if($includeWorkgroups)
                $condition.= " or administrator_id in (select distinct administrator_id from administrator_workgroup where workgroup_id in (select workgroup_id from workgroup where site_id=$siteId) $statusQ)";
            $and=' and ';   
        }   
        if($ownerId!=0)
        {
            $condition.=$and. " owner_id=$ownerId";
            $and=' and ';
        }    


        $where.=$condition;
        if($where!='')
            $where=' where '. $where;
        $q="select count(*) as count from administrator $where";
        //echo $q;
        $row=ICodeDB::GetResultRow($q);
        return $row['count'];
    }

    public static function GetInfo($id)
    {
        return ICodeDB::GetResultRow("select * from administrator where administrator_id='$id'");
    }

    public static function ChangeStatus($id,$status)
    {
        if(ICodeDB::Update("update administrator set status='$status' where administrator_id='$id'"))
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
    public static function AssignSite($siteId,$administratorId,$isSuper='no')
    {
        $replace="replace into site_administrator(site_id,administrator_id, is_super) values($siteId,$administratorId,'$isSuper')";
        return ICodeDB::Replace($replace);
    }
    public static function SuspendSite($siteId,$administratorId)
    {
        $delete="update site_administrator set status='inactive' where site_id=$siteId and administrator_id=$administratorId";
        return ICodeDB::Update($delete);
    }
    public static function AssignWorkgroup($workgroupId,$administratorId,$isSuper='no')
    {
        $replace="replace into administrator_workgroup(workgroup_id,administrator_id) values($workgroupId,$administratorId)";
        //echo $replace;
        return ICodeDB::Replace($replace);
    }
    public static function SuspendWorkgroup($workgroupId,$administratorId)
    {
        $delete="update administrator_workgroup set status='inactive' where workgroup_id=$workgroupId and administrator_id=$administratorId";
        //echo $delete;
        return ICodeDB::Update($delete);
    }

    public static function ChangeSupership($isSuper='no')
    {      
        return ICodeDB::Update("update administrator set is_super='$isSuper' where administrator_id='$id'");
    }

    public static function GetOwnerId($userId)
    {                           
        global $currentUserId, $currentUserLoginInfo;
        

        if($userId!=$currentUserId)
        {
            $userInfo=User::GetInfo($userId);
        }
        else
        {
            $userInfo=$currentUserLoginInfo;
        }
        if($userInfo['class']=='SuperAdministrator')
            return $userInfo['user_id'];
        else
        {     
            $administratorInfo=Administrator::GetInfo($userInfo['user_id']);
            return $administratorInfo['owner_id'];
        }
    }     

    public static function Suspend($administratorId, $poweredId)
    {
        // gather all the association
        $workgroups=Workgroup::GetByAdministrator($administratorId, $poweredId, 'active');
        $error=array();
        foreach($workgroups as $aWG)
        {
            if(!Administrator::SuspendWorkgroup($aWG['workgroup_id'],$administratorId))
                $error[]="Suspension failed for workgroup # ({$aWG['workgroup_id']},$administratorId)";
        }
        
        $sites=Site::GetByAdministrator($administratorId);
        foreach($sites as $aS)
        {
            if(!Administrator::SuspendSite($aS['site_id'],$administratorId))
                $error[]="Suspension failed for site # ({$aS['site_id']},$administratorId)";
        }
        
        return ICodeTools::ReturnError($error);

    }

    public static function IsSuspended($administratorId,$poweredId)
    {   
        $workgroups=Workgroup::GetByAdministrator($administratorId,$poweredId,'active');
        if(empty($workgroups))
            return true;
        return false;
    }

    public static function Reinstate()
    {

        $administratorId=(int)$_POST['userId'];
        if(!isset($_POST['workgroupId']) && !isset($_POST['siteId']))
            return;
        //reinstate workgroups
                                       
        if(isset($_POST['workgroupId']))
        {                        
            $WGIds=$_POST['workgroupId'];
            foreach($WGIds as $aWGId)
            {
                Administrator::AssignWorkgroup($aWGId,$administratorId);
            }
        }
        if(isset($_POST['siteId']))
        {                        
            $siteIds=$_POST['siteId'];
            foreach($siteIds as $aSId)
            {
                Administrator::AssignSite($aSId,$administratorId);
            }
        }
        //reinstate companies
    }

}
?>