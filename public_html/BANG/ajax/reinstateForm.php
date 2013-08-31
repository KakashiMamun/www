<?php
    require_once('../includes/backIncludes.php');
    $toReinstate=(int)$_POST['userId'];
    $suspendUserInfo=User::GetInfo($toReinstate);
    $html='';                 
    $sitesHavingWG=Site::GetHavingWorkgroup($currentUserId);
    $hideUnassociated=true;
    $associatedWGs=array();
    $associatedWGIds=array();
    switch($suspendUserInfo['class'])
    {                    
        case 'SuperAdministrator':
             break;
        case 'Administrator':   
             //$associatedWGs=Workgroup::GetByAdministrator($toReinstate, $currentUserId);    
             //$sites=Site::Get(0,0,$currentUserId);
             $sites=Site::GetByAdministrator($toReinstate);
             require_once('../forms/siteHtml.php');

             $associatedWGs=Workgroup::GetByAdministrator($toReinstate, $currentUserId);
             break;
        case 'Recipient':
             //Recipient::GetReinstate($toReinstate,$currentUserId);
             $associatedWGs=Workgroup::GetByRecipient($toReinstate, $currentUserId);
             break;
    }
    foreach($associatedWGs as $aWG)
    {
        $associatedWGIds[]=$aWG['workgroup_id'];
    }
    require_once('../forms/workgroupHtml.php');
    //echo $html;

?>        
                           <form enctype="multipart/form-data" method="post" action="">
                               <div class='form dialogForm'>
                                    <div class='formHead dialogHead'>
                                         Reinstate details
                                    </div>             
                                    <div class='bigPadder'>
                                    <?php
                                        echo $siteHtml;
                                    ?>
                                    </div>
                                    <div class='bigPadder'>
                                    <?php
                                        echo $workgroupHtml; 
                                    ?>
                                    </div>

                                </div>                                                                     
                                <input type='hidden' name='userId' value="<?php echo $toReinstate; ?>">
                                <input type='hidden' name='formSubmitted' value="yes">
                                <input type='image' class='button border0' src='../images/update.png' name='' id='submit' value=' Submit '>
                           </form>