<?php                                                
    require_once('includes/frontIncludes.php');
    $NVPairs=ICodeTools::GetArrayFromToken();
    print_r($NVPairs);
    switch($NVPairs['class'])
    {
        case 'NotificationTarget':
             NotificationTarget::Read($NVPairs['notificationTargetId'], $NVPairs['receiverId']);
             break;
    }
?>
        