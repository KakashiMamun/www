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
    $error="Suspended";
                       
    switch($_POST['type'])
    {              
        case 'company':
             $error=Company::ChangeStatus($toSuspend,'inactive');
             break;
        case 'site':
             $error=Site::ChangeStatus($toSuspend,'inactive');
             break;
    }
    if($error === true)
        $error='Suspended';
    else
        $error='Operation failed due to DB error';
    echo $error;

?>