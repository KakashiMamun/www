<?php
    require_once('../includes/backIncludes.php');
    $toSuspend=(int)$_POST['userId'];
    $suspendUserInfo=User::GetInfo($toSuspend);         
    $error="Suspended";
    switch($suspendUserInfo['class'])
    {                    
        case 'SuperAdministrator':
             break;
        case 'Administrator':       
             $error=Administrator::Suspend($toSuspend,$currentUserId);
             break;
        case 'Recipient':
             $error=Recipient::Suspend($toSuspend,$currentUserId);
             break;
    }
    if($error === true)
        $error='Suspended';
    echo $error;

?>