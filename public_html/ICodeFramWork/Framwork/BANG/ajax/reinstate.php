<?php
    require_once('../includes/backIncludes.php');
    $toSuspend=(int)$_POST['userId'];
    $suspendUserInfo=User::GetInfo($toSuspend);         
    $error="Reinstated";
    switch($suspendUserInfo['class'])
    {                    
        case 'SuperAdministrator':
             break;
        case 'Administrator':
             break;
        case 'Recipient':
             $error=Recipient::Reinstate($toSuspend,$currentUserId);
             break;
    }
    if($error === true)
        $error='Reinstated';
    echo $error;

?>