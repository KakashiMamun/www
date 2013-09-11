<?php
    require_once('../includes/backIncludes.php');
    $toSuspend=(int)$_POST['id'];
    $ownerId=Administrator::GetOwnerId($currentUserId);
    switch($_POST['type'])
    {              
        case 'company':
             $info=Company::GetInfo($toSuspend);
             break;
        case 'site':
             $info=Site::GetInfo($toSuspend);
             break;
    }
    if($info['owner_id']!=$ownerId)
        return "You are not permitted to suspend it";
    $error="Reinstated";
                       
    switch($_POST['type'])
    {              
        case 'company':
             $error=Company::ChangeStatus($toSuspend,'active');
             break;
        case 'site':
             if(Site::IsExpired($toSuspend))
             {
                 echo "This site is expired. Cannot reinstate.";
                 exit();
             }
             $error=Site::ChangeStatus($toSuspend,'active');
             break;
    }
    if($error === true)
        $error='Reinstated';
    else
        $error='Operation failed due to DB error';
    echo $error;

?>